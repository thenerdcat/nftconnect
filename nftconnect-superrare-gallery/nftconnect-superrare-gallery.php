<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              www.thenerdcat.com
 * @since             1.0.0
 * @package           Nftconnect_Superrare_Gallery
 *
 * @wordpress-plugin
 * Plugin Name:       NFTConnect
 * Plugin URI:        https://superrare.co/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Fernando Torres
 * Author URI:        www.thenerdcat.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       nftconnect-superrare-gallery
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
define( 'NFTCONNECT_SUPERRARE_GALLERY_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-nftconnect-superrare-gallery-activator.php
 */
function activate_nftconnect_superrare_gallery() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-nftconnect-superrare-gallery-activator.php';
	Nftconnect_Superrare_Gallery_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-nftconnect-superrare-gallery-deactivator.php
 */
function deactivate_nftconnect_superrare_gallery() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-nftconnect-superrare-gallery-deactivator.php';
	Nftconnect_Superrare_Gallery_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_nftconnect_superrare_gallery' );
register_deactivation_hook( __FILE__, 'deactivate_nftconnect_superrare_gallery' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-nftconnect-superrare-gallery.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_nftconnect_superrare_gallery() {

	$plugin = new Nftconnect_Superrare_Gallery();
	$plugin->run();

}
run_nftconnect_superrare_gallery();
