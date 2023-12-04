<?php
/**
 * Plugin Name: Pattern Organizer
 * Description: Access all your custom block patterns right from the WordPress Dashboard.
 * Version: 1.0
 * Author: Alan Jacob Mathew
 * Author URI: https://profiles.wordpress.org/alanjacobmathew/
 * License: GPLv3 or later
 * Plugin URI: https://github.com/alanjacobmathew/pattern-organizer
 * Requires at least: 5.8
 * Requires PHP: 7.3
 * Tested up to: 6.4
 * Text Domain: pattern-organizer
 * Domain Path: /languages/

 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

register_deactivation_hook(__FILE__, 'pofgb_pattern_organizer_deactivate');


function pofgb_add_pattern_organizer_menu() {
    // Create a new top-level menu item
    add_theme_page(
        __( 'Patterns' ), // Page title
        __( 'Pattern Organizer' ), // Menu title
        'manage_options',
        'edit.php?post_type=wp_block',
        '', // Callback
        4// Position
        ,array('edit_posts') // Capabilities
    );
	
}

add_action('admin_menu', 'pofgb_add_pattern_organizer_menu');

function pofgb_add_pattern_organizer_load_textdomain() {
    // Check if the language files exist
    $language_folder = plugin_dir_path(__FILE__) . 'languages/';
    if (!is_dir($language_folder)) {
        // If the folder doesn't exist, create it
        wp_mkdir_p($language_folder);
    }

    // Load the language files
    load_plugin_textdomain('pattern-organizer', false, $language_folder);
}

add_action('activate_plugin', 'pofgb_add_pattern_organizer_load_textdomain');

function pofgb_pattern_organizer_deactivate() {
// Remove language files
    $language_folder = plugin_dir_path(__FILE__) . 'languages/';
	
    if (is_dir($language_folder)) {
        $language_files = scandir($language_folder);
        foreach ($language_files as $file) {
            if (is_file($language_folder . $file)) {
                unlink($language_folder . $file);
            }
        }
        rmdir($language_folder);
    }
}