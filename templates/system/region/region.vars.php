<?php
/**
 * @file
 * region.vars.php
 */

/**
 * Implements hook_preprocess_region().
 */
function wetkit_bootstrap_preprocess_region(&$variables) {
  $region = $variables['region'];
  $regions = system_region_list($GLOBALS['theme_key']);
  $variables['page'] = &drupal_static('wetkit_bootstrap_process_page');

  $attributes = &$variables['attributes_array'];
  $attributes['class'] = $variables['classes_array'];
  $content_attributes = &$variables['content_attributes_array'];

  // Internationalization Settings.
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

  // Handle regions.
  switch ($region) {
    case 'navigation':
      //$attributes['class'][] = 'navbar';
      $content_attributes['class'][] = 'container';
      $variables['attributes_array']['role'] = 'banner';

      if (theme_get_setting('bootstrap_navbar_position') !== '') {
        $attributes['class'][] = 'navbar-' . theme_get_setting('bootstrap_navbar_position');
      }
      else {
        //$attributes['class'][] = 'container';
      }
      if (theme_get_setting('bootstrap_navbar_inverse')) {
        //$attributes['class'][] = 'navbar-inverse';
      }
      else {
        //$attributes['class'][] = 'navbar-default';
      }
      $variables['theme_hook_suggestions'][] = 'region__navigation__' . $wxt_active;
      break;

    case 'highlighted':
      $attributes['class'][] = 'highlighted';
      $attributes['class'][] = 'jumbotron';
      $variables['theme_hook_suggestions'][] = 'region__highlighted__' . $wxt_active;
      break;

    case 'header':
      $variables['attributes_array']['id'] = 'page-header';
      $variables['attributes_array']['role'] = 'banner';
      $variables['theme_hook_suggestions'][] = 'region__header__' . $wxt_active;
      break;

    case 'sidebar_first':
      $variables['attributes_array']['role'] = 'complementary';
      $variables['theme_hook_suggestions'] = array(
        'region__sidebar',
        'region__' . $region,
      );
      $variables['theme_hook_suggestions'][] = 'region__sidebar__' . $wxt_active;
      break;

    case 'sidebar_second':
      $variables['attributes_array']['role'] = 'complementary';
      $variables['theme_hook_suggestions'] = array(
        'region__sidebar',
        'region__' . $region,
      );
      $variables['theme_hook_suggestions'][] = 'region__sidebar__' . $wxt_active;
      break;

    case 'help':
      if (!empty($variables['content'])) {
        $variables['content'] = _bootstrap_icon('question-sign') . $variables['content'];
        $attributes['class'][] = 'alert';
        $attributes['class'][] = 'alert-info';
        $attributes['class'][] = 'messages';
        $attributes['class'][] = 'info';
        $variables['theme_hook_suggestions'][] = 'region__help__' . $wxt_active;
      }
      break;

    case 'footer':
      $attributes['class'][] = 'container';
      $variables['theme_hook_suggestions'][] = 'region__footer__' . $wxt_active;
      break;
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
    $language_link_markup = '<li class="curr" id="' . $theme_menu_prefix . '-lang">' . strip_tags($variables['menu_lang_bar'], '<a><span>') . '</li>';
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
      $variables['menu_bar'] = '<ul class="text-right">' . $nav_bar_markup . $language_link_markup . '</ul>';
    }
  }
  else {
    $variables['menu_bar'] = '<ul class="text-right">' . $nav_bar_markup . '</ul>';
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
    //unset($variables['custom_search']['#theme_wrappers']);

    if ($wxt_active == 'gcweb') {
      $variables['custom_search']['#attributes']['name'] = 'cse-search-box';
      $variables['custom_search']['actions']['submit']['#attributes']['name'] = 'wb-srch-sub';
      $variables['custom_search']['actions']['submit']['#value'] = '<span class="glyphicon-search glyphicon"></span><span class="wb-inv">Search</span>';
      $variables['custom_search']['custom_search_blocks_form_1']['#attributes']['placeholder'] = t('Search Drupal WxT');
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
  $variables['menu_terms_bar'] = $terms_bar_markup;

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
  $variables['menu_footer_bar'] = $footer_bar_markup;
}
