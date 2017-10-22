<?php

namespace Drupal\ct_wizard_content_entity_example\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining My entity entities.
 *
 * @ingroup ct_wizard_content_entity_example
 */
interface MyEntityInterface extends  ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the My entity name.
   *
   * @return string
   *   Name of the My entity.
   */
  public function getName();

  /**
   * Sets the My entity name.
   *
   * @param string $name
   *   The My entity name.
   *
   * @return \Drupal\ct_wizard_content_entity_example\Entity\MyEntityInterface
   *   The called My entity entity.
   */
  public function setName($name);

  /**
   * Gets the My entity creation timestamp.
   *
   * @return int
   *   Creation timestamp of the My entity.
   */
  public function getCreatedTime();

  /**
   * Sets the My entity creation timestamp.
   *
   * @param int $timestamp
   *   The My entity creation timestamp.
   *
   * @return \Drupal\ct_wizard_content_entity_example\Entity\MyEntityInterface
   *   The called My entity entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the My entity published status indicator.
   *
   * Unpublished My entity are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the My entity is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a My entity.
   *
   * @param bool $published
   *   TRUE to set this My entity to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\ct_wizard_content_entity_example\Entity\MyEntityInterface
   *   The called My entity entity.
   */
  public function setPublished($published);

}
