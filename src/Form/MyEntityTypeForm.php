<?php

namespace Drupal\ct_wizard_content_entity_example\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class MyEntityTypeForm.
 */
class MyEntityTypeForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $my_entity_type = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $my_entity_type->label(),
      '#description' => $this->t("Label for the My entity type."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $my_entity_type->id(),
      '#machine_name' => [
        'exists' => '\Drupal\ct_wizard_content_entity_example\Entity\MyEntityType::load',
      ],
      '#disabled' => !$my_entity_type->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $my_entity_type = $this->entity;
    $status = $my_entity_type->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label My entity type.', [
          '%label' => $my_entity_type->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label My entity type.', [
          '%label' => $my_entity_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($my_entity_type->toUrl('collection'));
  }

}
