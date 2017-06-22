<?php
/**
 * WPPR Admin Render Controller
 *
 * @package     WPPR
 * @subpackage  Admin
 * @copyright   Copyright (c) 2017, Bogdan Preda
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       3.0.0
 */

/**
 * Class WPPR_Admin_Render_Controller for handling page rendering.
 */
class WPPR_Admin_Render_Controller {

	/**
	 * The ID of this plugin.
	 *
	 * @since    3.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    3.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Stores the helper class to render elements.
	 *
	 * @since   3.0.0
	 * @access  private
	 * @var WPPR_Html_Fields $html_helper The HTML helper class.
	 */
	private $html_helper;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since   3.0.0
	 * @param   string $plugin_name The name of this plugin.
	 * @param   string $version     The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->html_helper = new WPPR_Html_Fields();
	}

	/**
	 * Utility method to include required layout.
	 *
	 * @since   3.0.0
	 * @access  public
	 * @param   string $name   The name of the layout to be retrieved.
	 */
	public function retrive_template( $name ) {
		if ( file_exists( WPPR_PATH . '/includes/admin/layouts/css/' . $name . '.css' ) ) {
			wp_enqueue_style( $this->plugin_name . '-' . $name . '-css', WPPR_URL . '/includes/admin/layouts/css/' . $name . '.css', array(), $this->version );
		}
		include_once( WPPR_PATH . '/includes/admin/layouts/' . $name . '_tpl.php' );
	}

	/**
	 * Method to controll what element is rendered based on type.
	 *
	 * @since   3.0.0
	 * @access  public
	 * @param   array $field  The array to use when rendering.
	 * @return mixed
	 */
	public function add_element( $field ) {
		$output = '
            <div class="controls">
				<div class="explain">' . $field['name'] . '</div>
				<p class="field_description">' . $field['description'] . '</p>
        ';
		switch ( $field['type'] ) {
			case 'input_text':
				$output .= $this->html_helper->text( $field );
				break;
			case 'select':
				$output .= $this->html_helper->select( $field );
				break;
			case 'color':
				$output .= $this->html_helper->color( $field );
				break;
			case 'text':
				$output .= $this->html_helper->text( $field );
				break;
		}

		$output .= '</div>';
		echo $output;

		if ( isset( $errors ) ) { return $errors; }
	}
}
