<?php
/*
Plugin Name: Polikrom
Description: Events management for Polychrome. Depends on Advanced Custom Fields.
Author: Anatole Divoux
Author URI: http://github.com/polychrome-edl
*/

/*
 * EVENT POST TYPE
 */

/*
The event post type should have the following custom fields.
*/

add_action('init', 'events_register');

function events_register() {
	$labels_events = array(
		'name' => 'Events',
		'singular_name' => 'Event'
	);

	$args_events = array(
		'labels' => $labels_events,
		'description' => 'A custom type that describes an event that will take'.
			' place or already has.',
		
		// Available to readers
		'publicly_queryable' => true,
		'exclude_from_search' => false,

		// Displayed and editable for writers
		'show_ui' => true,
		'show_in_nav_menus' => true,
		'menu_icon' => 'dashicons-star-filled',

		// Capabilities
		'capability_type' => 'post',
		
		// Archiving
		'has_archive' => true,

		// Features
		'supports' => array(
			'title',
			'editor',
			'excerpt',
			'thumbnail',
			'custom-fields', 
			'comments',
			'revisions',
			'page-attributes'
		)
	);

	register_post_type('events', $args_events);
}

/*
 * LOCATION POST TYPE
 */

/*
The location post type should have a "location" custom field.
*/

add_action('init', 'locations_register');

function locations_register() {
	$labels_locations = array(
		'name' => 'Locations',
		'singular_name' => 'Location'
	 );

	$args_locations = array(
		'labels' => $labels_locations,
		'description' => 'A custom type that indicates a location where one or'.
			' multiple events will take place.',
		
		// Hidden from readers
		'publicly_queryable' => false,
		'exclude_from_search' => true,

		// Displayed and editable for writers
		'show_ui' => true,
		'show_in_nav_menus' => true,
		'menu_icon' => 'dashicons-location',

		// Capabilities
		'capability_type' => 'post',

		// Features
		'supports' => array(
			'title', // Just a title, we don't need any content?
			'thumbnail',
			'custom-fields'
		)
	);

	register_post_type('locations', $args_locations);
}

require_once "metabox.php";

?>
