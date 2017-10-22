<?php

namespace Drupal\ct_wizard_content_entity_example\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for My entity edit forms.
 *
 * @ingroup ct_wizard_content_entity_example
 */
class MyEntityForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\ct_wizard_content_entity_example\Entity\MyEntity */
    $form = parent::buildForm($form, $form_state);

    $entity = $this->entity;

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity = &$this->entity;

    $status = parent::save($form, $form_state);

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label My entity.', [
          '%label' => $entity->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label My entity.', [
          '%label' => $entity->label(),
        ]));
    }
    $form_state->setRedirect('entity.my_entity.canonical', ['my_entity' => $entity->id()]);
  }

}
