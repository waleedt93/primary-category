<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://profile.wordpress.org/waleedt93
 * @since             1.0.0
 * @package           Primary_Category
 *
 * @wordpress-plugin
 * Plugin Name:       Primary Category
 * Plugin URI:        https://github.com/waleedt93
 * Description:       This plugin allows users to designate a primary category for posts/custom post types and query posts/custom post types based on their primary categories.
 * Version:           1.0.0
 * Author:            Waleed
 * Author URI:        http://profile.wordpress.org/waleedt93
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       primary-category
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
define( 'PRIMARY_CATEGORY_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-primary-category-activator.php
 */
function activate_primary_category() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-primary-category-activator.php';
	Primary_Category_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-primary-category-deactivator.php
 */
function deactivate_primary_category() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-primary-category-deactivator.php';
	Primary_Category_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_primary_category' );
register_deactivation_hook( __FILE__, 'deactivate_primary_category' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-primary-category.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_primary_category() {

	$plugin = new Primary_Category();
	$plugin->run();

}
run_primary_category();
