<?php
/**
 * @file
 * region--sidebar.tpl.php
 *
 * Default theme implementation to display the "sidebar_first" and
 * "sidebar_second" regions.
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
<?php if ($content): ?>
  <footer role="contentinfo" id="wb-info" class="visible-sm visible-md visible-lg wb-navcurr">
      <div class="container">
        <nav role="navigation" class="row">
        <h2>Site information</h2>
        <?php if ($content_attributes): ?><div<?php print $content_attributes; ?>><?php endif; ?>
        <?php print render($page['footer']); ?>
        <?php if ($content_attributes): ?></div><?php endif; ?>
        </nav>
      </div>
      <div class="brand">
        <div class="container">
          <div class="row ">
            <div class="col-xs-6 visible-sm visible-xs tofpg">
              <a href="#wb-cont">Top of Page <span class="glyphicon glyphicon-chevron-up"></span></a>
            </div>
            <div class="col-xs-6 col-md-12 text-right">
              <?php if ($page['logo'] && $page['logo_bottom_svg']): ?>
                <object data='<?php print $page['logo_bottom_svg']; ?>' role="img" tabindex="-1" type="image/svg+xml">
                  <img alt="<?php print t('WxT Logo'); ?>" src="<?php print $page['logo_bottom_svg']; ?>"  />
                </object>
              <?php elseif ($page['logo']): ?>
                <img alt="<?php print t('WxT Logo'); ?>" src="<?php print $page['logo_bottom']; ?>"  />
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
  </footer>
<?php endif; ?>
