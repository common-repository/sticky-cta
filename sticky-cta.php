<?php
/*
Plugin Name: Sticky CTA
Version: 1.0
Plugin URI: https://wordpress.org/plugins/sticky-cta
Description: High converting sticky call to action floating buttons sticks at the side of your page as the user scrolls.
Author: Suresh Shinde
Author URI: https://profiles.wordpress.org/suresh-shinde/
Text Domain: sticky-cta
Domain Path: /languages
License: GPL v3
*/

/**
 * Required plugin files
 */
require_once 'scta-main.php';
require_once 'scta-ui.php';


/**
 * Plugin Activation
 */
function scta_activate() {

	$scta_options = get_option( 'scta_settings' );

	$default_options = array(
		'show_on_frontpage' => 1,
		'show_on_posts' => 1,
		'show_on_pages' => 1
	);
	$scta_options = trim( $scta_options );
	    if ( empty( $scta_options ) ) {
	        return false;
	    }
	$new_settings = array_merge($scta_options, $default_options);

	update_option( 'scta_settings', $new_settings );

	/** @var  $default_options_showoncpt intializing empty array */
	$default_options_showoncpt = array();
	/** @var  $registered_cpts getting registered CPTs */
	$registered_cpts = get_post_types(array('_builtin' => false), 'objects');
	foreach ($registered_cpts as $registered_cpt){

		$default_options_showoncpt[] = $registered_cpt->name;

	}

	update_option('scta_showoncpt', $default_options_showoncpt);

}

register_activation_hook( __FILE__, 'scta_activate' );


/**
 * scta Instance
 */
$scta = new scta_main;