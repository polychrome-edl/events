<?php
/*
 * EVENT TYPE TAXONOMY
 */

add_action('init', 'event_type_register');

function event_type_register() {
  register_taxonomy(
    'event_type',
    'events',
    array(
      'label' => 'Event types',
      'labels' => array(
        'name' => 'Event types',
        'singular_name' => 'Event type',
        'edit_item' => 'Edit type',
        'view_item' => 'View type',
        'update_item' => 'Update type',
        'add_new_item' => 'Add new event type',
        'new_item_name' => 'New event type name'
      ),
      'description' => 'Allows to sort events by their type'
    )
  );
}
?>
