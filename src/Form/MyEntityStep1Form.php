<?php

namespace Drupal\ct_wizard_content_entity_example\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for My entity edit forms.
 *
 * @ingroup ct_wizard_content_entity_example
 */
class MyEntityStep1Form extends MyEntityForm {

  /**
   * Initialize the form state and the entity before the first form build.
   * Not working with the version from the base form.
   */
  protected function init(FormStateInterface $form_state) {
    /* @var $entity \Drupal\ct_wizard_content_entity_example\Entity\MyEntity */
    $entity = $form_state->getTemporaryValue('wizard')['my_entity'];

    // Set the entity on the content entity form. To get rid on:
    // Fatal error: Call to a member function getUntranslated() on null
    $this->setEntity($entity);

    // Set module Handler to get rid of error:
    // Fatal error: Call to a member function getImplementations() on null
    $this->setModuleHandler(\Drupal::service('module_handler'));
    parent::init($form_state);

  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\ct_wizard_content_entity_example\Entity\MyEntity */
    $form = parent::buildForm($form, $form_state);

    $entity = $this->entity;

    // Make a small form variant by unsetting the name field.
    unset($form['name']);

    return $form;
  }

}
