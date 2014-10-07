<?php
/**
 * @file
 * menu-link.func.php
 */

/**
 * Overrides theme_menu_link().
 */
function wetkit_bootstrap_menu_link(array $variables) {
  $element = $variables['element'];
  $sub_menu = '';

  if ($element['#below']) {
    // Prevent dropdown functions from being added to management menu so it
    // does not affect the navbar module.
    if (($element['#original_link']['menu_name'] == 'management') && (module_exists('navbar'))) {
      $sub_menu = drupal_render($element['#below']);
    }
    elseif ((!empty($element['#original_link']['depth'])) && ($element['#original_link']['depth'] == 1)) {
      // Add our own wrapper.
      unset($element['#below']['#theme_wrappers']);
      $sub_menu = '<ul class="dropdown-menu">' . drupal_render($element['#below']) . '</ul>';
      // Generate as standard dropdown.
      $element['#title'] .= ' <span class="caret"></span>';
      $element['#attributes']['class'][] = 'dropdown';
      $element['#localized_options']['html'] = TRUE;

      // Set dropdown trigger element to # to prevent inadvertant page loading
      // when a submenu link is clicked.
      $element['#localized_options']['attributes']['data-target'] = '#';
      $element['#localized_options']['attributes']['class'][] = 'dropdown-toggle';
      $element['#localized_options']['attributes']['data-toggle'] = 'dropdown';
    }
  }
  // On primary navigation menu, class 'active' is not set on active menu item.
  // @see https://drupal.org/node/1896674
  if (($element['#href'] == $_GET['q'] || ($element['#href'] == '<front>' && drupal_is_front_page())) && (empty($element['#localized_options']['language']))) {
    $element['#attributes']['class'][] = 'active';
  }
  $output = l($element['#title'], $element['#href'], $element['#localized_options']);
  return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";
}

/**
 * Overrides theme_menu_tree().
 */
function wetkit_bootstrap_menu_link__menu_block__main_menu(&$variables) {
  $element = $variables['element'];
  $sub_menu = '';
  $mb_mainlink = '<li class="slflnk">' . l($element['#title'] . ' - ' . t('More'), $element['#href'], $element['#localized_options']) . '</li>';
  $depth = $element['#original_link']['depth'];

  if ($element['#below']) {
    if ((!empty($element['#original_link']['depth'])) && ($element['#original_link']['depth'] == 1)) {
      // Add our own wrapper.
      unset($element['#below']['#theme_wrappers']);
      $sub_menu = '<ul class="sm list-unstyled">' . drupal_render($element['#below']) . $mb_mainlink . '</ul>';
      // Generate as standard dropdown.
      $element['#attributes']['class'][] = 'dropdown';
      $element['#localized_options']['html'] = TRUE;

      // Set dropdown trigger element to # to prevent inadvertant page loading
      // when a submenu link is clicked.
      $element['#localized_options']['attributes']['data-target'] = '#';
      $element['#localized_options']['attributes']['class'][] = 'item';
      $element['#localized_options']['attributes']['data-toggle'] = 'dropdown';
    }
  }
  // On primary navigation menu, class 'active' is not set on active menu item.
  // @see https://drupal.org/node/1896674
  if (($element['#href'] == $_GET['q'] || ($element['#href'] == '<front>' && drupal_is_front_page())) && (empty($element['#localized_options']['language']))) {
    $element['#attributes']['class'][] = 'active';
  }
  $output = (in_array($element['#href'], array('<nolink>')) ? $element['#title'] : l($element['#title'], $element['#href'], $element['#localized_options']));
  return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";
}

/**
 * Overrides theme_menu_tree().
 */
function wetkit_bootstrap_menu_link__menu_block__mid_footer_menu(&$variables) {
  global $counter;
  global $needs_closing;

  $element = $variables['element'];
  $sub_menu = '';

  // WxT Settings.
  $wxt_active = variable_get('wetkit_wetboew_theme', 'wet-boew');
  $library_path = libraries_get_path($wxt_active, TRUE);
  $wxt_active = str_replace('-', '_', $wxt_active);
  $wxt_active = str_replace('wet_boew_', '', $wxt_active);

  if ($element['#below']) {
    if ((!empty($element['#original_link']['depth'])) && ($element['#original_link']['depth'] == 1)) {
      $sub_menu = '<ul class="list-unstyled">' . drupal_render($element['#below']) . '</ul>';
    }
  }

  // On primary navigation menu, class 'active' is not set on active menu item.
  // @see https://drupal.org/node/1896674
  if (($element['#href'] == $_GET['q'] || ($element['#href'] == '<front>' && drupal_is_front_page())) && (empty($element['#localized_options']['language']))) {
    $element['#attributes']['class'][] = 'active';
  }

  if ($element['#original_link']['depth'] == 1) {
    if ($wxt_active == 'gcweb') {
      $counter = $counter + 1;
      $output = '<h3>' . (in_array($element['#href'], array('<nolink>')) ? $element['#title'] : l($element['#title'], $element['#href'], $element['#localized_options'])) . '</h3>';
      if ($counter < 3) {
        return '<section class="col-sm-3">' . $output . $sub_menu . '</section>';
      }
      elseif ($counter % 2 != 0) {
        return '<div class="col-sm-3 brdr-lft"><section>' . $output . $sub_menu . '</section>';
      }
      elseif ($counter % 2 == 0) {
        return '<section>' . $output . $sub_menu . '</section></div>';
      }
    }
    else {
      $output = '<h3>' . l($element['#title'], $element['#href'], $element['#localized_options']) . '</h3>';
      return '<section class="col-sm-3">' . $output . $sub_menu . '</section>';
    }
  }
  else {
    $output = (in_array($element['#href'], array('<nolink>')) ? $element['#title'] : l($element['#title'], $element['#href'], $element['#localized_options']));
    return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";
  }
}

/**
 * Overrides theme_menu_link() for book module.
 */
function wetkit_bootstrap_menu_link__book_toc(array $variables) {
  $element = $variables['element'];
  $sub_menu = drupal_render($element['#below']);
  $element['#attributes']['role'] = 'presentation';
  $link = TRUE;
  if ($element['#title'] && $element['#href'] === FALSE) {
    $element['#attributes']['class'][] = 'dropdown-header';
    $link = FALSE;
  }
  elseif ($element['#title'] === FALSE && $element['#href'] === FALSE) {
    $element['#attributes']['class'][] = 'divider';
    $link = FALSE;
  }
  elseif (($element['#href'] == $_GET['q'] || ($element['#href'] == '<front>' && drupal_is_front_page())) && (empty($element['#localized_options']['language']))) {
    $element['#attributes']['class'][] = 'active';
  }
  if ($link) {
    $element['#title'] = l($element['#title'], $element['#href'], $element['#localized_options']);
  }
  return '<li' . drupal_attributes($element['#attributes']) . '>' . $element['#title'] . $sub_menu . "</li>\n";
}
