<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       www.thenerdcat.com
 * @since      1.0.0
 *
 * @package    Nftconnect_Superrare_Gallery
 * @subpackage Nftconnect_Superrare_Gallery/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Nftconnect_Superrare_Gallery
 * @subpackage Nftconnect_Superrare_Gallery/includes
 * @author     Fernando Torres <info@thenerdcat.com>
 */
class Nftconnect_Superrare_Gallery_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'nftconnect-superrare-gallery',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
