<?php

/**
 * Implements hook_views_data().
 */
function vehicles_custom_views_data() {
  $data['vehicles_custom'] = [
    'table' => [
      'group' => t('Custom vehicles table'),
      'provider' => 'vehicles_custom',
      'base' => [
        'field' => 'custom_id',
        'title' => t('Custom vehicles table'),
      ],
    ],
    'custom_id' => [
      'title' => t('Custom ID'),
      'field' => [
        'id' => 'numeric',
      ],
      'sort' => [
        'id' => 'numeric',
      ],
      'filter' => [
        'id' => 'numeric',
      ],
      'argument' => [
        'id' => 'numeric',
      ],
    ],
    'vehicle_name' => [
      'title' => t('Vehicle Name'),
      'field' => [
        'id' => 'standard',
      ],
      'filter' => [
        'id' => 'string',
      ],
    ],
    'vehicle_colour' => [
      'title' => t('Vehicle Colour'),
      'field' => [
        'id' => 'standard',
      ],
      'filter' => [
        'id' => 'string',
      ],
    ],
    'owner_id' => [
      'title' => t('Owner ID'),
      'field' => [
        'id' => 'numeric',
      ],
      'sort' => [
        'id' => 'numeric',
      ],
      'filter' => [
        'id' => 'numeric',
      ],
      'argument' => [
        'id' => 'numeric',
      ],
    ],
  ];

  return $data;
}
