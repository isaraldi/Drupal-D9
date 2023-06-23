<?php

/**
 * @file
 * Install and uninstall functions for the D9 Core module.
 */

/**
 * Enable paragraphs and admin toolbar module.
 */
function d9_core_post_update_install_initial_modules(&$sandbox) {
  \Drupal::service('module_installer')->install([
    'admin_toolbar',
    'paragraphs',
    'features',
    'features_ui',
  ]);
}

/**
 * Unpublish all node translations.
 */
function s9_core_post_update_unpublish_translations() {
  // Get all published nodes, except the FR and EN ones.
  $query = \Drupal::entityQuery('node')
    ->condition('status', Node::PUBLISHED)
    ->condition('langcode', 'en', '!=')
    ->condition('langcode', 'fr', '!=');
  $node_ids = $query->execute();

  if (!empty($node_ids)) {
    foreach ($node_ids as $nid) {
      $node = Node::load($nid);

      // Get all the node languages, as it can have more than one translation.
      $languages = $node?->getTranslationLanguages(FALSE);
      foreach ($languages as $language) {
        $translation = $node?->getTranslation($language->getId());
        // We don't want to unpublish French nodes.
        if ($language->getId() !== 'fr') {
          // Set the translation's status to unpublished.
          $translation->setUnpublished();
          $translation->save();
          \Drupal::messenger()->addMessage(t('Node translation with ID @nid in
        language @langcode has been unpublished.', [
            '@nid' => $translation->id(),
            '@langcode' => $language->getId(),
          ]));
        }
      }
    }
  } else {
    \Drupal::messenger()->addMessage(t('No published nodes found.'));
  }
}
