<?php

namespace Drupal\uns_chargeback\Mail;

use Drupal\node\NodeInterface;
use Drupal\uns_chargeback\ChargebackInterface;

/**
 * Interface for abandoned cart mail service.
 */
interface SendChargebackEmailInterface {

  /**
   * Sends the chargeback email.
   *
   * @param \Drupal\node\NodeInterface $node
   *   The node.
   * @param \Drupal\uns_chargeback\ChargebackInterface $chargeback
   *   The chargeback.
   *
   * @return bool
   *   TRUE if the email was sent successfully, FALSE otherwise.
   */
  public function send(NodeInterface $order, ChargebackInterface $chargeback);

}
