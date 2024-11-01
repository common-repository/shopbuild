<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

	do_action( 'woocommerce_before_customer_login_form' ); 

	$woocommerce_enable_myaccount_registration = get_option( 'woocommerce_enable_myaccount_registration');
	$form_col = get_option( 'woocommerce_enable_myaccount_registration') === 'yes' ? 'sb-form-login' : 'sb-form-login';
	$form_row = get_option( 'woocommerce_enable_myaccount_registration') === 'yes' ? '' : 'justify-content-center'; 

?>

<div class="sb-row <?php echo esc_attr($form_row); ?>" id="customer_login">
	<div class="<?php echo esc_attr($form_col); ?>">
		<div class="sb-login-wrapper">
			<div class="sb-login-wrapper-inner sb-login-box">
				<div class="sb-login-content sb-el-login-content">
					<?php if(!empty($image['url'])) : ?>
					<img  src="<?php echo esc_url($image['url']); ?> " alt="">
					<?php endif; ?>
					<?php if(!empty($sb_title)) : ?>	
					<h2 class="sb-login-title"><?php echo esc_html($sb_title); ?></h2>
					<?php endif; ?>
					<?php if(!empty($sb_content)) : ?>	
					<p><?php echo esc_html($sb_content); ?></p>
					<?php endif; ?>	
				</div>
				<?php
					if(isset($_POST['login']) && isset($_POST['woocommerce-login-nonce']) && !wp_verify_nonce( sanitize_text_field( wp_unslash($_POST['woocommerce-login-nonce']) ), 'woocommerce-login' )){
						return;
					}
					$username = isset( $_POST['username'] )? sanitize_user( wp_unslash($_POST['username']) ) : '';
				?>
				<form class="woocommerce-form woocommerce-form-login login" method="post">
					<div class="sb-login-option">
						<?php do_action( 'woocommerce_login_form_start' ); ?>
						<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
						<div class="sb-login-input-wrapper">
							<div class="sb-login-input-box">
								<div class="sb-login-input-title">
									<label for="username"><?php esc_html_e( 'Username or email address', 'shopbuild' ); ?>&nbsp;<span class="required">*</span></label>
								</div>
								<div class="sb-login-input">
									<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="<?php echo esc_attr($username); ?>" />
								</div>
							</div>
							<div class="sb-login-input-box">
								<div class="sb-login-input-title">
									<label for="password"><?php esc_html_e( 'Password', 'shopbuild' ); ?>&nbsp;<span class="required">*</span></label>
								</div>
								<div class="sb-login-input">
									<input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" />
									<div class="sb-login-input-eye" id="password-show-toggle">
										<span id="open-eye" class="open-eye">
											<svg width="18" height="14" viewBox="0 0 18 14" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M1 6.77778C1 6.77778 3.90909 1 9 1C14.0909 1 17 6.77778 17 6.77778C17 6.77778 14.0909 12.5556 9 12.5556C3.90909 12.5556 1 6.77778 1 6.77778Z" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
												<path d="M9.00018 8.94466C10.2052 8.94466 11.182 7.97461 11.182 6.77799C11.182 5.58138 10.2052 4.61133 9.00018 4.61133C7.79519 4.61133 6.81836 5.58138 6.81836 6.77799C6.81836 7.97461 7.79519 8.94466 9.00018 8.94466Z" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
											</svg>
										</span>
										<span id="close-eye" class="open-close">
											<svg width="19" height="18" viewBox="0 0 19 18" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M6.8822 11.7457C6.72311 11.7457 6.56402 11.6871 6.43842 11.5615C5.7518 10.8749 5.375 9.9622 5.375 8.99926C5.375 6.99803 6.99943 5.3736 9.00066 5.3736C9.9636 5.3736 10.8763 5.7504 11.5629 6.43701C11.6801 6.55424 11.7471 6.71333 11.7471 6.8808C11.7471 7.04827 11.6801 7.20736 11.5629 7.32459L7.32599 11.5615C7.20039 11.6871 7.0413 11.7457 6.8822 11.7457ZM9.00066 6.6296C7.69442 6.6296 6.631 7.69302 6.631 8.99926C6.631 9.41793 6.73986 9.81985 6.94082 10.1715L10.1729 6.93941C9.82125 6.73845 9.41933 6.6296 9.00066 6.6296Z" fill="#1C274C"/>
												<path opacity="0.5" d="M3.63816 14.4503C3.49582 14.4503 3.3451 14.4001 3.22787 14.2996C2.33192 13.5376 1.52808 12.5998 0.841463 11.5112C-0.0461127 10.1296 -0.0461127 7.87721 0.841463 6.48723C2.88456 3.28861 5.8571 1.44647 8.99711 1.44647C10.8393 1.44647 12.6563 2.08285 14.2472 3.28024C14.5235 3.48957 14.5821 3.88312 14.3728 4.15944C14.1635 4.43576 13.7699 4.49437 13.4936 4.28504C12.1204 3.24674 10.5629 2.70248 8.99711 2.70248C6.29252 2.70248 3.70515 4.32691 1.89651 7.16547C1.2685 8.14516 1.2685 9.85332 1.89651 10.833C2.52451 11.8127 3.24462 12.6584 4.04009 13.345C4.29966 13.5711 4.33315 13.9646 4.10707 14.2326C3.98984 14.3749 3.814 14.4503 3.63816 14.4503Z" fill="#1C274C"/>
												<path opacity="0.5" d="M9.00382 16.552C7.89017 16.552 6.80163 16.3259 5.75496 15.8821C5.43678 15.7482 5.28606 15.3797 5.42003 15.0616C5.554 14.7434 5.92243 14.5927 6.24062 14.7266C7.12819 15.1034 8.05764 15.296 8.99545 15.296C11.7 15.296 14.2874 13.6716 16.0961 10.833C16.7241 9.85333 16.7241 8.14517 16.0961 7.16548C15.8365 6.75519 15.5518 6.36164 15.2503 5.99321C15.0326 5.72527 15.0745 5.33172 15.3425 5.10564C15.6104 4.88793 16.0039 4.92142 16.23 5.19775C16.5566 5.59967 16.8748 6.03508 17.1595 6.48724C18.047 7.86885 18.047 10.1213 17.1595 11.5113C15.1164 14.7099 12.1438 16.552 9.00382 16.552Z" fill="#1C274C"/>
												<path d="M9.58061 12.5747C9.28754 12.5747 9.01959 12.3654 8.96098 12.0639C8.89399 11.7206 9.12007 11.3941 9.46338 11.3355C10.3845 11.168 11.1548 10.3976 11.3223 9.47657C11.3893 9.13327 11.7158 8.91556 12.0591 8.97417C12.4024 9.04116 12.6285 9.36772 12.5615 9.71103C12.2936 11.1596 11.1381 12.3068 9.69783 12.5747C9.65597 12.5663 9.62247 12.5747 9.58061 12.5747Z" fill="#1C274C"/>
												<path d="M0.625908 18.0007C0.466815 18.0007 0.307721 17.9421 0.18212 17.8165C-0.0607068 17.5736 -0.0607068 17.1717 0.18212 16.9289L6.43702 10.674C6.67984 10.4312 7.08177 10.4312 7.32459 10.674C7.56742 10.9168 7.56742 11.3188 7.32459 11.5616L1.0697 17.8165C0.944096 17.9421 0.785002 18.0007 0.625908 18.0007Z" fill="#1C274C"/>
												<path d="M11.122 7.50881C10.9629 7.50881 10.8038 7.45019 10.6782 7.32459C10.4354 7.08177 10.4354 6.67984 10.6782 6.43702L16.9331 0.182121C17.1759 -0.0607068 17.5779 -0.0607068 17.8207 0.182121C18.0635 0.424948 18.0635 0.826869 17.8207 1.0697L11.5658 7.32459C11.4402 7.45019 11.2811 7.50881 11.122 7.50881Z" fill="#1C274C"/>
											</svg>
										</span>
									</div>
								</div>
							</div>
						</div>
						<?php do_action( 'woocommerce_login_form' ); ?>
						<div class="sb-login-suggetions sb-d-sm-flex sb-align-items-center sb-justify-content-between">
							<div class="sb-login-remeber">
								<label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
									<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e( 'Remember me', 'shopbuild' ); ?></span>
								</label>
							</div>
							<?php if(!is_user_logged_in()) : ?>
							<div class="sb-login-forgot">
								<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'shopbuild' ); ?></a>
							</div>
							<?php endif; ?>
						</div>
						<div class="sb-login-bottom">
							<button type="submit" class="woocommerce-button button woocommerce-form-login__submit<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="login" value="<?php esc_attr_e( 'Log in', 'shopbuild' ); ?>"><?php esc_html_e( 'Log in', 'shopbuild' ); ?></button>
						</div>
					</div>
					<?php do_action( 'woocommerce_login_form_end' ); ?>
				</form>
				<?php if(!empty($sb_login_footer_text)) : ?>
				<div class="sb-login-reg-end">
					<p> <?php echo wp_kses($sb_login_footer_text, pure_wc_get_kses_extended_ruleset() ); ?></p>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>

