<?php

namespace Drupal\ct_wizard_content_entity_example\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for My entity entities.
 */
class MyEntityViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.

    return $data;
  }

}
