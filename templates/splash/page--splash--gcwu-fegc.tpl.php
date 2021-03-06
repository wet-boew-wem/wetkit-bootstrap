<?php
/**
 * @file
 * Default theme implementation to display a single Drupal page.
 *
 * The doctype, html, head and body tags are not in this template. Instead they
 * can be found in the html.tpl.php template in this directory.
 *
 * Available variables:
 *
 * General utility variables:
 * - $base_path: The base URL path of the Drupal installation. At the very
 *   least, this will always default to /.
 * - $directory: The directory the template is located in, e.g. modules/system
 *   or themes/bartik.
 * - $is_front: TRUE if the current page is the front page.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to access administration pages.
 *
 * Site identity:
 * - $front_page: The URL of the front page. Use this instead of $base_path,
 *   when linking to the front page. This includes the language domain or
 *   prefix.
 * - $logo: The path to the logo image, as defined in theme configuration.
 * - $site_name: The name of the site, empty when display has been disabled
 *   in theme settings.
 * - $site_slogan: The slogan of the site, empty when display has been disabled
 *   in theme settings.
 *
 * Navigation:
 * - $main_menu (array): An array containing the Main menu links for the
 *   site, if they have been configured.
 * - $secondary_menu (array): An array containing the Secondary menu links for
 *   the site, if they have been configured.
 * - $breadcrumb: The breadcrumb trail for the current page.
 *
 * Page content (in order of occurrence in the default page.tpl.php):
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title: The page title, for use in the actual HTML content.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 * - $messages: HTML for status and error messages. Should be displayed
 *   prominently.
 * - $tabs (array): Tabs linking to any sub-pages beneath the current page
 *   (e.g., the view and edit tabs when displaying a node).
 * - $action_links (array): Actions local to the page, such as 'Add menu' on the
 *   menu administration interface.
 * - $feed_icons: A string of all feed icons for the current page.
 * - $node: The node object, if there is an automatically-loaded node
 *   associated with the page, and the node ID is the second argument
 *   in the page's path (e.g. node/12345 and node/12345/revisions, but not
 *   comment/reply/12345).
 *
 * Regions:
 * - $page['help']: Dynamic help text, mostly for admin pages.
 * - $page['highlighted']: Items for the highlighted content region.
 * - $page['content']: The main content of the current page.
 * - $page['sidebar_first']: Items for the first sidebar.
 * - $page['sidebar_second']: Items for the second sidebar.
 * - $page['header']: Items for the header region.
 * - $page['footer']: Items for the footer region.
 *
 * @see bootstrap_preprocess_page()
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see bootstrap_process_page()
 * @see template_process()
 * @see html.tpl.php
 *
 * @ingroup themeable
 */
?>
<header role="banner">
  <div id="wb-bnr" class="<?php print $container_class; ?>">
    <img id="gcwu-sig" src="/profiles/wetkit/libraries/theme-gcwu-fegc/assets/sig-alt-en.svg" alt="<?php print t('Government of Canada'); ?>" />
  </div>
</header>
<main role="main" property="mainContentOfPage" class="<?php print $container_class; ?>">
  <div class="col-md-12">
    <h1>Welcome /
      <span lang="fr">Bienvenue</span>
    </h1>
    <section class="col-md-6">
      <h2 class="h3 text-center"><?php print t('Web Experience Toolkit'); ?></h2>
      <ul class="list-unstyled">
      <li><a class="btn btn-lg btn-primary btn-block" href="<?php print '/' . $language_prefix; ?>"><?php print t('English'); ?></a></li>
      <li><a class="btn btn-lg btn-default btn-block" href="../../License-en.html" rel="license"><?php print t('Terms and conditions of use'); ?></a></li>
      </ul>
    </section>
    <section class="col-md-6" lang="fr">
      <h2 class="h3 text-center"><?php print t('Boîte à outils de l’expérience Web'); ?></h2>
      <ul class="list-unstyled">
      <li><a class="btn btn-lg btn-primary btn-block" href="<?php print '/' . $language_prefix_alt; ?>"><?php print t('Français'); ?></a></li>
      <li><a class="btn btn-lg btn-default btn-block" href="../../Licence-fr.html" rel="license"><?php print t('Conditions régissant l\'utilisation'); ?></a></li>
      </ul>
    </section>
  </div>
</main>
<footer role="contentinfo" class="<?php print $container_class; ?>">
    <img id="wmms" src="/profiles/wetkit/libraries/theme-gcwu-fegc/assets/wmms-alt.svg" alt="<?php print t('Symbol of the Government of Canada'); ?>" />
</footer>
