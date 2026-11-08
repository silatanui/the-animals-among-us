(() => {
  const navToggle = document.querySelector('.nav-toggle');
  const primaryNav = document.querySelector('#primary-nav');

  if (navToggle && primaryNav) {
    navToggle.addEventListener('click', () => {
      const open = primaryNav.classList.toggle('is-open');
      navToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
      navToggle.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
      document.body.classList.toggle('nav-open', open);
    });
  }

  // Report form: urgent guidance for Yes or Unsure
  const urgency = document.querySelector('#immediate_danger');
  const urgentBox = document.querySelector('#urgent-guidance');
  if (urgency && urgentBox) {
    const syncUrgency = () => {
      const value = urgency.value;
      urgentBox.hidden = !(value === 'yes' || value === 'unsure');
    };
    urgency.addEventListener('change', syncUrgency);
    syncUrgency();
  }

  // Report form: disable date/time when "not sure when" is checked
  const notSureWhen = document.querySelector('#not_sure_when');
  const eventDate = document.querySelector('#event_date');
  const eventTime = document.querySelector('#event_time');
  if (notSureWhen && eventDate && eventTime) {
    const syncWhen = () => {
      const disabled = notSureWhen.checked;
      eventDate.disabled = disabled;
      eventTime.disabled = disabled;
      if (disabled) {
        eventDate.value = '';
        eventTime.value = '';
      }
    };
    notSureWhen.addEventListener('change', syncWhen);
    syncWhen();
  }

  // Soft reveal for sections
  const revealEls = document.querySelectorAll('.reveal');
  if ('IntersectionObserver' in window && revealEls.length) {
    const io = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add('is-visible');
            io.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.12 }
    );
    revealEls.forEach((el) => io.observe(el));
  } else {
    revealEls.forEach((el) => el.classList.add('is-visible'));
  }
})();
