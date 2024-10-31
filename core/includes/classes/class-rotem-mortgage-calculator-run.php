<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class Rotem_Mortgage_Calculator_Run
 *
 * Thats where we bring the plugin to life
 *
 * @package		ROTEMMORTG
 * @subpackage	Classes/Rotem_Mortgage_Calculator_Run
 * @author		Rotem Shmueli
 * @since		1.0.0
 */
class Rotem_Mortgage_Calculator_Run{

	/**
	 * Our Rotem_Mortgage_Calculator_Run constructor 
	 * to run the plugin logic.
	 *
	 * @since 1.0.0
	 */
	function __construct(){
		$this->add_hooks();
	}

	/**
	 * ######################
	 * ###
	 * #### WORDPRESS HOOKS
	 * ###
	 * ######################
	 */

	/**
	 * Registers all WordPress and plugin related hooks
	 *
	 * @access	private
	 * @since	1.0.0
	 * @return	void
	 */
	private function add_hooks(){
	
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_backend_scripts_and_styles' ), 20 );
	
	}

	/**
	 * ######################
	 * ###
	 * #### WORDPRESS HOOK CALLBACKS
	 * ###
	 * ######################
	 */

	/**
	 * Enqueue the backend related scripts and styles for this plugin.
	 * All of the added scripts andstyles will be available on every page within the backend.
	 *
	 * @access	public
	 * @since	1.0.0
	 *
	 * @return	void
	 */
	public function enqueue_backend_scripts_and_styles() {
		wp_enqueue_script( 'rotemmortg-backend-scripts', ROTEMMORTG_PLUGIN_URL . 'core/includes/assets/js/backend-scripts.js', array(), ROTEMMORTG_VERSION, false );
		wp_localize_script( 'rotemmortg-backend-scripts', 'rotemmortg', array(
			'plugin_name'   	=> __( ROTEMMORTG_NAME, 'rotem-mortgage-calculator' ),
		));
	}

}
