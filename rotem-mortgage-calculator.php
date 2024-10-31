<?php
/**
 * Rotem Mortgage Calculator
 *
 * @package       ROTEMMORTG
 * @author        Rotem Shmueli
 * @version       1.0.0
 *
 * @wordpress-plugin
 * Plugin Name:   Rotem Mortgage Calculator
 * Plugin URI:    https://www.journey.co.il/mortgage
 * Description:   A calculator for mortgage
 * Version:       1.0.0
 * Author:        Rotem Shmueli
 * Author URI:    https://www.journey.co.il/
 * Text Domain:   rotem-mortgage-calculator
 * Domain Path:   /languages
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;
// Plugin name
define( 'ROTEMMORTG_NAME',			'Rotem Mortgage Calculator' );

// Plugin version
define( 'ROTEMMORTG_VERSION',		'1.0.0' );

// Plugin Root File
define( 'ROTEMMORTG_PLUGIN_FILE',	__FILE__ );

// Plugin base
define( 'ROTEMMORTG_PLUGIN_BASE',	plugin_basename( ROTEMMORTG_PLUGIN_FILE ) );

// Plugin Folder Path
define( 'ROTEMMORTG_PLUGIN_DIR',	plugin_dir_path( ROTEMMORTG_PLUGIN_FILE ) );

// Plugin Folder URL
define( 'ROTEMMORTG_PLUGIN_URL',	plugin_dir_url( ROTEMMORTG_PLUGIN_FILE ) );

/**
 * Load the main class for the core functionality
 */
require_once ROTEMMORTG_PLUGIN_DIR . 'core/class-rotem-mortgage-calculator.php';

/**
 * The main function to load the only instance
 * of our master class.
 *
 * @author  Rotem Shmueli
 * @since   1.0.0
 * @return  object|Rotem_Mortgage_Calculator
 */
function ROTEMMORTG() {
	return Rotem_Mortgage_Calculator::instance();
}

ROTEMMORTG();

function rotem_mortgage_calculator_load_textdomain() {
	$plugin_dir = basename(dirname(__FILE__));
	load_plugin_textdomain('rotem-mortgage-calculator', false, $plugin_dir . '/languages');
  }
  add_action('plugins_loaded', 'rotem_mortgage_calculator_load_textdomain');  

function rotem_rotemmortgage_class() { 

	$site_language = get_locale();

	if ($site_language == 'he_IL') {
		$translation = array(
			'סכום ההלוואה',
			'תקופה בשנים',
			'ריבית שנתית',
			'חישוב',
			'יש למלא את כל השדות',
			'החזר חודשי',
			'סך הכל החזר',
			'₪',
			'מחשבון משכנתא'
		);
	} else {
		$translation = array(
			'Amount',
			'Years',
			'interest',
			'Calculate',
			'You must fill all fields',
			'Monthly payback',
			'Total cost',
			'$',
			'Mortgage calculator'
		);
	}

	return '
	<style>

	.rotem-mortgage * {
		-webkit-box-sizing: border-box;
		-moz-box-sizing:    border-box;
		box-sizing:         border-box;
	}	

	.rotem-mortgage {
		display: flex;
		justify-content: center;
	  }
	  
	  .rotem-mortgage-label {
		display: block;
		margin-bottom: 16px;
	  }
	  
	  .rotem-mortgage-label span {
		display: block;
		margin-bottom: 8px;
	  }
	  
	  .rotem-mortgage-label input {
		width: 100%;
		padding: 10px;
		border: 1px solid #ccc;
		border-radius: 4px;
	  }
	  
	  .rotem-mortgage-button {
		display: block;
		margin-top: 22px;
		padding: 8px 16px;
		font-size: 18px;
		background-color: #0077cc;
		color: #fff;
		border: none;
		border-radius: 4px;
		cursor: pointer;
	  }
	  
	  .rotem-mortgage-button:hover {
		background-color: #005fa3;
	  }

	  .rotem-mortgage-result:empty {
		display:none;
	  }
	  
	  .rotem-mortgage-result {
		margin-top: 16px;
		padding: 16px;
		background-color: #f2f2f2;
		border: 1px solid #ccc;
		border-radius: 4px;
		font-size: 16px;
		line-height: 1.5;
	  }

		  .rotem-mortgage-form {
			width: 400px;
			margin: 16px;
			padding: 16px;
			background-color: #fff;
			border: 1px solid #ccc;
			border-radius: 4px;
			box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
		  }

		  .rotem-mortgage-title {
			font-weight: bold;
			margin-bottom: 10px;
		  }
		  
		  
	</style>
	<div class="rotem-mortgage">
		<div class="rotem-mortgage-form">
			<div class="rotem-mortgage-title">'.$translation[8].'</div>
			<label class="rotem-mortgage-label">
				<span>'.$translation[0].'</span>
				<input type="number" name="rotem-price"/>
			</label>
			<label class="rotem-mortgage-label">
				<span>'.$translation[1].'</span>
				<input type="number" name="rotem-years"/>
			</label>
			<label class="rotem-mortgage-label">
				<span>'.$translation[2].'</span>
				<input type="number" name="rotem-rate"/>
			</label>
			<button onClick="return calculateMortgage();" class="rotem-mortgage-button">'.$translation[3].'</button>
			<div class="rotem-mortgage-result"></div>
		</div>
	</div>
	
	<script>
	function calculateMortgage() {
		var price = document.getElementsByName("rotem-price")[0].value;
		var years = document.getElementsByName("rotem-years")[0].value;
		var rate = document.getElementsByName("rotem-rate")[0].value;
		var resultDiv = document.querySelector(".rotem-mortgage-result");
	  
		// Check if all fields are filled
		if (price == "" || years == "" || rate == "") {
		  resultDiv.innerHTML = "'.htmlentities($translation[4]).'";
		  return;
		}
	  
		// Calculate monthly payback and total cost
		var monthlyRate = (rate / 12) / 100;
		var months = years * 12;
		var monthlyPayback = (price * monthlyRate) / (1 - Math.pow(1 + monthlyRate, -months));
		var totalCost = monthlyPayback * months;
	  
		// Display results
		resultDiv.innerHTML = "'.htmlentities($translation[5]).': " + monthlyPayback.toFixed(2) + " '.$translation[7].'<br>'.htmlentities($translation[6]).': " + totalCost.toFixed(2) + " '.$translation[7].'";
	  }
	   
	</script>
	';
} 

add_shortcode('rotemmortgage', 'rotem_rotemmortgage_class'); 