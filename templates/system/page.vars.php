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

  // WxT Settings.
  $theme_prefix = 'wb';
  $theme_menu_prefix = 'wet-fullhd';
  $wxt_active = variable_get('wetkit_wetboew_theme', 'wet-boew');
  $library_path = libraries_get_path($wxt_active, TRUE);
  $wxt_active = str_replace('-', '_', $wxt_active);
  $wxt_active = str_replace('wet_boew_', '', $wxt_active);

  // Extra variables to pass to templates.
  $variables['library_path'] = $library_path;
  $variables['language'] = $language->language;
  $variables['language_prefix'] = $language->prefix;
  $variables['language_prefix_alt'] = ($language->prefix == 'en') ? 'fr' : 'fra';

  // Site Name.
  if (!empty($variables['site_name'])) {
    $variables['site_name_title'] = filter_xss(variable_get('site_name', 'Drupal'));
    $variables['site_name_unlinked'] = $variables['site_name_title'];
    $variables['site_name_url'] = url(variable_get('site_frontpage', 'node'));
    $variables['site_name'] = trim($variables['site_name_title']);
  }

  // Logo settings.
  $variables['logo_class'] = '';
  $variables['logo_svg'] = '';
  $toggle_logo = theme_get_setting('toggle_logo', 'wetkit_bootstrap');
  $default_logo = theme_get_setting('default_logo', 'wetkit_bootstrap');
  $default_svg_logo = theme_get_setting('wetkit_theme_svg_default_logo', 'wetkit_bootstrap');

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

  // Add information about the number of sidebars.
  if (!empty($variables['page']['sidebar_first']) && !empty($variables['page']['sidebar_second'])) {
    $variables['content_column_class'] = ' class="col-sm-6"';
  }
  elseif (!empty($variables['page']['sidebar_first']) || !empty($variables['page']['sidebar_second'])) {
    $variables['content_column_class'] = ' class="col-sm-9"';
  }
  else {
    $variables['content_column_class'] = '';
  }

  // Primary menu.
  $variables['primary_nav'] = FALSE;
  if ($variables['main_menu']) {
    // Build links.
    $variables['primary_nav'] = menu_tree(variable_get('menu_main_links_source', 'main-menu'));
    // Provide default theme wrapper function.
    $variables['primary_nav']['#theme_wrappers'] = array('menu_tree__primary');
  }

  // Secondary nav.
  $variables['secondary_nav'] = FALSE;
  if ($variables['secondary_menu']) {
    // Build links.
    $variables['secondary_nav'] = menu_tree(variable_get('menu_secondary_links_source', 'user-menu'));
    // Provide default theme wrapper function.
    $variables['secondary_nav']['#theme_wrappers'] = array('menu_tree__secondary');
  }

  // Navbar.
  $variables['navbar_classes_array'] = array('');
  if (theme_get_setting('bootstrap_navbar_position') !== '') {
    $variables['navbar_classes_array'][] = 'navbar-' . theme_get_setting('bootstrap_navbar_position');
  }
  else {
    $variables['navbar_classes_array'][] = '';
  }

  // Mega Menu Region.
  if (module_exists('menu_block') && empty($variables['mega_menu'])) {
    $menu_name = 'main_menu';
    $data = array(
      '#pre_render' => array('_wetkit_menu_tree_build_prerender'),
      '#cache' => array(
        'keys' => array('wetkit', 'menu', $menu_name),
        'expire' => CACHE_TEMPORARY,
        'granularity' => DRUPAL_CACHE_PER_ROLE
      ),
      '#menu_name' => $menu_name,
    );
    $variables['page']['mega_menu'] = $data;
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

  // Header Navigation + Language Switcher.
  $menu = ($is_multilingual) ? i18n_menu_navigation_links('menu-wet-header') : menu_navigation_links('menu-wet-header');
  $nav_bar_markup = theme('links__menu_menu_wet_header', array(
    'links' => $menu,
    'attributes' => array(
      'id' => 'menu',
      'class' => array('links', 'clearfix'),
    ),
    'heading' => array(
      'text' => 'Language Selection',
      'level' => 'h2',
    ),
  ));
  $nav_bar_markup = strip_tags($nav_bar_markup, '<h2><li><a>');

  if (module_exists('wetkit_language')) {
    $language_link_markup = '<li id="' . $theme_menu_prefix . '-lang">' . strip_tags($variables['menu_lang_bar'], '<a><span>') . '</li>';
    if ($wxt_active == 'gcweb') {
      $variables['menu_bar'] = '<ul class="list-inline margin-bottom-none">' . $language_link_markup . '</ul>';
    }
    else if ($wxt_active == 'gcwu_fegc') {
      $variables['menu_bar'] = '<ul id="gc-bar" class="list-inline">' . preg_replace("/<h([1-6]{1})>.*?<\/h\\1>/si", '', $nav_bar_markup) . $language_link_markup . '</ul>';
    }
    else if ($wxt_active == 'gc_intranet') {
      $variables['menu_bar'] = '<ul id="gc-bar" class="list-inline">' . $language_link_markup . '</ul>';
    }
    else {
      $variables['menu_bar'] = '<ul class="text-right">' . preg_replace("/<h([1-6]{1})>.*?<\/h\\1>/si", '', $nav_bar_markup) . $language_link_markup . '</ul>';
    }
  }
  else {
    $variables['menu_bar'] = '<ul class="text-right">' . preg_replace("/<h([1-6]{1})>.*?<\/h\\1>/si", '', $nav_bar_markup) . '</ul>';
  }

  // Custom Search Box.
  if (module_exists('custom_search')) {
    // Custom Search.
    $variables['custom_search'] = drupal_get_form('custom_search_blocks_form_1');
    $variables['custom_search']['#id'] = 'search-form';
    $variables['custom_search']['custom_search_blocks_form_1']['#id'] = $theme_prefix . '-srch-q';
    $variables['custom_search']['actions']['submit']['#id'] = 'wb-srch-sub';
    $variables['custom_search']['actions']['submit']['#attributes']['data-icon'] = 'search';
    $variables['custom_search']['actions']['submit']['#attributes']['value'] = t('search');
    $variables['custom_search']['#attributes']['class'][] = 'form-inline';
    $variables['custom_search']['#attributes']['role'] = 'search';
    $variables['custom_search']['actions']['#theme_wrappers'] = NULL;

    if ($wxt_active == 'gcweb') {

      $variables['custom_search']['#attributes']['name'] = 'search-form';
      $variables['custom_search']['actions']['submit']['#attributes']['name'] = 'wb-srch-sub';
      $variables['custom_search']['actions']['submit']['#value'] = '<span class="glyphicon-search glyphicon"></span><span class="wb-inv">' . t('Search') . '</span>';
      $variables['custom_search']['custom_search_blocks_form_1']['#attributes']['placeholder'] = t('Search Canada.ca');

      $cdn_srch = theme_get_setting('canada_search');
      if (isset($cdn_srch)) {
        $variables['custom_search']['custom_search_blocks_form_1']['#name'] = 'q';
        $variables['custom_search']['#action'] = 'http://recherche-search.gc.ca/rGs/s_r?#wb-land';
        $variables['custom_search']['#method'] = 'get';
        $variables['custom_search']['cdn'] = array(
          '#name' => 'cdn',
          '#value' => 'canada',
          '#type' => 'hidden',
          '#input' => 'TRUE',
        );
        $variables['custom_search']['st'] = array(
          '#name' => 'st',
          '#value' => 's',
          '#type' => 'hidden',
          '#input' => 'TRUE',
        );
        $variables['custom_search']['num'] = array(
          '#name' => 'num',
          '#value' => '10',
          '#type' => 'hidden',
          '#input' => 'TRUE',
        );
        $variables['custom_search']['langs'] = array(
          '#name' => 'langs',
          '#value' => 'eng',
          '#type' => 'hidden',
          '#input' => 'TRUE',
        );
        $variables['custom_search']['st1rt'] = array(
          '#name' => 'st1rt',
          '#value' => '0',
          '#type' => 'hidden',
          '#input' => 'TRUE',
        );
        $variables['custom_search']['s5bm3ts21rch'] = array(
          '#name' => 's5bm3ts21rch',
          '#value' => 'x',
          '#type' => 'hidden',
          '#input' => 'TRUE',
        );
      }

      $gcweb_cdn = theme_get_setting('gcweb_cdn');
      if (!empty($gcweb_cdn)) {
        $variables['gcweb_cdn'] = TRUE;
      }
      else {
        $variables['gcweb_cdn'] = FALSE;
      }
    }

    // Visibility settings.
    $pages = drupal_strtolower(theme_get_setting('wetkit_search_box'));
    // Convert the Drupal path to lowercase.
    $path = drupal_strtolower(drupal_get_path_alias($_GET['q']));
    // Compare the lowercase internal and lowercase path alias (if any).
    $page_match = drupal_match_path($path, $pages);
    if ($path != $_GET['q']) {
      $page_match = $page_match || drupal_match_path($_GET['q'], $pages);
    }
    // When $visibility has a value of 0 (VISIBILITY_NOTLISTED),
    // the block is displayed on all pages except those listed in $pages.
    // When set to 1 (VISIBILITY_LISTED), it is displayed only on those
    // pages listed in $pages.
    $visibility = 0;
    $page_match = !(0 xor $page_match);
    if ($page_match) {
      $variables['search_box'] = render($variables['custom_search']);
      $variables['search_box'] = str_replace('type="text"', 'type="search"', $variables['search_box']);
    }
    else {
      $variables['search_box'] = '';
    }
  }

  // Terms Navigation.
  $menu = ($is_multilingual) ? i18n_menu_navigation_links('menu-wet-terms') : menu_navigation_links('menu-wet-terms');
  $class = ($wxt_active == 'gcwu_fegc' || $wxt_active == 'gc_intranet') ? array('list-inline') : array('links', 'clearfix');
  $terms_bar_markup = theme('links__menu_menu_wet_terms', array(
    'links' => $menu,
    'attributes' => array(
      'id' => 'gc-tctr',
      'class' => $class,
    ),
    'heading' => array(),
  ));
  $variables['page']['menu_terms_bar'] = $terms_bar_markup;

  // Mid Footer Region.
  if (module_exists('menu_block')) {
    $menu_name = 'mid_footer_menu';
    $data = array(
      '#pre_render' => array('_wetkit_menu_tree_build_prerender'),
      '#cache' => array(
        'keys' => array('wetkit', 'menu', $menu_name),
        'expire' => CACHE_TEMPORARY,
        'granularity' => DRUPAL_CACHE_PER_ROLE
      ),
      '#menu_name' => $menu_name,
    );
    $variables['page']['footer']['minipanel'] = $data;
  }

  // Unset powered by block.
  unset($variables['page']['footer']['system_powered-by']);

  // Footer Navigation.
  $menu = ($is_multilingual) ? i18n_menu_navigation_links('menu-wet-footer') : menu_navigation_links('menu-wet-footer');
  $class = ($wxt_active == 'gcwu_fegc' || $wxt_active == 'gc_intranet') ? array('list-inline') : array('links', 'clearfix');
  $footer_bar_markup = theme('links__menu_menu_wet_footer', array(
    'links' => $menu,
    'attributes' => array(
      'id' => 'menu',
      'class' => $class,
    ),
    'heading' => array(),
  ));
  $variables['page']['menu_footer_bar'] = $footer_bar_markup;

  // Footer Navigation (gcweb).
  if ($wxt_active == 'gcweb') {
    $variables['gcweb'] = array(
      'feedback' => array(
        'en' => 'http://www.canada.ca/en/contact/feedback.html',
        'fr' => 'http://www.canada.ca/fr/contact/retroaction.html',
      ),
      'social' => array(
        'en' => 'http://www.canada.ca/en/social/index.html',
        'fr' => 'http://www.canada.ca/fr/sociaux/index.html',
      ),
      'mobile' => array(
        'en' => 'http://www.canada.ca/en/mobile/index.html',
        'fr' => 'http://www.canada.ca/fr/mobile/index.html',
      ),
    );
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
  $variables['navbar_classes'] = implode(' ', $variables['navbar_classes_array']);
}

/**
 * Pre Render handler for cache based menu block handling.
 */
function _wetkit_menu_tree_build_prerender($element) {
  $config = menu_block_get_config($element['#menu_name']);
  $data = menu_tree_build($config);
  $element['content'] = $data['content'];
  return $element;
}
