<?php

/**
 * @file
 * Contains my_entity.page.inc.
 *
 * Page callback for My entity entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for My entity templates.
 *
 * Default template: my_entity.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_my_entity(array &$variables) {
  // Fetch MyEntity Entity Object.
  $my_entity = $variables['elements']['#my_entity'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
