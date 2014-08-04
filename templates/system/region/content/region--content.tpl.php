<?php
/**
 * @file
 * region--content.tpl.php
 *
 * Default theme implementation to display the "content" region.
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
    <?php if ($content_attributes): ?><div<?php print $content_attributes; ?>><?php endif; ?>

    <?php if (empty($page['panels_layout'])): ?>
        <?php print render($page['page']['highlighted']); ?>

        <a id="main-content"></a>
        <?php print render($page['title_prefix']); ?>

        <?php if ($page['title']): ?>
          <h1 class="page-header" id="wb-cont"><?php print $page['title']; ?></h1>
        <?php endif; ?>

        <?php print render($page['title_suffix']); ?>
        <?php print render($page['tabs']); ?>
        <?php print render($page['page']['help']); ?>
        <?php print render($page['action_links']); ?>
    <?php endif; ?>

    <?php if (!empty($page['messages'])): ?>
        <div class="container">
            <div class="row">
                <?php print render($page['messages']); ?>
            </div>
        </div>
    <?php endif; ?>

    <?php print $content; ?>
    <?php if ($content_attributes): ?></div><?php endif; ?>
<?php endif; ?>