<?php
/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$allowed_html = array(
	'a' => array(
		'href' => array(),
	),
);

$author_bio_avatar_size = 180;

$user_email = get_the_author_meta( 'user_email' );
$display_name = get_the_author_meta( 'display_name' );
$author_bio_avatar_size = apply_filters( 'shopbuild_author_bio_avatar_size', 90 );
$avatar = get_avatar($user_email, $author_bio_avatar_size, '', '', [ 'class' => 'media-object img-circle' ]);
$pure_myaccount_dashboard_style = $pure_myaccount_dashboard_style?? '';
$show_avatar = $show_avatar?? 'no';
?>


<?php if($pure_myaccount_dashboard_style == 'style_2') :?>
<div class="sb-profile-main-wrapper">
	<div class="sb-row sb-align-items-center">
		<div class="sb-col-md-10">
			<div class="sb-profile-main-inner sb-d-flex sb-align-items-center">
				<?php if($show_avatar == 'yes') : ?>
				<?php if(!empty($avatar)) : ?>
				<div class="sb-profile-main-thumb">
                    <a href="<?php print esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) );?>">
                        <?php print wp_kses($avatar, pure_wc_get_kses_extended_ruleset());?>
                    </a>
				</div>
				<?php endif; ?>              
				<?php endif; ?>              

				<div class="sb-profile-main-content">
					<?php if(!empty($pure_myaccount_dashboard_wlcm_text)) : ?>
					<h4 class="sb-profile-main-title sb-el-profile-main-title">
						<?php echo wp_kses($pure_myaccount_dashboard_wlcm_text, pure_wc_get_kses_extended_ruleset()); ?>
						<a class="sb-el-profile-secondary-title" href="<?php echo esc_url(home_url()); ?>"><?php echo bloginfo('name'); ?></a>
					</h4>
					<?php endif; ?>
					<div class="mb-15"></div>
					<p class="mb-10 sb-el-profile-main-content"><?php echo esc_html__('Hello','shopbuild'); ?> <?php echo esc_html($display_name); ?></p>
					<div class="mb-10"></div>
					<?php if(!empty($pure_myaccount_dashboard_wlcm_desc)) : ?>
					<p class="sb-el-profile-main-desc"><?php echo wp_kses($pure_myaccount_dashboard_wlcm_desc, pure_wc_get_kses_extended_ruleset()); ?></p>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<?php if(!empty($pure_myaccount_dashboard_logout_text)) : ?>
		<div class="sb-col-md-2">
			<div class="sb-profile-main-logout text-lg-end">
				<a href="<?php echo esc_url( wc_logout_url()); ?>" class="sb-profile-main-logout-btn"><?php echo wp_kses($pure_myaccount_dashboard_logout_text, pure_wc_get_kses_extended_ruleset()); ?></a>
			</div>
		</div>
		<?php endif; ?>
	</div>
	<div class="sb-row sb-gx-3 <?php echo esc_attr($myacccount_col); ?>">
		<?php foreach ($pure_myaccount_dashboard_option_list as $key => $item) : 
			$endpoint = $item['pure_myaccount_dashboard_option_menu'];	
		?>

		<div class="sb-col">
			<a class="d-block" href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>">
				<div class="sb-profile-main-info-item sb-el-box-number">
					<?php if(in_array($endpoint, ['downloads', 'orders'])) : 
							if($endpoint == 'downloads') :
								$count_number = !is_null(WC()->customer) ? count(WC()->customer->get_downloadable_products()) : 0;
							elseif($endpoint == 'orders') :
								$orders = wc_get_orders( apply_filters( 'woocommerce_my_account_my_orders_query', array(
									'posts_per_page' => -1,
								)));
								$count_number = count($orders);
							else: 
								$count_number = 0;
							endif;	
						?>
						<span class="profile-icon-count <?php echo esc_attr($endpoint); ?>"><?php echo esc_html($count_number); ?></span>
					<?php endif; ?>
					<div class="sb-profile-main-info-icon">
						<span>
						<?php if($item['select_icon'] == 'icon') {
							\Elementor\Icons_Manager::render_icon( $item['pure_myaccount_dashboard_option_icon'], [ 'aria-hidden' => 'true' ] );
						}
						else{
							echo wp_kses($item['nav_svg'], pure_wc_get_kses_extended_ruleset());
						}
						?>
						</span>
					</div>
					<?php if(!empty($item['pure_myaccount_dashboard_option_title'])) : ?>
					<h4 class="sb-profile-main-info-title">
						<?php echo esc_html($item['pure_myaccount_dashboard_option_title']); ?>
					</h4>
					<?php endif; ?>
				</div>
			</a>
		</div>

		<?php endforeach; ?>
	</div>
