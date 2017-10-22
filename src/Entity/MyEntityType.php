<?php

namespace Drupal\ct_wizard_content_entity_example\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the My entity type entity.
 *
 * @ConfigEntityType(
 *   id = "my_entity_type",
 *   label = @Translation("My entity type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\ct_wizard_content_entity_example\MyEntityTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\ct_wizard_content_entity_example\Form\MyEntityTypeForm",
 *       "edit" = "Drupal\ct_wizard_content_entity_example\Form\MyEntityTypeForm",
 *       "delete" = "Drupal\ct_wizard_content_entity_example\Form\MyEntityTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\ct_wizard_content_entity_example\MyEntityTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "my_entity_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "my_entity",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/my_entity_type/{my_entity_type}",
 *     "add-form" = "/admin/structure/my_entity_type/add",
 *     "edit-form" = "/admin/structure/my_entity_type/{my_entity_type}/edit",
 *     "delete-form" = "/admin/structure/my_entity_type/{my_entity_type}/delete",
 *     "collection" = "/admin/structure/my_entity_type"
 *   }
 * )
 */
class MyEntityType extends ConfigEntityBundleBase implements MyEntityTypeInterface {

  /**
   * The My entity type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The My entity type label.
   *
   * @var string
   */
  protected $label;

}
