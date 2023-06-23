<?php

namespace Drupal\uns_chargeback;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\user\EntityOwnerInterface;
use Drupal\Core\Entity\EntityChangedInterface;

/**
 * Provides an interface defining a chargeback entity type.
 */
interface ChargebackInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

  /**
   * Gets the chargeback title.
   *
   * @return string
   *   Title of the chargeback.
   */
  public function getTitle();

  /**
   * Sets the chargeback title.
   *
   * @param string $title
   *   The chargeback title.
   *
   * @return \Drupal\uns_chargeback\ChargebackInterface
   *   The called chargeback entity.
   */
  public function setTitle($title);

  /**
   * Gets the chargeback creation timestamp.
   *
   * @return int
   *   Creation timestamp of the chargeback.
   */
  public function getCreatedTime();

  /**
   * Sets the chargeback creation timestamp.
   *
   * @param int $timestamp
   *   The chargeback creation timestamp.
   *
   * @return \Drupal\uns_chargeback\ChargebackInterface
   *   The called chargeback entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the chargeback status.
   *
   * @return bool
   *   TRUE if the chargeback is enabled, FALSE otherwise.
   */
  public function isEnabled();

  /**
   * Sets the chargeback status.
   *
   * @param bool $status
   *   TRUE to enable this chargeback, FALSE to disable.
   *
   * @return \Drupal\uns_chargeback\ChargebackInterface
   *   The called chargeback entity.
   */
  public function setStatus($status);

}
