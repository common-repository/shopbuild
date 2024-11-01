<?php
/**
 * Base widget class for core and common functionalites
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

abstract class Pure_Wc_Base_Widget extends \Elementor\Widget_Base {

    /**
	 * Get widget name.
	 *
	 * Retrieve button widget name.
	 *
	 * @since 1.0.3
	 * @access public
	 *
	 * @return string Widget name.
	 */

    public function get_name() {

	}

    /**
	 * Get widget title.
	 *
	 * Retrieve button widget title.
	 *
	 * @since 1.0.3
	 * @access public
	 *
	 * @return string Widget title.
	 */

	public function get_title() {

	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve button widget icon.
	 *
	 * @since 1.0.3
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'sb-widget-icon';
	}


    /**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the button widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
        return ['storebuild'];
    }

	public function get_keywords() {}
    /**
	 * Retrieve the list of scripts the widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 1.0.3
	 *
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends() {
		return [ 'shopbuild' ];
	}


	/**
	 * Must implement this function for content tab controls
	 */
	protected function register_content_controls(){}


	 /**
	 * Must implement this function for style tab controls
	 */
	protected function register_style_controls(){}
}