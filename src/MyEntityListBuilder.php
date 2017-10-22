<?php

namespace Drupal\ct_wizard_content_entity_example;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of My entity entities.
 *
 * @ingroup ct_wizard_content_entity_example
 */
class MyEntityListBuilder extends EntityListBuilder {


  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('My entity ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\ct_wizard_content_entity_example\Entity\MyEntity */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.my_entity.edit_form',
      ['my_entity' => $entity->id()]
    );
    return $row + parent::buildRow($entity);
  }

}
