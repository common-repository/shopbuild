<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * Handle WooCommerce related functionality
 */

class Pure_Wc_Shopbuild_Invoice{

    private static $instance = false;


    public function __construct(){
        require_once PURE_WC_SHOPBUILD_PATH .'lib/dompdf/dompdf/autoload.inc.php';

        add_action( 'add_meta_boxes', array( $this, 'add_invoice_meta_boxes' ),10, 2 );
        // Handle the "Download Invoice" button click
        add_action( 'init', array( $this, 'handle_invoice_download' ));
        add_filter( 'woocommerce_admin_order_actions_end', array( $this, 'add_invoice_column_action' ), 10, 1 );

    }

    /**
     * Invoice Meta Boxes
     */
    public function add_invoice_meta_boxes( $wc_screen_id, $post ) {
        if ( function_exists( 'wc_get_container' ) ) {
            $screen_id = wc_get_page_screen_id( 'shop-order' );
        } else {
            $screen_id = 'shop_order';
        }
        
        if ( $wc_screen_id != $screen_id ) {
            return;
        }
    
        add_meta_box(
            'shopbuild-invoice-pdf',
            __( 'Invoice Download', 'shopbuild' ),
            array( $this, 'pdf_actions_meta_box' ),
            $screen_id,
            'side',
            'default'
        );
    }

    // Invoice PDF actions

    public function pdf_actions_meta_box( $object ){
        $order = ( $object instanceof \WP_Post ) ? wc_get_order( $object->ID ) : $object;
        // Generate the nonce
        $nonce = wp_create_nonce( 'download_invoice_nonce' );
        // Use sprintf to construct the URL and HTML
        $download_link = sprintf(
            '<a href="%s" class="button" target="_blank">Download Invoice</a>',
            esc_url( add_query_arg( array(
                'download_invoice' => 'pdf',
                'nonce'            => $nonce
            ) ) )
        );

        // Output the download link
        echo wp_kses($download_link, pure_wc_get_kses_extended_ruleset());
    }

    // Invoice download
    public function handle_invoice_download() {
        if (isset( $_GET['nonce'] ) && wp_verify_nonce( sanitize_text_field(wp_unslash($_GET['nonce'])), 'download_invoice_nonce' ) && isset($_GET['download_invoice']) && $_GET['download_invoice'] == 'pdf') {
            $order_id = isset($_GET['id'])? absint($_GET['id']) : (isset($_GET['post'])? absint($_GET['post']) : 0);
            $order = wc_get_order($order_id);
    
            if ($order) {
                // Generate invoice content
                ob_start();
                pure_wc_get_invoice_templates('default', array(	'order' => $order ));
                $invoice_html = ob_get_clean();
                // Output as a downloadable file
                // header('Content-Type: application/pdf'); // Adjust content type if needed
                // header('Content-Disposition: attachment; filename="invoice-' . $order_id . '.pdf"');
                // Include the WP_Filesystem API
                if ( ! function_exists('WP_Filesystem') ) {
                    require_once ABSPATH . 'wp-admin/includes/file.php';
                }

                // Initialize the WP_Filesystem
                global $wp_filesystem;
                WP_Filesystem();

                // Get the upload directory
                $upload_dir = wp_upload_dir();
                $fonts_dir = trailingslashit($upload_dir['basedir']) . 'shopbuild_invoice/fonts/';

                // Check if the directory exists, and create it if it doesn't
                if ( ! $wp_filesystem->is_dir($fonts_dir) ) {
                    $wp_filesystem->mkdir($fonts_dir, FS_CHMOD_DIR);
                }

                
    
                $options = new \Dompdf\Options();
                $options->set('isRemoteEnabled', true);
                
                $dompdf = new \Dompdf\Dompdf($options);
                $dompdf->loadHtml($invoice_html);
    
                // (Optional) Set paper size and orientation
                $dompdf->setPaper('A4', 'portrait');
    
                // Render the HTML as PDF
                $dompdf->render();
    
                // Output the generated PDF in a new window
                $dompdf->stream('invoice.pdf', array('Attachment' => 0));
                exit;
            }
        }
    }

    // Add invoice data to orders list
    public function add_invoice_column_action( $order ) {
        ?>
        <?php
        // Generate the nonce
        $nonce = wp_create_nonce( 'download_invoice_nonce' );
        $download_link = sprintf(
            '<a href="%s" class="button invoice wc-action-button" target="_blank">Download Invoice</a>',
            esc_url( add_query_arg(
                'download_invoice', 
                'pdf',
                get_edit_post_link( $order->get_order_number() )
            ))
        );

        // Output the download link
        echo wp_kses($download_link, pure_wc_get_kses_extended_ruleset());
    }

    /**
     * Init Method
     */
    public static function init(){
        if(!self::$instance){
            self::$instance = new self();
        }
        return self::$instance;
    }
}

Pure_Wc_Shopbuild_Invoice::init();