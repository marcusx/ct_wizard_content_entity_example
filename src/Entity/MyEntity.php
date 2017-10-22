<?php

namespace Drupal\ct_wizard_content_entity_example\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\UserInterface;

/**
 * Defines the My entity entity.
 *
 * @ingroup ct_wizard_content_entity_example
 *
 * @ContentEntityType(
 *   id = "my_entity",
 *   label = @Translation("My entity"),
 *   bundle_label = @Translation("My entity type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\ct_wizard_content_entity_example\MyEntityListBuilder",
 *     "views_data" = "Drupal\ct_wizard_content_entity_example\Entity\MyEntityViewsData",
 *     "translation" = "Drupal\ct_wizard_content_entity_example\MyEntityTranslationHandler",
 *
 *     "form" = {
 *       "default" = "Drupal\ct_wizard_content_entity_example\Form\MyEntityForm",
 *       "add" = "Drupal\ct_wizard_content_entity_example\Form\MyEntityForm",
 *       "edit" = "Drupal\ct_wizard_content_entity_example\Form\MyEntityForm",
 *       "delete" = "Drupal\ct_wizard_content_entity_example\Form\MyEntityDeleteForm",
 *     },
 *     "access" = "Drupal\ct_wizard_content_entity_example\MyEntityAccessControlHandler",
 *     "route_provider" = {
 *       "html" = "Drupal\ct_wizard_content_entity_example\MyEntityHtmlRouteProvider",
 *     },
 *     "wizard" = {
 *       "add_simple" = "Drupal\ct_wizard_content_entity_example\Wizard\MyEntityAddWizard",
 *     },
 *   },
 *   base_table = "my_entity",
 *   data_table = "my_entity_field_data",
 *   translatable = TRUE,
 *   admin_permission = "administer my entity entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "bundle" = "type",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *     "langcode" = "langcode",
 *     "status" = "status",
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/my_entity/{my_entity}",
 *     "add-page" = "/admin/structure/my_entity/add",
 *     "add-form" = "/admin/structure/my_entity/add/{my_entity_type}",
 *     "edit-form" = "/admin/structure/my_entity/{my_entity}/edit",
 *     "delete-form" = "/admin/structure/my_entity/{my_entity}/delete",
 *     "collection" = "/admin/structure/my_entity",
 *   },
 *   bundle_entity_type = "my_entity_type",
 *   field_ui_base_route = "entity.my_entity_type.edit_form"
 * )
 */
class MyEntity extends ContentEntityBase implements MyEntityInterface {

  use EntityChangedTrait;

  /**
   * {@inheritdoc}
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += [
      'user_id' => \Drupal::currentUser()->id(),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return $this->get('name')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setName($name) {
    $this->set('name', $name);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setCreatedTime($timestamp) {
    $this->set('created', $timestamp);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwner() {
    return $this->get('user_id')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwnerId() {
    return $this->get('user_id')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwnerId($uid) {
    $this->set('user_id', $uid);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwner(UserInterface $account) {
    $this->set('user_id', $account->id());
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function isPublished() {
    return (bool) $this->getEntityKey('status');
  }

  /**
   * {@inheritdoc}
   */
  public function setPublished($published) {
    $this->set('status', $published ? TRUE : FALSE);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Authored by'))
      ->setDescription(t('The user ID of author of the My entity entity.'))
      ->setRevisionable(TRUE)
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setTranslatable(TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'author',
        'weight' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'weight' => 5,
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'autocomplete_type' => 'tags',
          'placeholder' => '',
        ],
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The name of the My entity entity.'))
      ->setSettings([
        'max_length' => 50,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['status'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Publishing status'))
      ->setDescription(t('A boolean indicating whether the My entity is published.'))
      ->setDefaultValue(TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }

}
