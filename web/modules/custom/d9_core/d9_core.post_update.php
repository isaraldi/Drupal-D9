<?php

/**
 * @file
 * Install and uninstall functions for the D9 Core module.
 */

/**
 * Enable paragraphs and admin toolbar module.
 */
function bb_core_post_update_install_initial_modules(&$sandbox) {
  \Drupal::service('module_installer')->install([
    'admin_toolbar',
    'paragraphs',
    'features',
    'features_ui',
  ]);
}
