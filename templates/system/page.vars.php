<?php
/**
 * @file
 * page.vars.php
 */

/**
 * Implements hook_preprocess_page().
 *
 * @see page.tpl.php
 */
function wetkit_bootstrap_preprocess_page(&$variables) {

  // Internationalization Settings.
  global $language;
  $is_multilingual = 0;
  if (module_exists('i18n_menu') && drupal_multilingual()) {
    $is_multilingual = 1;
  }

  // Remove html_tag__site_slogan.
  unset($variables['page']['header'][0]);

  // WxT Settings.
  $wxt_active = variable_get('wetkit_wetboew_theme', 'wet-boew');
  $library_path = libraries_get_path($wxt_active, TRUE);
  $wxt_active = str_replace('-', '_', $wxt_active);
  $wxt_active = str_replace('wet_boew_', '', $wxt_active);

  // Logo settings.
  $variables['logo_class'] = '';
  $variables['logo_svg'] = '';
  $toggle_logo = theme_get_setting('toggle_logo', 'wetkit_bootstrap');
  $default_logo = theme_get_setting('default_logo', 'wetkit_bootstrap');
  $default_svg_logo = theme_get_setting('wetkit_theme_svg_default_logo', 'wetkit_bootstrap');

  if (!empty($variables['site_name'])) {
    $variables['site_name_title'] = filter_xss(variable_get('site_name', 'Drupal'));
    $variables['site_name_unlinked'] = $variables['site_name_title'];
    $variables['site_name_url'] = url(variable_get('site_frontpage', 'node'));
    $variables['site_name'] = trim($variables['site_name_title']);
  }

  // Default Logo logic.
  if (($default_logo == 0) && ($default_svg_logo == 1)) {
    if ($wxt_active == 'gcweb') {
      $variables['logo_svg'] = $library_path . '/assets/sig-blk-' . $language->language . '.svg';
      $variables['logo'] = $library_path . '/assets/sig-blk-' . $language->language . '.png';
      $variables['logo_bottom_svg'] = $library_path . '/assets/wmms-blk' . '.svg';
      $variables['logo_bottom'] = $library_path . '/assets/wmms-blk' . '.png';
    }
    else {
      $variables['logo_svg'] = $library_path . '/assets/logo.svg';
      $variables['logo'] = $library_path . '/assets/logo.png';
    }
  }

  // Toggle Logo.
  if ($toggle_logo == 0) {
    $variables['logo'] = '';
    $variables['logo_svg'] = '';
    $variables['logo_class'] = drupal_attributes(array('class' => 'no-logo'));
  }

  // Ensure each region has the correct theme wrappers.
  foreach (system_region_list($GLOBALS['theme_key']) as $name => $title) {
    if (!$variables['page'][$name]) {
      $variables['page'][$name]['#theme_wrappers'] = array('region');
      $variables['page'][$name]['#region'] = $name;
    }
  }

  // Primary menu.
  $variables['primary_nav'] = array();
  if ($variables['main_menu']) {
    // Build links.
    $variables['primary_nav'] = menu_tree(variable_get('menu_main_links_source', 'main-menu'));
    // Provide default theme wrapper function.
    $variables['primary_nav']['#theme_wrappers'] = array('menu_tree__primary');
  }

  // Secondary nav.
  $variables['secondary_nav'] = array();
  if ($variables['secondary_menu']) {
    // Build links.
    $variables['secondary_nav'] = menu_tree(variable_get('menu_secondary_links_source', 'user-menu'));
    // Provide default theme wrapper function.
    $variables['secondary_nav']['#theme_wrappers'] = array('menu_tree__secondary');
  }

  // Mega Menu Region.
  if (module_exists('menu_block') && empty($variables['mega_menu'])) {
    $config = menu_block_get_config('main_menu');
    $data = menu_tree_build($config);

    $data['content']['#cache'] = array(
      'keys' => array('wetkit_mega_menu_region_content'),
      'expire' => CACHE_TEMPORARY,
      'granularity' => DRUPAL_CACHE_PER_PAGE, // unset this to cache globally
    );
    $variables['mega_menu'] = $data['content'];
  }

  // Mid Footer Region.
  if (module_exists('menu_block')) {
    $config = menu_block_get_config('mid_footer_menu');
    $data = menu_tree_build($config);

    $data['content']['#cache'] = array(
      'keys' => array('wetkit_mid_footer_region_content'),
      'expire' => CACHE_TEMPORARY,
      'granularity' => DRUPAL_CACHE_PER_PAGE, // unset this to cache globally
    );

    $variables['footer'] = $data['content'];
  }

  // Splash Page.
  if (current_path() == 'splashify-splash') {
    // GCWeb Theme.
    if ($wxt_active == 'gcweb') {
      $variables['background'] = $library_path . '/img/splash/sp-bg-2.jpg';
    }
  }

  // Panels Integration.
  if (module_exists('page_manager')) {
    // Page template suggestions for Panels pages.
    $panel_page = page_manager_get_current_page();
    if (!empty($panel_page)) {
      // Add the active WxT theme machine name to the template suggestions.
      $suggestions[] = 'page__panels__' . $wxt_active;

      if (drupal_is_front_page()) {
        $suggestions[] = 'page__panels__' . $wxt_active . '__front';
      }

      // Add the panel page machine name to the template suggestions.
      $suggestions[] = 'page__' . $panel_page['name'];
      // Merge the suggestions in to the existing suggestions
      // (as more specific than the existing suggestions).
      $variables['theme_hook_suggestions'] = array_merge($variables['theme_hook_suggestions'], $suggestions);
      $variables['panels_layout'] = TRUE;
    }
    // Page template suggestions for normal pages.
    else {
      $suggestions[] = 'page__' . $wxt_active;

      // Splash Page.
      if (current_path() == 'splashify-splash') {
        $suggestions[] = 'page__splash__' . $wxt_active;
      }

      // Merge the suggestions in to the existing suggestions (as more specific
      // than the existing suggestions).
      $variables['theme_hook_suggestions'] = array_merge($variables['theme_hook_suggestions'], $suggestions);
    }
  }
}

/**
 * Implements hook_process_page().
 *
 * @see page.tpl.php
 */
function wetkit_bootstrap_process_page(&$variables) {
  // Store the page variables in cache so it can be used in region
  // preprocessing.
  $page = &drupal_static(__FUNCTION__);
  if (!isset($page)) {
    $page = $variables;
  }
}
