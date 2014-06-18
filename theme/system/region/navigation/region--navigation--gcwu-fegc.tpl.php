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
    <div id="wb-bnr">
      <div id="wb-bar">
        <div class="container">
          <div class="row">

              <object id="gcwu-sig" type="image/svg+xml" tabindex="-1" role="img" data="/profiles/wetkit/libraries/wet-boew-gcwu-fegc/assets/sig-en.svg" aria-label="Government of Canada"></object>
              <?php print $menu_bar; ?>

            <section class="wb-mb-links col-xs-12 visible-sm visible-xs" id="wb-glb-mn">
              <h2>Menu</h2>
              <ul class="pnl-btn list-inline text-right">
                <li><a href="#mb-pnl" title="Menu" aria-controls="mb-pnl" class="overlay-lnk btn btn-xs btn-default" role="button"><span class="glyphicon glyphicon-th-list"><span class="wb-inv">Menu</span></span></a></li>
              </ul>
              <div id="mb-pnl"></div>
            </section>
            </div>
          </div>
        </div>

        <div class="container">
          <div class="row">
            <div id="wb-sttl" class="col-md-5">
              <?php if ($page['site_name'] || $page['site_slogan'] || $page['logo']): ?>
                <a href="<?php print $page['site_name_url']; ?>">
                 <span <?php print $page['logo_class']; ?>>
                    <?php if ($page['site_name']): ?>
                      <?php print $page['site_name']; ?>
                    <?php endif; ?>
                  </span>
                </a>
              <?php endif; ?>
            </div>
            <object id="wmms" type="image/svg+xml" tabindex="-1" role="img" data="/profiles/wetkit/libraries/wet-boew-gcwu-fegc/assets/wmms.svg" aria-label="Symbol of the Government of Canada"></object>
            <section id="wb-srch" class="visible-md visible-lg">
                <h2><?php print t('Search'); ?></h2>
                <?php if ($search_box): ?>
                  <?php print $search_box; ?>
                <?php endif; ?>
            </section>
          </div>
        </div>

      </div>

      <nav role="navigation" id="wb-sm" class="wb-menu visible-md visible-lg" data-trgt="mb-pnl">
        <div class="container nvbar">
          <h2>Site menu</h2>
          <div class="row">
            <?php print render($page['mega_menu']); ?>
            <?php print render($page['secondary_nav']); ?>
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
    </div>
  </header>
<?php endif; ?>
