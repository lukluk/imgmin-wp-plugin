<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://imgmin.co
 * @since             1.0.0
 * @package           Imgmin_Image_Cdn
 *
 * @wordpress-plugin
 * Plugin Name:       imgmin image optimizer cdn
 * Plugin URI:        http://imgmin.co
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            imgmin tech
 * Author URI:        http://imgmin.co
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       imgmin-image-cdn
 * Domain Path:       /languages
 */

require_once(dirname(__FILE__) . '/cdn_class.php');

global $cdnObject;
$cdnObject = new WP_CDNRewrites();

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'PLUGIN_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-imgmin-image-cdn-activator.php
 */
function activate_imgmin_image_cdn() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-imgmin-image-cdn-activator.php';
	Imgmin_Image_Cdn_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-imgmin-image-cdn-deactivator.php
 */
function deactivate_imgmin_image_cdn() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-imgmin-image-cdn-deactivator.php';
	Imgmin_Image_Cdn_Deactivator::deactivate();
}


if (!is_admin()) 
{
    add_action('get_header', array($cdnObject, 'pre_content'), PHP_INT_MAX);
    add_action('wp_footer', array($cdnObject, 'post_content'), PHP_INT_MAX);
}

register_activation_hook( __FILE__, 'activate_imgmin_image_cdn' );
register_deactivation_hook( __FILE__, 'deactivate_imgmin_image_cdn' );

add_action('admin_menu', array($cdnObject,'adminmenu'));
add_action('admin_notices', array($cdnObject,'addNotices'));
add_action ( 'admin_init' , array($cdnObject , 'init' ));

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-imgmin-image-cdn.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_imgmin_image_cdn() {

	$plugin = new Imgmin_Image_Cdn();
	$plugin->run();

}
run_imgmin_image_cdn();
