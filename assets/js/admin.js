(function () {
  const csrf = () => document.getElementById('admin-csrf')?.value || '';

  function apiUrl(path) {
    const root = typeof window.ADMIN_BASE === 'string' ? window.ADMIN_BASE : '/';
    return root.replace(/\/?$/, '/') + String(path).replace(/^\//, '');
  }

  function statusBadge(value) {
    const key = String(value || '').toLowerCase().replace(/[^a-z0-9]+/g, '-');
    return `<span class="admin-status admin-status--${key}">${escapeHtml(String(value || '').replace(/_/g, ' '))}</span>`;
  }

  function escapeHtml(str) {
    return String(str)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;');
  }

  function fmtDate(value) {
    if (!value) return '—';
    const d = new Date(value.replace(' ', 'T'));
    if (Number.isNaN(d.getTime())) return value;
    return d.toLocaleDateString(undefined, { day: '2-digit', month: 'short', year: 'numeric' });
  }

  async function postAction(url, payload) {
    const body = new URLSearchParams({ ...payload, csrf_token: csrf() });
    const res = await fetch(url, {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body,
    });
    return res.json();
  }

  function palette() {
    return ['#163628', '#1f6b45', '#3d7a55', '#4f8a62', '#6fa880', '#8fba98', '#2a2f2c', '#5a635c'];
  }

  function seriesFrom(rows) {
    return {
      labels: (rows || []).map((r) => r.label),
      values: (rows || []).map((r) => Number(r.value)),
    };
  }

  function initKenyaCaseMap() {
    const raw = document.getElementById('admin-map-data');
    const el = document.getElementById('kenya-cases-map');
    if (!raw || !el || !window.L) return;

    const payload = JSON.parse(raw.textContent || '{}');
    const points = Array.isArray(payload.points) ? payload.points : [];
    const map = L.map(el, {
      zoomControl: true,
      scrollWheelZoom: false,
      attributionControl: true,
      maxZoom: 12,
      minZoom: 5,
    }).setView([-0.5, 37.5], 6);

    // Free OSM tiles (no API key). Kept light so GeoJSON + dots remain the focus.
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
      maxZoom: 12,
      minZoom: 5,
      className: 'admin-map-tiles',
    }).addTo(map);

    const countyStyle = {
      color: '#163628',
      weight: 1.25,
      opacity: 0.7,
      fillColor: '#1f6b45',
      fillOpacity: 0.12,
    };

    const loadGeo = payload.geojson
      ? fetch(payload.geojson).then((r) => r.json()).catch(() => null)
      : Promise.resolve(null);

    loadGeo.then((geo) => {
      if (geo) {
        const layer = L.geoJSON(geo, {
          style: countyStyle,
          onEachFeature(feature, lyr) {
            const name = feature.properties?.COUNTY_NAM || feature.properties?.shapeName || '';
            if (name) {
              lyr.bindTooltip(name, { sticky: true, opacity: 0.9 });
            }
          },
        }).addTo(map);
        try {
          map.fitBounds(layer.getBounds(), { padding: [18, 18] });
        } catch (e) {
          /* keep default view */
        }
      }

      const maxCount = Math.max(1, ...points.map((p) => Number(p.count) || 0));
      points.forEach((p) => {
        const count = Number(p.count) || 0;
        if (!p.lat || !p.lng || count < 1) return;
        const t = count / maxCount;
        const radius = 8 + t * 28;
        // Transparency keeps overlapping towns readable.
        const fillOpacity = 0.28 + t * 0.28;

        L.circleMarker([p.lat, p.lng], {
          radius,
          color: '#163628',
          weight: 1,
          opacity: 0.65,
          fillColor: '#1f6b45',
          fillOpacity,
        })
          .bindPopup(
            `<div class="admin-map-popup"><strong>${escapeHtml(p.name)}</strong><br>${count} case${count === 1 ? '' : 's'} · ${escapeHtml(p.county)}</div>`
          )
          .addTo(map);
      });

      setTimeout(() => map.invalidateSize(), 80);
    });
  }

  window.AdminDashboard = {
    init() {
      initKenyaCaseMap();

      const raw = document.getElementById('admin-dashboard-data');
      if (!raw || !window.Chart) return;
      Chart.defaults.font.family = '"Outfit", "Segoe UI", sans-serif';
      Chart.defaults.font.lineHeight = 1;
      const data = JSON.parse(raw.textContent || '{}');
      const colors = palette();

      const line = (id, rows, label) => {
        const el = document.getElementById(id);
        if (!el) return;
        const s = seriesFrom(rows);
        new Chart(el, {
          type: 'line',
          data: {
            labels: s.labels,
            datasets: [{
              label,
              data: s.values,
              borderColor: '#1f6b45',
              backgroundColor: 'rgba(31,107,69,0.12)',
              fill: true,
              tension: 0.3,
              pointRadius: 2.5,
              pointBackgroundColor: '#163628',
              borderWidth: 2,
            }],
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
              x: {
                grid: { display: false },
                ticks: { color: '#6a736d' },
              },
              y: {
                beginAtZero: true,
                ticks: { precision: 0, color: '#6a736d' },
                grid: { color: 'rgba(42,47,44,0.08)' },
              },
            },
          },
        });
      };

      const doughnut = (id, rows) => {
        const el = document.getElementById(id);
        if (!el) return;
        const s = seriesFrom(rows);
        new Chart(el, {
          type: 'doughnut',
          data: {
            labels: s.labels,
            datasets: [{
              data: s.values,
              backgroundColor: colors.slice(0, Math.max(s.values.length, 1)),
              borderWidth: 0,
            }],
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '64%',
            plugins: {
              legend: {
                position: 'bottom',
                labels: {
                  boxWidth: 10,
                  usePointStyle: true,
                  color: '#2a2f2c',
                  font: { size: 11 },
                },
              },
            },
          },
        });
      };

      const bar = (id, rows, horizontal = false) => {
        const el = document.getElementById(id);
        if (!el) return;
        const s = seriesFrom(rows);
        new Chart(el, {
          type: 'bar',
          data: {
            labels: s.labels,
            datasets: [{
              data: s.values,
              backgroundColor: '#1f6b45',
              hoverBackgroundColor: '#163628',
              borderRadius: 4,
              maxBarThickness: 22,
            }],
          },
          options: {
            indexAxis: horizontal ? 'y' : 'x',
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
              x: {
                grid: { display: !horizontal, color: 'rgba(42,47,44,0.08)' },
                beginAtZero: true,
                ticks: { precision: 0, color: '#6a736d' },
              },
              y: {
                grid: { display: horizontal, color: 'rgba(42,47,44,0.08)' },
                beginAtZero: true,
                ticks: { precision: 0, color: '#6a736d' },
              },
            },
          },
        });
      };

      line('chart-report-trend', data.report_trend, 'Reports');
      doughnut('chart-animals', data.reports_by_animal);
      bar('chart-counties', data.reports_by_county, true);
      doughnut('chart-stories', data.stories_by_category);
      bar('chart-contacts', data.contacts_by_category);
      line('chart-subscribers', data.subscriber_trend, 'Subscribers');
    },
  };

  window.AdminTables = {
    initReports() {
      const table = $('#table-reports').DataTable({
        ajax: {
          url: apiUrl('admin/api/reports.php'),
          data: (d) => {
            d.status = $('#filter-report-status').val() || '';
          },
          dataSrc: 'data',
        },
        order: [[6, 'desc']],
        pageLength: 10,
        stripeClasses: ['odd', 'even'],
        columns: [
          { data: 'reference_code', render: (v) => `<code>${escapeHtml(v)}</code>` },
          { data: 'animal_type' },
          {
            data: 'concern_types',
            render: (v) => escapeHtml(Array.isArray(v) ? v.slice(0, 2).join(', ') : ''),
          },
          { data: 'county' },
          {
            data: 'immediate_danger',
            render: (v) => statusBadge(v),
          },
          { data: 'status', render: (v) => statusBadge(v) },
          { data: 'created_at', render: (v) => fmtDate(v) },
          {
            data: null,
            orderable: false,
            render: (row) => `
              <div class="admin-actions">
                <button class="admin-btn admin-btn--ghost admin-btn--sm" data-view-report="${row.id}">View</button>
                <select data-status-report="${row.id}" aria-label="Update status">
                  ${['received', 'in_review', 'referred', 'closed'].map((s) =>
                    `<option value="${s}" ${s === row.status ? 'selected' : ''}>${s.replace(/_/g, ' ')}</option>`
                  ).join('')}
                </select>
                <button class="admin-btn admin-btn--danger admin-btn--sm" data-del-report="${row.id}">Delete</button>
              </div>`,
          },
        ],
      });

      $('#filter-report-status').on('change', () => table.ajax.reload());

      $('#table-reports').on('change', '[data-status-report]', async function () {
        await postAction(apiUrl('admin/api/reports.php'), {
          action: 'update_status',
          id: this.getAttribute('data-status-report'),
          status: this.value,
        });
        table.ajax.reload(null, false);
      });

      $('#table-reports').on('click', '[data-del-report]', async function () {
        if (!confirm('Delete this report?')) return;
        await postAction(apiUrl('admin/api/reports.php'), {
          action: 'delete',
          id: this.getAttribute('data-del-report'),
        });
        table.ajax.reload(null, false);
      });

      $('#table-reports').on('click', '[data-view-report]', async function () {
        const id = this.getAttribute('data-view-report');
        const res = await fetch(apiUrl(`admin/api/reports.php?action=get&id=${id}`)).then((r) => r.json());
        if (!res.ok) return;
        const item = res.item;
        document.getElementById('report-dialog-title').textContent = item.reference_code;
        document.getElementById('report-dialog-body').innerHTML = `
          <dl>
            <dt>Animal</dt><dd>${escapeHtml(item.animal_type)}</dd>
            <dt>Concerns</dt><dd>${escapeHtml((item.concern_types || []).join(', '))}</dd>
            <dt>County / area</dt><dd>${escapeHtml(item.county)} · ${escapeHtml(item.area)}</dd>
            <dt>Location</dt><dd>${escapeHtml(item.precise_location || '—')}</dd>
            <dt>Danger</dt><dd>${statusBadge(item.immediate_danger)}</dd>
            <dt>When</dt><dd>${escapeHtml(item.not_sure_when == 1 ? 'Not sure' : `${item.event_date || '—'} ${item.event_time || ''}`.trim())}</dd>
            <dt>Contact</dt><dd>${escapeHtml([item.contact_name, item.contact_email, item.contact_phone].filter(Boolean).join(' · ') || 'Anonymous')}</dd>
            <dt>Status</dt><dd>${statusBadge(item.status)}</dd>
          </dl>
          <p><strong>Observations</strong><br>${escapeHtml(item.observations)}</p>`;
        document.getElementById('report-dialog').showModal();
      });
    },

    initStories() {
      const table = $('#table-stories').DataTable({
        ajax: {
          url: apiUrl('admin/api/stories.php'),
          data: (d) => { d.status = $('#filter-story-status').val() || ''; },
          dataSrc: 'data',
        },
        order: [[6, 'desc']],
        columns: [
          { data: 'title' },
          { data: 'display_name' },
          { data: 'animal_type' },
          { data: 'category' },
          { data: 'location' },
          { data: 'status', render: (v) => statusBadge(v) },
          { data: 'created_at', render: (v) => fmtDate(v) },
          {
            data: null,
            orderable: false,
            render: (row) => `
              <div class="admin-actions">
                <button class="admin-btn admin-btn--ghost admin-btn--sm" data-view-story="${row.id}">View</button>
                <select data-status-story="${row.id}" aria-label="Update status">
                  ${['pending_moderation', 'published', 'needs_changes', 'declined'].map((s) =>
                    `<option value="${s}" ${s === row.status ? 'selected' : ''}>${s.replace(/_/g, ' ')}</option>`
                  ).join('')}
                </select>
                <button class="admin-btn admin-btn--danger admin-btn--sm" data-del-story="${row.id}">Delete</button>
              </div>`,
          },
        ],
      });

      $('#filter-story-status').on('change', () => table.ajax.reload());

      $('#table-stories').on('change', '[data-status-story]', async function () {
        await postAction(apiUrl('admin/api/stories.php'), {
          action: 'update_status',
          id: this.getAttribute('data-status-story'),
          status: this.value,
        });
        table.ajax.reload(null, false);
      });

      $('#table-stories').on('click', '[data-del-story]', async function () {
        if (!confirm('Delete this story?')) return;
        await postAction(apiUrl('admin/api/stories.php'), {
          action: 'delete',
          id: this.getAttribute('data-del-story'),
        });
        table.ajax.reload(null, false);
      });

      $('#table-stories').on('click', '[data-view-story]', async function () {
        const id = this.getAttribute('data-view-story');
        const res = await fetch(apiUrl(`admin/api/stories.php?action=get&id=${id}`)).then((r) => r.json());
        if (!res.ok) return;
        const item = res.item;
        document.getElementById('story-dialog-title').textContent = item.title;
        document.getElementById('story-dialog-body').innerHTML = `
          <dl>
            <dt>Author</dt><dd>${escapeHtml(item.display_name)}</dd>
            <dt>Animal</dt><dd>${escapeHtml(item.animal_type)}</dd>
            <dt>Category</dt><dd>${escapeHtml(item.category || '—')}</dd>
            <dt>Location</dt><dd>${escapeHtml(item.location || '—')}</dd>
            <dt>Status</dt><dd>${statusBadge(item.status)}</dd>
          </dl>
          <p>${escapeHtml(item.body).replace(/\n/g, '<br>')}</p>`;
        document.getElementById('story-dialog').showModal();
      });
    },

    initContact() {
      const table = $('#table-contact').DataTable({
        ajax: {
          url: apiUrl('admin/api/contact.php'),
          data: (d) => { d.status = $('#filter-contact-status').val() || ''; },
          dataSrc: 'data',
        },
        order: [[5, 'desc']],
        columns: [
          { data: 'name' },
          { data: 'email' },
          { data: 'category' },
          { data: 'subject' },
          { data: 'status', render: (v) => statusBadge(v) },
          { data: 'created_at', render: (v) => fmtDate(v) },
          {
            data: null,
            orderable: false,
            render: (row) => `
              <div class="admin-actions">
                <button class="admin-btn admin-btn--ghost admin-btn--sm" data-view-contact="${row.id}">View</button>
                <select data-status-contact="${row.id}" aria-label="Update status">
                  ${['new', 'in_progress', 'resolved'].map((s) =>
                    `<option value="${s}" ${s === row.status ? 'selected' : ''}>${s.replace(/_/g, ' ')}</option>`
                  ).join('')}
                </select>
                <button class="admin-btn admin-btn--danger admin-btn--sm" data-del-contact="${row.id}">Delete</button>
              </div>`,
          },
        ],
      });

      $('#filter-contact-status').on('change', () => table.ajax.reload());

      $('#table-contact').on('change', '[data-status-contact]', async function () {
        await postAction(apiUrl('admin/api/contact.php'), {
          action: 'update_status',
          id: this.getAttribute('data-status-contact'),
          status: this.value,
        });
        table.ajax.reload(null, false);
      });

      $('#table-contact').on('click', '[data-del-contact]', async function () {
        if (!confirm('Delete this message?')) return;
        await postAction(apiUrl('admin/api/contact.php'), {
          action: 'delete',
          id: this.getAttribute('data-del-contact'),
        });
        table.ajax.reload(null, false);
      });

      $('#table-contact').on('click', '[data-view-contact]', async function () {
        const id = this.getAttribute('data-view-contact');
        const res = await fetch(apiUrl(`admin/api/contact.php?action=get&id=${id}`)).then((r) => r.json());
        if (!res.ok) return;
        const item = res.item;
        document.getElementById('contact-dialog-title').textContent = item.subject;
        document.getElementById('contact-dialog-body').innerHTML = `
          <dl>
            <dt>From</dt><dd>${escapeHtml(item.name)} &lt;${escapeHtml(item.email)}&gt;</dd>
            <dt>Category</dt><dd>${escapeHtml(item.category)}</dd>
            <dt>Status</dt><dd>${statusBadge(item.status)}</dd>
          </dl>
          <p>${escapeHtml(item.message).replace(/\n/g, '<br>')}</p>`;
        document.getElementById('contact-dialog').showModal();
      });
    },

    initNewsletter() {
      const table = $('#table-newsletter').DataTable({
        ajax: { url: apiUrl('admin/api/newsletter.php'), dataSrc: 'data' },
        order: [[3, 'desc']],
        columns: [
          { data: 'email' },
          { data: 'source' },
          { data: 'consent', render: (v) => (Number(v) === 1 ? 'Yes' : 'No') },
          { data: 'created_at', render: (v) => fmtDate(v) },
          {
            data: null,
            orderable: false,
            render: (row) => `<button class="admin-btn admin-btn--danger admin-btn--sm" data-del-news="${row.id}">Remove</button>`,
          },
        ],
      });

      $('#table-newsletter').on('click', '[data-del-news]', async function () {
        if (!confirm('Remove this subscriber?')) return;
        await postAction(apiUrl('admin/api/newsletter.php'), {
          action: 'delete',
          id: this.getAttribute('data-del-news'),
        });
        table.ajax.reload(null, false);
      });
    },
  };

  document.addEventListener('DOMContentLoaded', () => {
    const btn = document.querySelector('.admin-menu-btn');
    const sidebar = document.getElementById('admin-sidebar');
    if (btn && sidebar) {
      btn.addEventListener('click', () => {
        const open = sidebar.classList.toggle('is-open');
        btn.setAttribute('aria-expanded', open ? 'true' : 'false');
      });
    }
  });
})();
