<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://https://author.example.com/
 * @since             1.0.0
 * @package           Movies_List
 *
 * @wordpress-plugin
 * Plugin Name:       Movies list
 * Plugin URI:        https://https://example.com/plugins/the-basics/
 * Description:       Adds a  Movies list post type with specified fields.
 * Version:           1.0.0
 * Author:            Bikash Sahoo
 * Author URI:        https://https://author.example.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       movies-list
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'MOVIES_LIST_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-movies-list-activator.php
 */
function activate_movies_list() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-movies-list-activator.php';
	Movies_List_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-movies-list-deactivator.php
 */
function deactivate_movies_list() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-movies-list-deactivator.php';
	Movies_List_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_movies_list' );
register_deactivation_hook( __FILE__, 'deactivate_movies_list' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-movies-list.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_movies_list() {

	$plugin = new Movies_List();
	$plugin->run();

}
run_movies_list();
