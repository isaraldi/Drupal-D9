<?php

/**
 * @file
 * Contains Drupal\uns_chargeback\Plugin\QueueWorker\SendChargebackEmail.php
 */

namespace Drupal\uns_chargeback\Plugin\QueueWorker;

use Drupal\Core\Annotation\QueueWorker;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Queue\QueueWorkerBase;
use Drupal\uns_chargeback\Mail\SendChargebackEmailInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Processes the SendChargebackEmail Queue Workers.
 *
 * @QueueWorker(
 *   id = "chargeback_mail",
 *   title = @Translation("Cron SendChargebackEmail sender"),
 *   cron = {"time" = 10}
 * )
 */
class SendChargebackEmail extends QueueWorkerBase implements ContainerFactoryPluginInterface {

  /**
   * The send_chargeback service.
   *
   * @var \Drupal\uns_chargeback\Mail\SendChargebackEmailInterface
   */
  protected $sendChargebackEmail;

  /**
   * The entity type manager service.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a new SendChargebackEmail object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param array $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   Entity type manager service.
   */
  public function __construct(array $configuration, $plugin_id, array $plugin_definition,
    EntityTypeManagerInterface $entity_type_manager, SendChargebackEmailInterface $sendChargebackEmail) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);

    $this->entityTypeManager = $entity_type_manager;
    $this->sendChargebackEmail = $sendChargebackEmail;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_type.manager'),
      $container->get('uns_chargeback.chargeback_mail'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function processItem($data) {
    $node = $this->entityTypeManager->getStorage('node')->load($data['node_id']);
    $chargeback = $this->entityTypeManager->getStorage('chargeback')->load($data['chargeback_id']);
    if ($node && $chargeback) {
      $this->sendChargebackEmail->send($node, $chargeback);
    }
  }
}
