<?php

namespace Drupal\uns_chargeback\Mail;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Language\LanguageManagerInterface;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\Core\Mail\MailManager;
use Drupal\node\NodeInterface;
use Drupal\uns_chargeback\ChargebackInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Service for sending a chargeback mail.
 */
class SendChargebackEmail implements SendChargebackEmailInterface {

  /**
   * The mail manager.
   *
   * @var \Drupal\mailchimp_transactional\Service
   */
  protected $mailManager;

  /**
   * The system theme config object.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * The language manager.
   *
   * @var Drupal\Core\Language\LanguageManagerInterface
   */
  protected $languageManager;

  /**
   * The logger service.
   *
   * @var \Psr\Log\LoggerInterface
   */
  protected $logger;


  public function __construct(MailManager $mail_manager,
                              ConfigFactoryInterface $config_factory,
                              LanguageManagerInterface $language_manager,
                              LoggerChannelFactoryInterface $logger_factory) {
    $this->mailManager = $mail_manager;
    $this->configFactory = $config_factory;
    $this->languageManager = $language_manager;
    $this->logger = $logger_factory->get('mail');
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static (
      $container->get('plugin.manager.mail'),
      $container->get('config.factory'),
      $container->get('language_manager'),
      $container->get('logger.factory'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function send(NodeInterface $node, ChargebackInterface $chargeback) {
    // Get the email recipients which have been configured at /admin/structure/chargeback.
    $config = $this->configFactory->getEditable('uns_chargeback.settings');
    $emails = $config->get('email_addresses') ?? '';

    // Get site default language.
    $lang = $this->languageManager->getDefaultLanguage()->getId();

    // Configure the email content to use on the template.
    $params['en_long_title'] = $node->get('field_english_long_title')->value;
    $params['fr_long_title'] = $node->get('field_french_long_title')->value;
    $params['sp_long_title'] = $node->get('field_spanish_long_title')->value;
    $params['chargeback'] = $chargeback;

    // Send the email with all required parameters.
    $result = $this->mailManager->mail('uns_chargeback', 'chargeback_mail', $emails, $lang, $params);

    // If there is any errors when trying to send the email, log it.
    if (!$result['result']) {
      $this->logger->error('Error sending chargeback_email email (to %to).', [
        '%to' => $emails,
      ]);
    }
  }
}
