<?php
/**
 * @file
 * Stub file for wetkit_bootstrap_checkboxes().
 */

/**
 * Returns HTML for a checkboxes form element.
 *
 * @param $variables
 *   An associative array containing:
 *   - element: An associative array containing the properties of the element.
 *     Properties used: #id, #name, #attributes, #checked, #return_value.
 *
 * @ingroup themeable
 */
function wetkit_bootstrap_checkboxes($variables) {
  $element = $variables['element'];

  if ($element['#required'] && empty($_GET['wbdisable'])) {
    // Add required attribute to checkbox element.
    // Don't add in basic HTML view as HTML5 will require 
    // all checkboxes in group to be checked to pass HTML5 validation
    $element['#children'] = str_replace('<input', '<input required="required"', $element['#children']);
  }

  return !empty($element['#children']) ? $element['#children'] : '' . '</fieldset>';
}
