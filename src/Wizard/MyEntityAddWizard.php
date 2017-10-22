<?php

namespace Drupal\ct_wizard_content_entity_example\Wizard;

use Drupal\Core\Entity\EntityInterface;
use Drupal\ctools\Wizard\EntityFormWizardBase;
use Drupal\ctools\Event\WizardEvent;
use Drupal\ctools\Wizard\FormWizardInterface;
use Drupal\Core\Form\FormStateInterface;

class MyEntityAddWizard extends EntityFormWizardBase {

  /**
   * The entity.
   *
   * @var \Drupal\ct_wizard_content_entity_example\Entity\MyEntityInterface
   */
  public $entity;

  /**
   * {@inheritdoc}
   */
  public function getWizardLabel() {
    return $this->t('Simple My Entity Add');
  }

  /**
   * {@inheritdoc}
   */
  public function getMachineLabel() {
    return $this->t('My Entity Label');
  }

  /**
   * {@inheritdoc}
   */
  public function getEntityType() {
    return 'my_entity';
  }

  /**
   * {@inheritdoc}
   */
  public function exists() {
    return '\Drupal\ct_wizard_content_entity_example\Entity\MyEntity::load';
  }


  /**
   * Fixes an error when loading the wizard as this method would exist in the
   * content entity form class.
   *
   * @param $element
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   * @param $form
   *
   * @return mixed
   */
  public function processForm($element, FormStateInterface $form_state, $form) {

    return $element;
  }

  /**
   * Fixes a problem during wizard build as this method is missing from the
   * wizard class.
   *
   * @param $entity_type_id
   * @param \Drupal\Core\Entity\EntityInterface $entity
   * @param array $form
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   */
  public function updateFormLangcode($entity_type_id, EntityInterface $entity, array $form, FormStateInterface $form_state) {
    return;
  }

  /**
   * Made up form_id as the logic in the content entity that creates that on
   * the normal entity route is to late.
   *
   * @return string
   */
  public function getFormId() {
    $form_id = 'my_entity_bundle_add_form';
    return $form_id;
  }

  /**
   * {@inheritdoc}
   */
  public function initValues() {

    // Build the entity similar to the logic in the content entity base form
    // and store it on the wizard object. (Sadly this doesn't help later)
    $storage = $this->entityManager->getStorage($this->getEntityType());
    $my_entity_type = $this->routeMatch->getParameter('my_entity_type');
    $entity = $storage->create(['type' => $my_entity_type->id()]);

    $values[$this->getEntityType()] = $entity;
    $this->entity = $entity;

    $event = new WizardEvent($this, $values);
    $this->dispatcher->dispatch(FormWizardInterface::LOAD_VALUES, $event);
    return $event->getValues();
  }

  /**
   * {@inheritdoc}
   */
  public function getOperations($cached_values) {

    $steps = [
      'step_1' => [
        'form' => 'Drupal\ct_wizard_content_entity_example\Form\MyEntityStep1Form',
        'title' => $this->t('Step 1'),
      ],
      'step_2' => [
        'form' => 'Drupal\ct_wizard_content_entity_example\Form\MyEntityStep2Form',
        'title' => $this->t('Step 2'),
      ],
    ];

    return $steps;
  }

  /**
   * {@inheritdoc}
   */
  public function getNextParameters($cached_values) {

    // Get the steps by key.
    $operations = $this->getOperations($cached_values);
    $steps = array_keys($operations);
    // Get the steps after the current step.
    $after = array_slice($operations, array_search($this->getStep($cached_values), $steps) + 1);
    // Get the steps after the current step by key.
    $after_keys = array_keys($after);
    $step = reset($after_keys);
    if (!$step) {
      $keys = array_keys($operations);
      $step = end($keys);
    }
    return [
      'my_entity_type' => 'example',
      'step' => $step,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getRouteName() {
    return 'entity.my_entity.add_simple_step_form';
  }
}
