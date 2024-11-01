<?php 
namespace PureWCShopbuild;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
class Pure_Wc_Shopbuild_Post_Type 
{

	private $type;
    private $slug;
    private $name;
    private $plural_name;
    private $args = array();

	public function __construct( $args = array(), $type = 'custom_post' ) {
        $defaults = array(
            'name'          => __( 'Custom Post', 'shopbuild' ),
            'plural_name'   => __( 'Custom Post', 'shopbuild' ),
            'singular_name' => __( 'Custom Post', 'shopbuild' ),
            'slug'          => 'custom_post',
            'supports'      => ['title', 'editor', 'thumbnail', 'page-attributes', 'shopbuild']
        );

        $this->type = $type;
        $this->args = wp_parse_args($args, $defaults);
		$this->name = $this->args['name'];
        $this->slug = $this->args['slug'];
        $this->plural_name = $this->args['plural_name'];

		add_action( 'init', array( $this, 'register_custom_post_type' ) );
		
	}
	
	
	public function register_custom_post_type() {
		$labels = array(
			'name' => $this->name,
            'singular_name' => $this->name,
            'add_new' => sprintf( __('Add New Template', 'shopbuild'), $this->name ),/* translators: %s: placeholder */
            'add_new_item' => sprintf( __('Add New %s', 'shopbuild'), $this->name ), /* translators: %s: placeholder */
            'edit_item' => sprintf( __('Edit %s', 'shopbuild'), $this->name ), /* translators: %s: placeholder */
            'new_item' => sprintf( __('New %s', 'shopbuild'), $this->name ), /* translators: %s: placeholder */
            'all_items' => sprintf( __('All Templates', 'shopbuild'), $this->plural_name ),/* translators: %s: placeholder */
            'view_item' => sprintf( __('View %s', 'shopbuild'), $this->name ), /* translators: %s: placeholder */
            'search_items' => sprintf( __('Search %s', 'shopbuild'), $this->name ), /* translators: %s: placeholder */
            'not_found' => sprintf( __('No %s found' , 'shopbuild'), strtolower($this->name) ), /* translators: %s: placeholder */
            'not_found_in_trash' => sprintf( __('No %s found in Trash', 'shopbuild'), strtolower($this->name) ), /* translators: %s: placeholder */
            'parent_item_colon' => '',
            'menu_name' => $this->name,
		);

		$args   = array(
			'labels' => $labels,
            'public' => true,
            'exclude_from_search' => true,
            'show_in_rest' => true,
            'show_ui' => true,
            'show_in_menu' => $this->args['show_in_menu'],
            'show_in_nav_menus' => $this->args['show_in_nav_menus'],
            'rewrite' => [ 'slug' => $this->slug ],
            'capability_type' => 'page',
            'menu_position' => 10,
            'supports' => $this->args['supports'],
            'menu_icon' => 'dashicons-admin-page'
		);

		register_post_type( $this->type, $args );
        $this->enable_custom_post_with_elementor();
	}

    public function enable_custom_post_with_elementor(){
        $elementor_enable = get_option('elementor_cpt_support');
        if( !empty($elementor_enable) ){
            $elementor_enable_update = wp_parse_args(array($this->type), $elementor_enable);
            update_option('elementor_cpt_support', $elementor_enable_update);
        }
        if(!$elementor_enable){
            $elementor_enable_update = wp_parse_args(array($this->type, 'post', 'page'), $elementor_enable);
            update_option('elementor_cpt_support', $elementor_enable_update);
        }
    }
}