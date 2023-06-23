<?php

namespace Drupal\uns_chargeback\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for the chargeback entity edit forms.
 */
class ChargebackForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {

    $entity = $this->getEntity();
    $result = $entity->save();
    $link = $entity->toLink($this->t('View'))->toRenderable();

    $message_arguments = ['%label' => $this->entity->label()];
    $logger_arguments = $message_arguments + ['link' => render($link)];

    if ($result == SAVED_NEW) {
      $this->messenger()->addStatus($this->t('New chargeback %label has been created.', $message_arguments));
      $this->logger('chargeback')->notice('Created new chargeback %label', $logger_arguments);
    }
    else {
      $this->messenger()->addStatus($this->t('The chargeback %label has been updated.', $message_arguments));
      $this->logger('chargeback')->notice('Updated new chargeback %label.', $logger_arguments);
    }

    $form_state->setRedirect('entity.chargeback.canonical', ['chargeback' => $entity->id()]);
  }

}
