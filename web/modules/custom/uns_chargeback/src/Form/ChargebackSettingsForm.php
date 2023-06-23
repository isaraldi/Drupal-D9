<?php

namespace Drupal\uns_chargeback\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configuration form for a chargeback entity type.
 */
class ChargebackSettingsForm extends ConfigFormBase {

  /**
   * Config settings.
   *
   * @var string
   */
  const SETTINGS = 'uns_chargeback.settings';

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'chargeback_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      static::SETTINGS,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config(static::SETTINGS);

    $form['settings'] = [
      '#markup' => '<p>' . $this->t('Settings form for a chargeback entity type.') . '</p>',
    ];

    // Email addresses which will receive the chargeback emails.
    $form['settings']['email_addresses'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Email'),
      '#description' => $this->t('The email addresses that will receive the chargeback emails'),
      '#placeholder' => $this->t('Use comma to separate multiple email addesses'),
      '#default_value' => $config->get('email_addresses') ?? '',
    ];

    $form['actions'] = [
      '#type' => 'actions',
    ];

    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Save'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Retrieve the configuration and save the values.
    $this->config(static::SETTINGS)
      ->set('email_addresses', $form_state->getValue('email_addresses'))
      ->save();

    $this->messenger()->addStatus($this->t('The configuration has been updated.'));
  }

}
