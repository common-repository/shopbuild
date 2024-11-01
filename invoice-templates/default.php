<?php use PureWCShopbuild\Admin\Pure_Wc_Shopuild_Admin; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice | Order ID <?php echo isset($order)? esc_html($order->get_order_number()) : '1'; ?></title>
    <style>
        @font-face {
            font-family: 'Currencies';
            src: url( <?php echo esc_url(PURE_WC_SHOPBUILD_URL . 'admin/fonts/currencies.ttf'); ?>) format('truetype');
        }
        .invoice-wrapper{
            width: 100%;
            border: 1px solid #ddd;
            /* font: normal 14px/1.5 'Montserrat-Regular'; */
        }
        .invoice-head{
            padding: 20px;
            margin-bottom: 20px;
            display: flex;
            justify-content: start;
        }
        .invoice-title{
            padding: 20px;
            margin-left: auto;
            text-align: right;
        }

        .invoice-head .logo{
            max-width: 200px;
        }
        .invoice-head .logo img{
            width: 100%;
            height: auto;
        }
        .invoice-table, .invoice-terms-conditions, .invoice-footer{
            padding: 20px;
        }
        table{
            width: 100%;
            border-collapse: collapse;
        }
        .invoice-table table th, .invoice-table table td{
            /* border: 1px solid #ddd; */
            padding: 3px;
            text-align: left;
        }
        .invoice-table table th{
            background-color: #f9f9f9;
        }
        .invoice-table table tbody{
            border-bottom: 1px solid #ddd;
        }
        .invoice-footer{
            background-color: #f9f9f9;
            text-align: center;
        }
        .invoice-footer p{
            margin: 0;
        }
        .contact-info table .email{
            margin-left: auto;
            text-align: right;
        }

        .invoice-title p, .user-info p{
            margin: 0;
        }
        .woocommerce-Price-currencySymbol{ font: normal 14px/1.5 'Currencies'; }
        tbody tr{
            margin: 0;
            padding: 0;
        }
    </style>
    
</head>
<body>  
    <?php

        //order data
        $fullname = isset($order)? $order->get_billing_first_name().' '.$order->get_billing_last_name() : '';
        $address = isset($order)? $order->get_billing_address_1() : '';
        $city = isset($order)? $order->get_billing_city() : '';
        $phone = isset($order)? $order->get_billing_phone() : '';
        $email = isset($order)? $order->get_billing_email() : '';
        $order_note = isset($order)? $order->get_customer_note() : '';
        $order_number = isset($order)? $order->get_order_number() : '';
        $order_date = isset($order)? $order->get_date_created()->format('Y-m-d') : '';
        $order_status = isset($order)? $order->get_status() : '';

        //invoice settings
        $invoice_settings = Pure_Wc_Shopuild_Admin::get_option('_pure_invoice_settings');
        $invoice_logo = isset($invoice_settings['invoice_logo']) ? $invoice_settings['invoice_logo'] : array();
        $invoice_phone = isset($invoice_settings['invoice_phone']) ? $invoice_settings['invoice_phone'] : '';
        $invoice_email = isset($invoice_settings['invoice_email']) ? $invoice_settings['invoice_email'] : '';
        $invoice_terms = isset($invoice_settings['invoice_terms']) ? $invoice_settings['invoice_terms'] : '';
        $invoice_footer_note = isset($invoice_settings['invoice_footer_note']) ? $invoice_settings['invoice_footer_note'] : '';
    ?>
    <div class="invoice-wrapper">
        <table>
            <tr>
                <td class="invoice-head">
                    <div class="logo">
                        <img src="<?php echo isset($invoice_logo['url'])? esc_url($invoice_logo['url']) : ''; ?>" alt="">
                    </div>
                    <div class="user-info">
                        <h2><?php esc_html_e('Billing Info', 'shopbuild'); ?></h2>
                        <p><?php //esc_html_e('Name:', 'shopbuild'); ?><?php echo esc_html($fullname); ?></p>
                        <p><?php //esc_html_e('Address:', 'shopbuild'); ?><?php echo esc_html($address); ?></p>
                        <p><?php //esc_html_e('City:', 'shopbuild'); ?><?php echo esc_html($city); ?></p>
                        <p><?php //esc_html_e('Phone:', 'shopbuild'); ?> <?php echo esc_html($phone); ?></p>
                        <p><?php //esc_html_e('Email:', 'shopbuild'); ?><?php echo esc_html($email); ?></p>
                    </div>
                </td>
                <td>
                    <div class="invoice-title">
                        <h2><?php esc_html_e('INVOICE', 'shopbuild'); ?></h2>
                        <p><?php esc_html_e('Order Status:', 'shopbuild'); ?> <strong><?php echo esc_html($order_status); ?></strong></p>
                        <p><?php esc_html_e('Order number:', 'shopbuild'); ?> #<?php echo esc_html($order_number); ?></p>
                        <p><?php esc_html_e('Order date:', 'shopbuild'); ?> <?php echo esc_html($order_date); ?></p>
                        <p><?php esc_html_e('Phone:', 'shopbuild'); ?> <?php echo esc_html($invoice_phone); ?></p>
                        <p><?php esc_html_e('Email:', 'shopbuild'); ?><?php echo esc_html($invoice_email); ?></p>
                    </div>
                </td>
            </tr>
        </table>
        <div class="invoice-table">
            <table>
                <thead>
                    <tr>
                        <th><?php esc_html_e('Product', 'shopbuild'); ?></th>
                        <th><?php esc_html_e('Quantity', 'shopbuild'); ?></th>
                        <th><?php esc_html_e('Price', 'shopbuild'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($order)): ?>
                    <?php
                        $items = $order->get_items();
                        foreach($items as $item):
                    ?>
                    <tr>
                        <td><?php echo esc_html($item->get_name()); ?></td>
                        <td><?php echo esc_html($item->get_quantity()); ?></td>
                        <td><?php echo wp_kses(wc_price($item->get_total()), pure_wc_get_kses_extended_ruleset()); ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td>T-shirt</td>
                        <td>1</td>
                        <td>$16.00</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <td><strong><?php esc_html_e('Total', 'shopbuild'); ?></strong></td>
                        <td><strong><?php echo isset($order)? wp_kses(wc_price($order->get_total()), pure_wc_get_kses_extended_ruleset()) : '$16.00'; ?></strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="invoice-terms-conditions">
            <h3><?php esc_html_e('Terms & Conditions', 'shopbuild'); ?></h3>
            <p><?php echo esc_html($invoice_terms); ?></p>
        </div>
        <div class="invoice-footer">
            <p><?php echo esc_html($invoice_footer_note); ?></p>
        </div>
    </div>
</body>
</html>