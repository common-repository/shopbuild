<?php
namespace PureWCShopbuild;

/**
 * Templates manager class
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Plugin;
use Elementor\Utils;

class Pure_Wc_Template_Manager{

    private static $instance = null;
    const CPT_TYPE = 'pure_wc_template';
    const API_URL  = 'https://themepure.net/plugins/storebuild/templates/';

    /**
	 * StoreBuild post-type slug.
	 */
	const CPT = 'pure_wc_template';

	/**
	 * Elementor template-library taxonomy slug.
	 */
	const TAXONOMY_TYPE_SLUG = 'storebuild_template_type';

    public function __construct(){
        // Product Archive Page
        add_filter( 'template_include', array( $this, 'set_product_archive_template' ), 999 );
        add_action( 'pure_wc_shopbuild_archive_product_content', array( $this, 'set_archive_product_builder_content' ) );

        // Product details page
        add_filter( 'wc_get_template_part', array( $this, 'set_product_content_template' ), 99, 3 );
        add_filter( 'template_include', array( $this, 'set_product_template' ), 99 );
        add_action( 'pure_wc_shopbuild_single_product_content', array( $this, 'set_product_builder_content' ), 5 );

        // Checkout page
        add_filter( 'template_include', array( $this, 'set_checkout_template' ), 95 );
        add_action( 'pure_wc_shopbuild_checkout_content', array( $this, 'set_checkout_builder_content' ), 5 );

        // thankyou page
        add_filter( 'template_include', array( $this, 'set_order_received_template' ), 96 );
        add_action( 'pure_wc_shopbuild_order_received_content', array( $this, 'set_order_received_builder_content' ), 5 );

        // Cart page
        add_filter( 'template_include', array( $this, 'set_cart_template' ), 999 );
        add_action( 'pure_wc_shopbuild_cart_content', array( $this, 'set_cart_builder_content' ), 5 );

        // My Account page
        add_filter( 'template_include', array( $this, 'set_my_account_template' ), 999 );
        add_action( 'pure_wc_shopbuild_my_account_content', array( $this, 'set_my_account_builder_content' ), 5 );

        add_filter( 'wc_get_template_part', array( $this, 'woo_modified_template_part' ), 10, 3 );
        add_filter( 'woocommerce_locate_template', array( $this, 'woo_modified_template'), 10, 3 );

        // Action For Template Creation
        add_action( 'wp_ajax_pure_wc_shopbuild_template', array( $this, 'save_template' ) );

        // Print template library tabs.
		add_filter( 'views_edit-' . self::CPT, array( $this, 'storebuild_admin_print_tabs' ) );
        add_action( 'parse_query', array( $this, 'admin_query_filter_types' ) );
    }

    private function is_current_screen() {
		global $pagenow, $typenow;

		return 'edit.php' === $pagenow && self::CPT === $typenow;
	}

    public static function get_templates_by_type( $type = 'shop' ){
        $templates = array();
        $get_posts = get_posts( array(
            'post_type' => self::CPT,
            'posts_per_page' => -1,
            'meta_query' => array(
                array(
                    'key' => '_pure_wc_shopbuild_tmpl_type',
                    'value' => $type,
                    'compare' => '='
                )
            )
        ) );
        if(!empty($get_posts)){
            foreach($get_posts as $post){
                $templates[$post->ID] = $post->post_title;
            }
        }
        
        return $templates;
    }

	public function get_current_tab_group( $default = '' ) {
		//phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Nonce verification is not required here.
		$current_tabs_group = Utils::get_super_global_value( $_REQUEST, 'tabs_group' ) ?? '';
		//phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Nonce verification is not required here.
		$type_slug = Utils::get_super_global_value( $_REQUEST, self::TAXONOMY_TYPE_SLUG );

		if ( $type_slug ) {
			$doc_type = Plugin::$instance->documents->get_document_type( $type_slug, '' );
			if ( $doc_type ) {
				$current_tabs_group = $doc_type::get_property( 'admin_tab_group' );
			}
		}
		return $current_tabs_group;
	}

    /**
	 * Filter template types in admin query.
	 *
	 * Update the template types in the main admin query.
	 *
	 * Fired by `parse_query` action.
	 *
	 * @since 2.4.0
	 * @access public
	 *
	 * @param \WP_Query $query The `WP_Query` instance.
	 */
	public function admin_query_filter_types( \WP_Query $query ) {
		if ( ! $this->is_current_screen() || ! empty( $query->query_vars['meta_key'] ) ) {
			return;
		}

        //verify nonce
        if( isset($_GET['_wpnonce-elementor_library']) && ! wp_verify_nonce( sanitize_text_field( wp_unslash($_GET['_wpnonce-elementor_library'])), 'sb_elementor_library' ) ){
            return;
        }

		$current_tabs_group = isset( $_GET['storebuild_template_type'] ) ? sanitize_text_field( wp_unslash( $_GET['storebuild_template_type'] ) ) : '';

		if ( empty( $current_tabs_group ) ) {
			return;
		}

		$query->query_vars['meta_key'] = "_pure_wc_shopbuild_tmpl_type";
		$query->query_vars['meta_value'] = $current_tabs_group;
	}

    private function get_library_title() {
		$title = '';

		if ( $this->is_current_screen() ) {
			$current_tab_group = $this->get_current_tab_group();

			if ( $current_tab_group ) {
				$titles = [
					'library' => esc_html__( 'Saved Templates', 'shopbuild' ),
					'theme' => esc_html__( 'Theme Builder', 'shopbuild' ),
					'popup' => esc_html__( 'Popups', 'shopbuild' ),
				];

				if ( ! empty( $titles[ $current_tab_group ] ) ) {
					$title = $titles[ $current_tab_group ];
				}
			}
		}

		return $title;
	}

	/**
	 * Print admin tabs.
	 *
	 * Used to output the template library tabs with their labels.
	 *
	 * Fired by `views_edit-elementor_library` filter.
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @param array $views An array of available list table views.
	 *
	 * @return array An updated array of available list table views.
	 */
	public function storebuild_admin_print_tabs( $views ) {
        if ( did_action( 'views_edit-' . self::CPT ) ) {
            return $views;
        }

        static $has_run = false;

        if ( $has_run ) {
            return $views;
        }

        if ( ! $this->is_current_screen() ) {
            return $views;
        }

        $has_run = true;
		//phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Nonce is not required to retrieve the value.
		$current_type = Utils::get_super_global_value( $_REQUEST, self::TAXONOMY_TYPE_SLUG ) ?? '';
		$active_class = $current_type ? '' : ' nav-tab-active';
		$current_tabs_group = $this->get_current_tab_group();

		$url_args = [
			'post_type' => self::CPT,
			'tabs_group' => $current_tabs_group,
		];

		$baseurl = add_query_arg( $url_args, admin_url( 'edit.php' ) );

        $doc_types = array(
            'shop' => 'Shop',
            'single' => 'Single',
            'cart' => 'Cart',
            'checkout' => 'Checkout',
            'thankyou' => 'Thank You',
            'myaccount' => 'My Account',
            'myaccountlogin' => 'Login',
            'quickview' => 'Quickview',
        );

        wp_nonce_field( 'sb_elementor_library', '_wpnonce-elementor_library' );
		?>
		<div id="elementor-template-library-tabs-wrapper" class="nav-tab-wrapper">
			<a class="nav-tab<?php echo esc_attr( $active_class ); ?>" href="<?php echo esc_url( $baseurl ); ?>">
				<?php
				$all_title = $this->get_library_title();
				if ( ! $all_title ) {
					$all_title = esc_html__( 'All', 'shopbuild' );
				}
				Utils::print_unescaped_internal_string( $all_title ); ?>
			</a>
			<?php
			foreach ( $doc_types as $type => $type_label ) :
				$active_class = '';

				if ( $current_type === $type ) {
					$active_class = ' nav-tab-active';
				}

				$type_url = esc_url( add_query_arg( self::TAXONOMY_TYPE_SLUG, $type, $baseurl ) );
				Utils::print_unescaped_internal_string( "<a class='nav-tab{$active_class}' href='{$type_url}'>{$type_label}</a>" );
			endforeach;
			?>
		</div>
		<?php
		return $views;
	}


    public function woo_modified_template( $template, $template_name, $template_path ) {
        $archive_template_id = $this->get_archive_template_id();
        if($archive_template_id == 0 || !self::is_templates_exists()){
            return $template;
        }
        
		global $woocommerce;

		$_template = $template;
	
		if ( ! $template_path ){
			$template_path = $woocommerce->template_url;
		}

		$plugin_path  = untrailingslashit( plugin_dir_path( __DIR__ ) )  . '/public/woocommerce/';
	
		// Look within passed path within the theme - this is priority
		$template = locate_template(
			array(
                $template_path . $template_name,
                $template_name
			)
		);
		
		if ( ! $template ){
			$template = $_template;
		}

		if( file_exists( $plugin_path . $template_name ) ){
			$template = $plugin_path . $template_name;
		}

		return $template;
	}

    /**
	 * Template Part's
	 *
	 * @param  string $template Default template file path.
	 * @param  string $slug     Template file slug.
	 * @param  string $name     Template file name.
	 * @return string           Return the template part from plugin.
	 */
	public function woo_modified_template_part( $template, $slug, $name ) {
        $archive_template_id = $this->get_archive_template_id();
        if($archive_template_id == 0 || !self::is_templates_exists()){
            return $template;
        }

		$template_directory = untrailingslashit( plugin_dir_path( __DIR__ ) ) . '/public/woocommerce/';

		if ( $name ) {
			$path = $template_directory . "{$slug}-{$name}.php";
		} else {
			$path = $template_directory . "{$slug}.php";
		}

		return file_exists( $path ) ? $path : $template;
	}


    /**
     * Templates
     */
    public static function get_templates(){
        $templates = self::API_URL . 'templates.json';
        require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php';
        require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-direct.php';

        $wp_filesystem = new \WP_Filesystem_Direct(null);
        $template_data = $wp_filesystem->get_contents($templates);

        if(!empty($template_data)){
            return apply_filters('pure_wc_shopbuild_templates', json_decode($template_data, true)['templates']);
        }else{
            return array();
        }
    }


    public function set_product_archive_template( $template ){
        $archive_template_id = $this->get_archive_template_id();
        if($archive_template_id == 0 || !self::is_templates_exists()){
            return $template;
        }
        $is_shop = function_exists('is_shop')? is_shop() : false;
        $is_product_cat = function_exists('is_product_category')? is_product_category() : false;
        $is_product_tag = function_exists('is_product_tag')? is_product_tag() : false;
        $templatefile   = array();
        $templatefile[] = 'public/templates/archive-product.php';
        if( $is_shop || $is_product_cat || $is_product_tag ){
            $template = locate_template( $templatefile );
            if ( ! $template || ( ! empty( $status_options['template_debug_mode'] ) && current_user_can( 'manage_options' ) ) ){
                $template = PURE_WC_SHOPBUILD_PATH . 'public/templates/archive-product.php';
            }

            $page_template_slug = get_page_template_slug( $archive_template_id );
           
            if ( ( 'elementor_header_footer' === $page_template_slug )  ) {
                $template = PURE_WC_SHOPBUILD_PATH . 'public/templates/archive-product-fullwidth.php';
            } elseif ( ( 'elementor_canvas' === $page_template_slug ) ) {
                $template = PURE_WC_SHOPBUILD_PATH . 'public/templates/archive-product-canvas.php';
            }
        }
        return $template;
    }

    // Set Builder Content
    public function set_archive_product_builder_content(){
        $archive_template_id = $this->get_archive_template_id();
        if( $archive_template_id != 0 && $this->is_template_active( $archive_template_id ) ){
            print wp_kses(self::render_build_content( $archive_template_id ), pure_wc_get_kses_extended_ruleset()); 
        }
    }

    /**
     * [render_build_content]
     * @param  [int]  $id
     * @return string
     */
    public static function render_build_content( $id ){

        $output = '';
        $document = class_exists('\Elementor\Plugin') ? \Elementor\Plugin::instance()->documents->get( $id ) : false;

        if( $document && $document->is_built_with_elementor() ){
            $output = \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $id );
        }else{
            $content = get_the_content( null, false, $id );

            if ( has_blocks( $content ) ) {
                $blocks = parse_blocks( $content );
                foreach ( $blocks as $block ) {
                    $output .= do_shortcode( render_block( $block ) );
                }
            }else{
                $content = apply_filters( 'the_content', $content );
                $content = str_replace(']]>', ']]&gt;', $content );
                return $content;
            }

        }

        return $output;

    }

    /*
    * Manage Product Page
    */
    public function set_product_content_template( $template, $slug, $name ) {

        if ( ('content' === $slug) && ('single-product' === $name)  && is_singular( 'product' ) && $this->is_template_active( self::get_product_template_id() ) ) {
            $template = PURE_WC_SHOPBUILD_PATH . 'public/templates/single-product.php';
        }
        return $template;
    }

    // Set Product page template
    public function set_product_template( $template ) {
        $templateid = $this->get_product_template_id();

        if( !$this->is_template_active( $templateid ) ){
            return $template;
        }
        if ( is_embed() ) {
            return $template;
        }
        if ( is_singular( 'product' ) ) {
            $pure_wc_template_slug = get_page_template_slug( $templateid );
            if ( ( 'elementor_header_footer' === $pure_wc_template_slug ) ) {
                $template = PURE_WC_SHOPBUILD_PATH . 'public/templates/single-product-fullwidth.php';
            } elseif ( ( 'elementor_canvas' === $pure_wc_template_slug ) ) {
                $template = PURE_WC_SHOPBUILD_PATH . 'public/templates/single-product-canvas.php';
            }
        }
        return $template;
    }

    // Set Builder content product page
    public function set_product_builder_content() {
        $templateid = $this->get_product_template_id();
        if( $templateid > 0 && $this->is_template_active( $templateid ) ){
            print wp_kses(self::render_build_content( $templateid ), pure_wc_get_kses_extended_ruleset());
        }
    }

    // Set Cart page template
    public function set_cart_template( $template ) {
        $cart_template_id = $this->get_cart_template_id();
        if( $cart_template_id == 0 || !$this->is_template_active( $cart_template_id ) ){
            return $template;
        }else{
            $templatefile   = array();
            $templatefile[] = 'public/templates/cart.php';
            if( $cart_template_id != 0 && is_cart() ){
                $template = locate_template( $templatefile );
                if ( ! $template || ( ! empty( $status_options['template_debug_mode'] ) && current_user_can( 'manage_options' ) ) ){
                    $template = PURE_WC_SHOPBUILD_PATH . 'public/templates/cart.php';
                }

                $page_template_slug = get_page_template_slug( $cart_template_id );
            
                if ( ( 'elementor_header_footer' === $page_template_slug )  ) {
                    $template = PURE_WC_SHOPBUILD_PATH . 'public/templates/cart-fullwidth.php';
                } elseif ( ( 'elementor_canvas' === $page_template_slug ) ) {
                    $template = PURE_WC_SHOPBUILD_PATH . 'public/templates/cart-canvas.php';
                }
            }
            return $template;
        }
    }

    // Set Builder content cart page
    public function set_cart_builder_content() {
        $templateid = $this->get_cart_template_id();
        print wp_kses(self::render_build_content( $templateid ), pure_wc_get_kses_extended_ruleset()); 
    }

    // Set Checkout page template
    public function set_checkout_template( $template ) {
        $checkout_template_id = $this->get_checkout_template_id();

        if($checkout_template_id == 0 || !$this->is_template_active( $checkout_template_id )){
            return $template;
        }else{
            $templatefile   = array();
            $templatefile[] = 'public/templates/checkout.php';
            if( $checkout_template_id != 0 && is_checkout() && !is_order_received_page() ){
                $template = locate_template( $templatefile );
                if ( ! $template || ( ! empty( $status_options['template_debug_mode'] ) && current_user_can( 'manage_options' ) ) ){
                    $template = PURE_WC_SHOPBUILD_PATH . 'public/templates/checkout.php';
                }

                $page_template_slug = get_page_template_slug( $checkout_template_id );
            
                if ( ( 'elementor_header_footer' === $page_template_slug )  ) {
                    $template = PURE_WC_SHOPBUILD_PATH . 'public/templates/checkout-fullwidth.php';
                } elseif ( ( 'elementor_canvas' === $page_template_slug ) ) {
                    $template = PURE_WC_SHOPBUILD_PATH . 'public/templates/checkout-canvas.php';
                }
            }
            return $template;
        }
    }

    // checkout build content
    public function set_checkout_builder_content(){
        $templateid = $this->get_checkout_template_id();
        print wp_kses(self::render_build_content( $templateid ), pure_wc_get_kses_extended_ruleset()); 
    }

    // Set order received page template
    public function set_order_received_template( $template ) {
        $order_received_template_id = $this->get_order_received_template_id();
        if( $order_received_template_id == 0 ){
            return $template;
        }else{
            $templatefile   = array();
            $templatefile[] = 'public/templates/thankyou.php';
            if( $order_received_template_id != 0 && is_order_received_page() && is_checkout() ){
                $page_template_slug = get_page_template_slug( $order_received_template_id );

                $template = locate_template( $templatefile );
                if ( ! $template || ( ! empty( $status_options['template_debug_mode'] ) && current_user_can( 'manage_options' ) ) ){
                    $template = PURE_WC_SHOPBUILD_PATH . 'public/templates/thankyou.php';
                }
               
                if ( ( 'elementor_header_footer' === $page_template_slug )  ) {
                    $template = PURE_WC_SHOPBUILD_PATH . 'public/templates/thankyou-fullwidth.php';
                } elseif ( ( 'elementor_canvas' === $page_template_slug ) ) {
                    $template = PURE_WC_SHOPBUILD_PATH . 'public/templates/thankyou-canvas.php';
                }
            }
            return $template;
        }
    }

    // order received build content
    public function set_order_received_builder_content(){
        $templateid = $this->get_order_received_template_id();
        print wp_kses(self::render_build_content( $templateid ), pure_wc_get_kses_extended_ruleset()); 
    }

    // Set My Account page template
    public function set_my_account_template( $template ) {
        $my_account_template_id = $this->get_my_account_template_id();
        if( $my_account_template_id == 0 || !pure_wc_is_pro_active() ){
            return $template;
        }else{
            $templatefile   = array();
            $templatefile[] = 'public/templates/my-account.php';
            if( $my_account_template_id != 0 && is_account_page() ){
                $template = locate_template( $templatefile );
                if ( ! $template || ( ! empty( $status_options['template_debug_mode'] ) && current_user_can( 'manage_options' ) ) ){
                    $template = PURE_WC_SHOPBUILD_PATH . 'public/templates/my-account.php';
                }
                $page_template_slug = get_page_template_slug( $my_account_template_id );
            
                if ( ( 'elementor_header_footer' === $page_template_slug )  ) {
                    $template = PURE_WC_SHOPBUILD_PATH . 'public/templates/my-account-fullwidth.php';
                } elseif ( ( 'elementor_canvas' === $page_template_slug ) ) {
                    $template = PURE_WC_SHOPBUILD_PATH . 'public/templates/my-account-canvas.php';
                }
            }
            return $template;
        }
    }

    // Set Builder content cart page
    public function set_my_account_builder_content() {
        $templateid = $this->get_my_account_template_id();
        if( !is_user_logged_in() ){
            $templateid = $this->get_my_account_login_template_id();
        }
        print wp_kses(self::render_build_content( $templateid ), pure_wc_get_kses_extended_ruleset()); 
    }

    /*
    * Manage product archive page
    */
    public static function get_archive_template_id(){
        $woocoomerce_settings  = Admin\Pure_Wc_Shopuild_Admin::get_option('_pure_shopbuild_woocommerce');
        $settings = $woocoomerce_settings? $woocoomerce_settings['pure_wc_shop_page_id'] : 0;
        return (int) $settings;
    }

    /*
    * Manage product single page
    */
    public static function get_product_template_id(){
        $woocoomerce_settings  = Admin\Pure_Wc_Shopuild_Admin::get_option('_pure_shopbuild_woocommerce');
        $settings = $woocoomerce_settings? $woocoomerce_settings['pure_wc_single_page_id'] : 0;
        return (int) $settings;
    }

    /*
    * Manage cart page
    */
    public function get_cart_template_id(){
        $woocoomerce_settings  = Admin\Pure_Wc_Shopuild_Admin::get_option('_pure_shopbuild_woocommerce');
        $settings = $woocoomerce_settings? $woocoomerce_settings['pure_wc_cart_page_id'] : 0;
        return (int) $settings;
    }

    /*
    * Manage checkout page
    */
    public function get_checkout_template_id(){
        $woocoomerce_settings  = Admin\Pure_Wc_Shopuild_Admin::get_option('_pure_shopbuild_woocommerce');
        $settings = $woocoomerce_settings? $woocoomerce_settings['pure_wc_checkout_page_id'] : 0;
        return (int) $settings;
    }

    /*
    * Manage order received page
    */
    public function get_order_received_template_id(){
        $woocoomerce_settings  = Admin\Pure_Wc_Shopuild_Admin::get_option('_pure_shopbuild_woocommerce');
        $settings = $woocoomerce_settings? $woocoomerce_settings['pure_wc_thankyou_page_id'] : 0;
        return (int) $settings;
    }

    /*
    * Manage may account page
    */
    public static function get_my_account_template_id(){
        $woocoomerce_settings  = Admin\Pure_Wc_Shopuild_Admin::get_option('_pure_shopbuild_woocommerce');
        $settings = $woocoomerce_settings? $woocoomerce_settings['pure_wc_my_account_page_id'] : 0;
        return (int) $settings;
    }

    /*
    * Manage may account page
    */
    public function get_my_account_login_template_id(){
        $woocoomerce_settings  = Admin\Pure_Wc_Shopuild_Admin::get_option('_pure_shopbuild_woocommerce');
        $settings = $woocoomerce_settings? $woocoomerce_settings['pure_wc_my_account_login_page_id'] : 0;
        return (int) $settings;
    }


    /**
     * Singleton intance
     */
    public static function get_instance(){
        if( is_null(self::$instance) ){
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Check if the template is active
     */
    public static function is_template_active( $template_id ){
        $tmpl_set_as = get_post_meta( $template_id, '_pure_wc_shopbuild_tmpl_set_as', true);
        return ( "inactive" != $tmpl_set_as ) && !empty( $tmpl_set_as );
    }

    /**
     * check if any templates exists
     */
    public static function is_templates_exists(){
        $args = array(
            'post_type' => 'pure_wc_template',
            'post_status'   => 'publish'
        );
        $posts = get_posts($args);

        return empty($posts)? false : true;
    }
}

Pure_Wc_Template_Manager::get_instance();
