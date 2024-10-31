<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;
if ( ! class_exists( 'Rotem_Mortgage_Calculator' ) ) :

	/**
	 * Main Rotem_Mortgage_Calculator Class.
	 *
	 * @package		ROTEMMORTG
	 * @subpackage	Classes/Rotem_Mortgage_Calculator
	 * @since		1.0.0
	 * @author		Rotem Shmueli
	 */
	final class Rotem_Mortgage_Calculator {

		/**
		 * The real instance
		 *
		 * @access	private
		 * @since	1.0.0
		 * @var		object|Rotem_Mortgage_Calculator
		 */
		private static $instance;

		/**
		 * ROTEMMORTG helpers object.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @var		object|Rotem_Mortgage_Calculator_Helpers
		 */
		public $helpers;

		/**
		 * ROTEMMORTG settings object.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @var		object|Rotem_Mortgage_Calculator_Settings
		 */
		public $settings;

		/**
		 * Throw error on object clone.
		 *
		 * Cloning instances of the class is forbidden.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @return	void
		 */
		public function __clone() {
			_doing_it_wrong( __FUNCTION__, __( 'You are not allowed to clone this class.', 'rotem-mortgage-calculator' ), '1.0.0' );
		}

		/**
		 * Disable unserializing of the class.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @return	void
		 */
		public function __wakeup() {
			_doing_it_wrong( __FUNCTION__, __( 'You are not allowed to unserialize this class.', 'rotem-mortgage-calculator' ), '1.0.0' );
		}

		/**
		 * Main Rotem_Mortgage_Calculator Instance.
		 *
		 * Insures that only one instance of Rotem_Mortgage_Calculator exists in memory at any one
		 * time. Also prevents needing to define globals all over the place.
		 *
		 * @access		public
		 * @since		1.0.0
		 * @static
		 * @return		object|Rotem_Mortgage_Calculator	The one true Rotem_Mortgage_Calculator
		 */
		public static function instance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Rotem_Mortgage_Calculator ) ) {
				self::$instance					= new Rotem_Mortgage_Calculator;
				self::$instance->base_hooks();
				self::$instance->includes();
				self::$instance->helpers		= new Rotem_Mortgage_Calculator_Helpers();
				self::$instance->settings		= new Rotem_Mortgage_Calculator_Settings();

				//Fire the plugin logic
				new Rotem_Mortgage_Calculator_Run();

				/**
				 * Fire a custom action to allow dependencies
				 * after the successful plugin setup
				 */
				do_action( 'ROTEMMORTG/plugin_loaded' );
			}

			return self::$instance;
		}

		/**
		 * Include required files.
		 *
		 * @access  private
		 * @since   1.0.0
		 * @return  void
		 */
		private function includes() {
			require_once ROTEMMORTG_PLUGIN_DIR . 'core/includes/classes/class-rotem-mortgage-calculator-helpers.php';
			require_once ROTEMMORTG_PLUGIN_DIR . 'core/includes/classes/class-rotem-mortgage-calculator-settings.php';

			require_once ROTEMMORTG_PLUGIN_DIR . 'core/includes/classes/class-rotem-mortgage-calculator-run.php';
		}

		/**
		 * Add base hooks for the core functionality
		 *
		 * @access  private
		 * @since   1.0.0
		 * @return  void
		 */
		private function base_hooks() {
			add_action( 'plugins_loaded', array( self::$instance, 'load_textdomain' ) );
		}

		/**
		 * Loads the plugin language files.
		 *
		 * @access  public
		 * @since   1.0.0
		 * @return  void
		 */
		public function load_textdomain() {
			load_plugin_textdomain( 'rotem-mortgage-calculator', FALSE, dirname( plugin_basename( ROTEMMORTG_PLUGIN_FILE ) ) . '/languages/' );
		}

	}

endif; // End if class_exists check.