<?php
namespace JLTPMD;

use JLTPMD\Libs\Helper;
use JLTPMD\Libs\Featured;
use JLTPMD\Inc\Classes\Recommended_Plugins;
use JLTPMD\Inc\Classes\Notifications\Notifications;
use JLTPMD\Inc\Classes\Pro_Upgrade;
use JLTPMD\Inc\Classes\Row_Links;
use JLTPMD\Inc\Classes\Upgrade_Plugin;
use JLTPMD\Inc\Classes\Feedback;
use JLTPMD\Inc\Classes\JLT_Post_Modified_Date;

/**
 * Main Class
 *
 * @post-modified-date
 * Jewel Theme <support@jeweltheme.com>
 * @version     1.0.4
 */

// No, Direct access Sir !!!
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * JLT_PMD Class
 */
if ( ! class_exists( '\JLTPMD\JLT_PMD' ) ) {

	/**
	 * Class: JLT_PMD
	 */
	final class JLT_PMD {

		const VERSION            = JLTPMD_VER;
		private static $instance = null;

		/**
		 * what we collect construct method
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function __construct() {
			$this->includes();
			add_action( 'plugins_loaded', array( $this, 'jltpmd_plugins_loaded' ), 999 );
			// Body Class.
			add_filter( 'admin_body_class', array( $this, 'jltpmd_body_class' ) );
			// This should run earlier .
			// add_action( 'plugins_loaded', [ $this, 'jltpmd_maybe_run_upgrades' ], -100 ); .
		}

		/**
		 * plugins_loaded method
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function jltpmd_plugins_loaded() {
			$this->jltpmd_activate();
		}

		/**
		 * Version Key
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public static function plugin_version_key() {
			return Helper::jltpmd_slug_cleanup() . '_version';
		}

		/**
		 * Activation Hook
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public static function jltpmd_activate() {
			$current_jltpmd_version = get_option( self::plugin_version_key(), null );

			if ( get_option( 'jltpmd_activation_time' ) === false ) {
				update_option( 'jltpmd_activation_time', strtotime( 'now' ) );
			}

			if ( is_null( $current_jltpmd_version ) ) {
				update_option( self::plugin_version_key(), self::VERSION );
			}

			$allowed = get_option( Helper::jltpmd_slug_cleanup() . '_allow_tracking', 'no' );

			// if it wasn't allowed before, do nothing .
			if ( 'yes' !== $allowed ) {
				return;
			}
			// re-schedule and delete the last sent time so we could force send again .
			$hook_name = Helper::jltpmd_slug_cleanup() . '_tracker_send_event';
			if ( ! wp_next_scheduled( $hook_name ) ) {
				wp_schedule_event( time(), 'weekly', $hook_name );
			}
		}


		/**
		 * Add Body Class
		 *
		 * @param [type] $classes .
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function jltpmd_body_class( $classes ) {
			$classes .= ' post-modified-date ';
			return $classes;
		}

		/**
		 * Run Upgrader Class
		 *
		 * @return void
		 */
		public function jltpmd_maybe_run_upgrades() {
			if ( ! is_admin() && ! current_user_can( 'manage_options' ) ) {
				return;
			}

			// Run Upgrader .
			$upgrade = new Upgrade_Plugin();

			// Need to work on Upgrade Class .
			if ( $upgrade->if_updates_available() ) {
				$upgrade->run_updates();
			}
		}

		/**
		 * Include methods
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function includes() {
			new Recommended_Plugins();
			new Row_Links();
			new Pro_Upgrade();
			new Notifications();
			new Featured();
			new Feedback();
			new JLT_Post_Modified_Date();
		}


		/**
		 * Initialization
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function jltpmd_init() {
			$this->jltpmd_load_textdomain();
		}


		/**
		 * Text Domain
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function jltpmd_load_textdomain() {
			$domain = 'post-modified-date';
			$locale = apply_filters( 'jltpmd_plugin_locale', get_locale(), $domain );

			load_textdomain( $domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo' );
			load_plugin_textdomain( $domain, false, dirname( JLTPMD_BASE ) . '/languages/' );
		}




		/**
		 * Returns the singleton instance of the class.
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof JLT_PMD ) ) {
				self::$instance = new JLT_PMD();
				self::$instance->jltpmd_init();
			}

			return self::$instance;
		}
	}

	// Get Instant of JLT_PMD Class .
	JLT_PMD::get_instance();
}