</div>
<?php else :?>
<div class="sb-profile-main-wrapper">
	<div class="sb-row sb-align-items-center">
		<div class="sb-col-md-6">
			<div class="sb-profile-main-inner sb-d-flex sb-flex-wrap sb-align-items-center">
				<?php if($show_avatar == 'yes') : ?>
				<?php if(!empty($avatar)) : ?>
				<div class="sb-profile-main-thumb">
                    <a href="<?php print esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) );?>">
                        <?php print wp_kses($avatar, pure_wc_get_kses_extended_ruleset());?>
                    </a>
				</div>
				<?php endif; ?>              
				<?php endif; ?>            

				<div class="sb-profile-main-content">
					<?php if(!empty($pure_myaccount_dashboard_wlcm_text)) : ?>
					<h4 class="sb-profile-main-title sb-el-profile-main-title">
						<?php echo wp_kses($pure_myaccount_dashboard_wlcm_text, pure_wc_get_kses_extended_ruleset()); ?>
						<a class="sb-el-profile-secondary-title" href="<?php echo esc_url(home_url()); ?>"><?php echo bloginfo('name'); ?></a>
					</h4>
					<?php endif; ?> 	
					<div class="mb-15"></div>
					<p class="mb-10 sb-el-profile-main-content"><?php echo esc_html__('Hello','shopbuild'); ?> <?php echo esc_html($display_name); ?></p>
					<div class="mb-10"></div>
					<?php if(!empty($pure_myaccount_dashboard_wlcm_text)) : ?>
					<p class="sb-el-profile-main-desc"><?php echo wp_kses($pure_myaccount_dashboard_wlcm_desc, pure_wc_get_kses_extended_ruleset()); ?></p>
					<?php endif; ?> 
				</div>
			</div>
		</div>
		<div class="sb-col-md-6">
			<div class="sb-profile-main-logout text-lg-end">
				<a href="<?php echo esc_url( wc_logout_url()); ?>" class="sb-profile-main-logout-btn"><?php echo esc_html__( 'Logout', 'shopbuild' ); ?></a>
			</div>
		</div>
	</div>
	<div class="sb-row">
		<div class="sb-col-12">
			<div class="sb-profile-message sb-el-profile-message">
				<p>
					<?php
					/* translators: 1: Orders URL 2: Address URL 3: Account URL. */
					$dashboard_desc = __( 'From your account dashboard you can view your <a href="%1$s">recent orders</a>, manage your <a href="%2$s">billing address</a>, and <a href="%3$s">edit your password and account details</a>.', 'shopbuild' );
					if ( wc_shipping_enabled() ) {
						/* translators: 1: Orders URL 2: Addresses URL 3: Account URL. */
						$dashboard_desc = __( 'From your account dashboard you can view your <a href="%1$s">recent orders</a>, manage your <a href="%2$s">shipping and billing addresses</a>, and <a href="%3$s">edit your password and account details</a>.', 'shopbuild' );
					}
					printf(
						wp_kses( $dashboard_desc, $allowed_html ),
						esc_url( wc_get_endpoint_url( 'orders' ) ),
						esc_url( wc_get_endpoint_url( 'edit-address' ) ),
						esc_url( wc_get_endpoint_url( 'edit-account' ) )
					);
					?>
				</p>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>