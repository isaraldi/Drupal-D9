<?php

namespace Drupal\uns_chargeback;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Defines the access control handler for the chargeback entity type.
 */
class ChargebackAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {

    switch ($operation) {
      case 'view':
        return AccessResult::allowedIfHasPermission($account, 'view chargeback');

      case 'update':
        return AccessResult::allowedIfHasPermissions($account, ['edit chargeback', 'administer chargeback'], 'OR');

      case 'delete':
        return AccessResult::allowedIfHasPermissions($account, ['delete chargeback', 'administer chargeback'], 'OR');

      default:
        // No opinion.
        return AccessResult::neutral();
    }

  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermissions($account, ['create chargeback', 'administer chargeback'], 'OR');
  }

}
