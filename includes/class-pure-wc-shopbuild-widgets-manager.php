<?php
/**
 * 
 * Elementor widgets manager class
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
use Elementor\Widgets_Manager;


class Pure_Widget_Manager {

    /** store all widgets map */
    private static $widgets_map;

    private static $widget_nonce = 'pure_wc_save_widgets'; 


    /**
     * init the class
     */
    public function __construct(){
      add_action( 'elementor/widgets/register', array( $this, 'register_widgets') );
      add_action( 'wp_ajax_' . self::$widget_nonce, array( $this, 'update_widgets' ) );
      add_action( 'wp_ajax_nopriv' . self::$widget_nonce, array( $this, 'update_widgets' ) );
      add_action( 'elementor/elements/categories_registered', array( $this, 'widget_categories' ) );
    }

    /**
     * get all the widgets
     */
    public static function get_widgets(){
      $defaults_addons = pure_wc_elementor_addons();
      return $defaults_addons;
    }

    /**
     * Map all the widgets here
     */
    public static function set_widgets( $widgets = array() ){
      self::$widgets_map = $widgets;
    }


    /**
     * Get widget option from DB
     */
    public static function get_inactive_widgets(){
      $widget_arr = get_option('_pure_shopbuild_elements')? get_option('_pure_shopbuild_elements') : self::merge_inactives_widgets();
      $all_widgets = self::get_widgets();

      foreach( $all_widgets as $key => $val ){
         if( in_array($key, $widget_arr) ){
            if( $val['is_active'] ){
               $find_key = array_search($key, $widget_arr);
               unset($widget_arr[$find_key]);
            }
         }else{
            if( !$val['is_active'] ){
               $widget_arr[] = $key;
            }
         }
      }
      
      return $widget_arr;
    }

    /**
     * Update widget option in DB through ajax
     */
    public static function update_widgets(){
      if ( ! current_user_can( 'manage_options' ) ) {
         return;
      }

      if ( ! check_ajax_referer( self::$widget_nonce, 'nonce' ) ) {
            wp_send_json_error();
      }


      $marked_widgets = isset($_POST['widgets'])? sanitize_text_field(wp_unslash($_POST['widgets'])) : 0;

      self::save_inactive_widgets( $marked_widgets );

      wp_send_json_success( $marked_widgets );
    }


    /**
     * Save inactive widgets in DB
     */
    public static function save_inactive_widgets( $widgets = array() ){
      $inactive_widgets = self::get_inactive_widgets();

      if( !empty($widgets) ){
         foreach( $widgets as $widget ){
            if( !in_array($widget, $inactive_widgets) ){
               $inactive_widgets = array_merge( $inactive_widgets, $widgets );
            }
         }
      }

      update_option( '_pure_shopbuild_elements', $inactive_widgets );
    }

    /**
     * Merge inactives widgets
     */

   public static function merge_inactives_widgets( $widgets = array() ){
      
      $default_inactive_widgets = self::get_widgets();
      array_walk( $default_inactive_widgets, function($widget, $name)  use ( &$widgets ) {
         if( $widget['is_active'] == false ){
            $widgets[] =  $name; 
         }
      });

      return $widgets;
   }

   /**
    * Register Elementor Categories
    */

   public function widget_categories( $elements_manager ) {

      $elements_manager->add_category(
         'storebuild',
         [
            'title' => esc_html__( 'StoreBuild', 'shopbuild' ),
            'icon' => 'fa fa-plug',
         ]
      );

   }

   /**
    * Register all widgets
    */
   public function register_widgets( $widgets_manager ){
      $all_widgets  = self::get_widgets();
      $db_wigets    = get_option('_pure_shopbuild_elements')? get_option('_pure_shopbuild_elements') : array();

      $all_widgets = wp_parse_args($db_wigets, $all_widgets);

      if( !empty($all_widgets) ){
         require_once( PURE_WC_SHOPBUILD_PATH . 'includes/class-pure-wc-shopbuild-base-widget.php' );

         foreach( $all_widgets as $key => $val ){
            if( $val['is_active'] ){
               $_key = trim(strtolower(str_replace('_', '-', $key)));
               if( file_exists(PURE_WC_SHOPBUILD_PATH . "public/widgets/elementor/{$_key}.php") ){
                  require_once( PURE_WC_SHOPBUILD_PATH . "public/widgets/elementor/{$_key}.php" );
               } 
               else if( file_exists(PURE_WC_SHOPBUILD_PATH . "public/widgets/elementor/{$_key}") && is_dir(PURE_WC_SHOPBUILD_PATH . "public/widgets/elementor/{$_key}")){
                  require_once( PURE_WC_SHOPBUILD_PATH . "public/widgets/elementor/{$_key}/{$_key}.php" );
               } 
            }
         }
      }
   }


}


new Pure_Widget_Manager();