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
        <nav role="navigation">
          <h2>Site information</h2>
          <div class="row">
          <?php if ($content_attributes): ?><div<?php print $content_attributes; ?>><?php endif; ?>
          <?php print render($page['footer']); ?>
          <?php if ($content_attributes): ?></div><?php endif; ?>
          </div>
          <?php print $menu_terms_bar; ?>
        </nav>
      </div>
  </footer>
<?php endif; ?>
