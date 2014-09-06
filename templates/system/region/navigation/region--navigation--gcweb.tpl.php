<?php
/**
 * @file
 * region--navigation.tpl.php
 *
 * Default theme implementation to display the "navigation" region.
 *
 * Available variables:
 * - $content: The content for this region, typically blocks.
 * - $attributes: String of attributes that contain things like classes and ids.
 * - $content_attributes: The attributes used to wrap the content. If empty,
 *   the content will not be wrapped.
 * - $region: The name of the region variable as defined in the theme's .info
 *   file.
 * - $page: The page variables from bootstrap_process_page().
 *
 * Helper variables:
 * - $is_admin: Flags true when the current user is an administrator.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 *
 * @see bootstrap_preprocess_region().
 * @see bootstrap_process_page().
 *
 * @ingroup themeable
 */
?>
<?php if ($page['logo'] || $page['site_name'] || $page['primary_nav'] || $page['secondary_nav'] || $content): ?>
  <header<?php print $attributes; ?>>
    <div id="wb-bnr" class="container">
      <section id="wb-lng" class="visible-md visible-lg text-right">
        <h2 class="wb-inv"><?php print t('Language selection'); ?></h2>
        <div class="row">
          <div class="col-md-12">
            <?php print $menu_bar; ?>
          </div>
        </div>
      </section>
      <div class="row">
        <div class="brand col-xs-9 col-md-6">
          <?php if ($page['site_name'] || $page['site_slogan'] || $page['logo']): ?>
            <a href="<?php print $page['site_name_url']; ?>">
              <?php if ($page['logo'] && $page['logo_svg']): ?>
                <object id="header-logo" data='<?php print $page['logo_svg']; ?>' role="img" tabindex="-1" type="image/svg+xml">
                  <img alt="<?php print t('WxT Logo'); ?>" src="<?php print $page['logo']; ?>"  />
                </object>
              <?php elseif ($page['logo']): ?>
                <img alt="<?php print t('WxT Logo'); ?>" src="<?php print $page['logo']; ?>"  />
              <?php endif; ?>
            </a>
          <?php endif; ?>
        </div>
        <section class="wb-mb-links col-xs-3 visible-sm visible-xs" id="wb-glb-mn">
          <h2><?php print t('Menu'); ?></h2>
          <ul class="list-inline text-right chvrn">
            <li>
              <a href="#mb-pnl" title="Menu" aria-controls="mb-pnl" class="overlay-lnk" role="button">
                <span class="glyphicon glyphicon-th-list">
                  <span class="wb-inv"><? print t('Menu'); ?></span>
                </span>
              </a>
            </li>
          </ul>
          <div id="mb-pnl"></div>
        </section>
          <section id="wb-srch" class="col-xs-6 text-right visible-md visible-lg">
              <h2 class="wb-inv"><?php print t('Search'); ?></h2>
              <?php if ($search_box): ?>
                <?php print $search_box; ?>
              <?php endif; ?>
          </section>
      </div>
    </div>
    <nav role="navigation" id="wb-sm" class="wb-menu visible-md visible-lg" data-trgt="mb-pnl">
      <div class="pnl-strt container nvbar">
        <h2><?php print t('Site menu'); ?></h2>
        <div class="row">
          <?php print render($page['mega_menu']); ?>
        </div>
      </div>
    </nav>
    <?php print $content; ?>
    <nav role="navigation" id="wb-bc" property="breadcrumb">
      <div class="container">
        <div class="row">
          <?php print render($page['breadcrumb']); ?>
        </div>
      </div>
    </nav>
  </header>
<?php endif; ?>
