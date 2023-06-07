<?php
/**
 * Plugin Name:  IONOS Performance
 * Plugin URI:   https://www.ionos.com
 * Description:  IONOS Performance uses a cache to store HTML content generated by WordPress temporarily. You can use this cache to improve your website’s performance without the need for cumbersome configuration simply by activating this plugin.
 * Version:      2.0.3
 * License:      GPLv2 or later
 * Author:       IONOS
 * Author URI:   https://www.ionos.com
 * Text Domain:  ionos-performance
 * Domain Path:  /languages
 *
 * @package Ionos\Performance
 */

/*
Copyright 2022 IONOS
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Online: http://www.gnu.org/licenses/gpl.txt
*/

namespace Ionos\Performance;

use Ionos\Performance\Config;
use Ionos\Performance\Options;
use Ionos\Performance\Warning;
use Ionos\Performance\Updater;
use Ionos\PluginStateHookHandler\PluginState;

define( 'IONOS_PERFORMANCE_FILE', __FILE__ );
define( 'IONOS_PERFORMANCE_DIR', __DIR__ );
define( 'IONOS_PERFORMANCE_BASE', plugin_basename( __FILE__ ) );
define( 'IONOS_PERFORMANCE_CACHE_DIR', WP_CONTENT_DIR . '/cache/ionos-performance' );

\add_filter( 'ionos_library_main_plugin_file_path', __NAMESPACE__ . '\filter_main_plugin_file_path', 10, 2 );

$autoloader = __DIR__ . '/vendor/autoload.php'; // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
if ( is_readable( $autoloader ) ) {
	require_once $autoloader;
}

( new PluginState( IONOS_PERFORMANCE_FILE ) )
	->register_cleanup_hooks()
	->remove_options_on_uninstall( [ 'ionos-performance', 'ionos_performance_upgrade_check_v1_to_v2' ] );

/**
 * Init plugin.
 *
 * @return void
 */
function init() {
	Options::set_tenant_and_plugin_name( 'ionos', 'performance' );

	if ( ! Config::get( 'features.basicSettings.enabled' ) && ! Config::get( 'features.caching.enabled' ) ) {
		// Config structure changed from 1.x to 2.x, so let’s see if we just need to remove the transient.
		if ( ! get_option( 'ionos_performance_upgrade_check_v1_to_v2' ) ) {
			delete_transient( 'ionos_performance_config' );
			update_option( 'ionos_performance_upgrade_check_v1_to_v2', 1 );
		}
		return;
	}

	if ( ! wp_next_scheduled( 'ionos_performance_health_check_cron' ) ) {
		wp_schedule_event( time(), 'twicedaily', 'ionos_performance_health_check_cron' );
	}

	new Updater();
	new Warning( 'ionos-performance' );

	$settings = new Settings();
	$settings->init();
}

\add_action( 'plugins_loaded', __NAMESPACE__ . '\init', 5 );

/**
 * Plugin deactivation routine
 *
 * @return void
 */
function deactivate() {
	$timestamp = wp_next_scheduled( 'ionos_performance_health_check_cron' );
	wp_unschedule_event( $timestamp, 'ionos_performance_health_check_cron' );
}
register_deactivation_hook( IONOS_PERFORMANCE_FILE, __NAMESPACE__ . '\deactivate' );

/**
 * Plugin translation.
 *
 * @return void
 */
function load_textdomain() {
	\load_plugin_textdomain(
		'ionos-performance',
		false,
		\dirname( \plugin_basename( __FILE__ ) ) . '/languages/'
	);
}

\add_action( 'plugins_loaded', __NAMESPACE__ . '\load_textdomain', 5 );

/**
 * Filters the path for the plugin main file.
 *
 * @param string $path Path to be filtered.
 * @param string $plugin Plugin context.
 *
 * @return string
 */
function filter_main_plugin_file_path( $path, $plugin ) {
	if ( 'performance' === $plugin ) {
		return __FILE__;
	}

	return $path;
}