<?php declare(strict_types=1); ?>
  </main>

  <footer class="site-footer">
    <div class="container site-footer__grid">
      <div class="site-footer__brand">
        <a class="brand brand--on-dark" href="<?= e(url('index.php')) ?>" aria-label="<?= e(t('brand_home')) ?>">
          <img
            class="brand__mark"
            src="<?= e(asset('images/Logo White BG.png')) ?>"
            alt=""
            width="72"
            height="59"
            decoding="async"
          >
          <span class="brand__divider" aria-hidden="true"></span>
          <span class="brand__text">
            <span class="brand__name">
              <span class="brand__name-dark">The Animals</span>
              <span class="brand__name-light">Among Us</span>
            </span>
            <span class="brand__tagline"><?= e(t('brand_tagline')) ?></span>
          </span>
        </a>
        <p class="site-footer__statement">
          <?= e(t('pitch')) ?>
          <?= e(t('footer_not_emergency')) ?>
        </p>
      </div>

      <div>
        <h2 class="site-footer__heading"><?= e(t('footer_explore')) ?></h2>
        <ul class="site-footer__links">
          <li><a href="<?= e(url('why-it-matters.php')) ?>"><?= e(t('footer_why')) ?></a></li>
          <li><a href="<?= e(url('care-guides.php')) ?>"><?= e(t('footer_guides')) ?></a></li>
          <li><a href="<?= e(url('community.php')) ?>"><?= e(t('footer_community')) ?></a></li>
          <li><a href="<?= e(url('take-action.php')) ?>"><?= e(t('footer_action')) ?></a></li>
          <li><a href="<?= e(url('partners.php')) ?>"><?= e(t('footer_partners')) ?></a></li>
        </ul>
      </div>

      <div>
        <h2 class="site-footer__heading"><?= e(t('footer_support')) ?></h2>
        <ul class="site-footer__links">
          <li><a href="<?= e(url('report.php')) ?>"><?= e(t('footer_report')) ?></a></li>
          <li><a href="<?= e(url('contact.php')) ?>"><?= e(t('footer_contact')) ?></a></li>
          <li><a href="<?= e(url('community-guidelines.php')) ?>"><?= e(t('footer_guidelines')) ?></a></li>
          <li><a href="<?= e(url('privacy.php')) ?>"><?= e(t('footer_privacy')) ?></a></li>
          <li><a href="<?= e(url('terms.php')) ?>"><?= e(t('footer_terms')) ?></a></li>
        </ul>
      </div>

      <div>
        <h2 class="site-footer__heading"><?= e(t('footer_informed')) ?></h2>
        <p class="site-footer__copy"><?= e(t('newsletter_copy')) ?></p>
        <form class="newsletter-form" method="post" action="<?= e(url('newsletter.php')) ?>">
          <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
          <label class="sr-only" for="newsletter-email"><?= e(t('email_address')) ?></label>
          <input id="newsletter-email" type="email" name="email" required placeholder="<?= e(t('email_placeholder')) ?>" autocomplete="email">
          <button type="submit" class="btn btn--primary"><?= e(t('join_community')) ?></button>
          <p class="form-note"><?= e(t('newsletter_note')) ?> <a href="<?= e(url('privacy.php')) ?>"><?= e(t('footer_privacy')) ?></a> <?= e(t('before_subscribing')) ?></p>
        </form>
      </div>
    </div>

    <div class="site-footer__bottom">
      <div class="container site-footer__bottom-inner">
        <p>&copy; <?= date('Y') ?> <?= e(SITE_NAME) ?>. <?= e(t('footer_credit')) ?></p>
        <p><?= e(t('supporting')) ?></p>
      </div>
    </div>
  </footer>

  <script src="<?= e(asset('js/main.js')) ?>" defer></script>
</body>
</html>
