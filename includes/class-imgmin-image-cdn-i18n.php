<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://imgmin.co
 * @since      1.0.0
 *
 * @package    Imgmin_Image_Cdn
 * @subpackage Imgmin_Image_Cdn/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Imgmin_Image_Cdn
 * @subpackage Imgmin_Image_Cdn/includes
 * @author     imgmin tech <luklukaha@gmail.com>
 */
class Imgmin_Image_Cdn_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'imgmin-image-cdn',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
