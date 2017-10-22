<?php

namespace Drupal\ct_wizard_content_entity_example;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the My entity entity.
 *
 * @see \Drupal\ct_wizard_content_entity_example\Entity\MyEntity.
 */
class MyEntityAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\ct_wizard_content_entity_example\Entity\MyEntityInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished my entity entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published my entity entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit my entity entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete my entity entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add my entity entities');
  }

}
