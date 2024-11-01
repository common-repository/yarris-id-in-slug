<?php
/*
Plugin Name: Yarri's "ID in slug"
Plugin URI: http://en.yarri.org/
Description: Puts the ID of the post in the slug.
Author: Yarri
Author URI: http://en.yarri.org/
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Version: 1.0
Domain Path: /languages
Text Domain: yarri-id-in-slug
*/


function yar_iis_save( $slug, $post_ID, $post_status, $post_type ) {
	global $wpdb;
	
	if (substr_count($slug, $post_ID)) {
		// already done
		return $slug;
	}
	else {
		$yar_iis_separator = get_option('yar_iis_separator', '-');
		if (get_option('yar_iis_position', 'before') == 'before') {
			return $post_ID . $yar_iis_separator . $slug;
		} else {
			return $slug . $yar_iis_separator . $post_ID;
		}
	}
}

add_filter( 'wp_unique_post_slug', 'yar_iis_save', 10, 4 );


function yar_iis_build_settings_page() {
	?>
	<div class="wrap">
	<h1><? _e('Yarri\'s "ID in slug"', 'yarri-id-in-slug'); ?></h1>
	<h1>&nbsp;</h1>
	<?
	yar_iis_echo_settings();
	yar_iis_echo_donation();
	yar_iis_echo_thanx();
	?>
	</div>
	<?
}

function yar_iis_echo_settings() {
	$yar_iis_position = get_option( 'yar_iis_position', 'before');
	$yar_iis_separator = get_option('yar_iis_separator', '-');
	
	?>
		<h2><? _e('Settings', 'yarri-id-in-slug'); ?></h2>
		<form method="post" action="options.php">

	<? wp_nonce_field('update-options'); ?>
			<table class="form-table">
				<tr>
					<th scope="row">
						<label for="yar_iis_position"><? _e('Position of the ID', 'yarri-id-in-slug'); ?></label>
					</th>
					<td>
						<input id="yar_iis_position" type="radio" name="yar_iis_position" value="before" 
							<? echo (($yar_iis_position == 'before') ? 'checked="checked"' : ''); ?> /> 
							<? _e('ID before slug', 'yarri-id-in-slug'); ?> <br />
						<input id="yar_iis_position" type="radio" name="yar_iis_position" value="after" 
							<? echo (($yar_iis_position == 'after') ? 'checked="checked"' : ''); ?> /> 
							<? _e('ID after slug', 'yarri-id-in-slug'); ?> <br />
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="yar_iis_separator"> <? _e('Separator', 'yarri-id-in-slug'); ?> </label>
					</th>
					<td>
						<input id="yar_iis_separator" type="text" name="yar_iis_separator" value="<? echo $yar_iis_separator; ?>">
						<p id="admin-email-description" class="description">
						<? _e('e.g. " " (whitespace), "_" (underscore), "-" (hyphen) etc - anything you want. This will separate the id of the post from the slug. Also you can live it empty.', 'yarri-id-in-slug');
						?> </p>
					</td>
				</tr>
			</table>
			<input type="hidden" name="action" value="update" />
			<input type="hidden" name="page_options" value="yar_iis_separator,yar_iis_position" />
			<p class="submit">
<input type="submit" class="button-primary" value="<? _e('Save Changes', 'yarri-id-in-slug'); ?>" />
</p>
		</form>
	<?
}

function yar_iis_echo_donation() {
	?>
	<div>
	<h2><? _e('If you find this plugin useful', 'yarri-id-in-slug'); ?></h2>
		<p style="font-size: 16px;">... <? _e('you can help by sending a few dollars (or euros, pounds, rubles etc). If you send more than $10 (or its equivalent), we will place your link in the "Thanks to..." section. If you send more than $100, we will place your banner there. The largest donation (more than $100) will have the uppermost and largest banner placement. Thank you for your consideration.', 'yarri-id-in-slug'); ?>
		</p>
	<?
	yar_iis_echo_paypal();
	yar_iis_echo_yandex();
	yar_iis_echo_other_donation();
	?>
	<div style="clear: both;">&nbsp;</div>
	</div>
	<?;
}

function yar_iis_echo_paypal() {
	?>
		<div style="float: left; margin: 10px 40px 10px 0;">
			<h3 style="text-align: center;"><? _e('Donate via PayPal', 'yarri-id-in-slug'); ?></h3>
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
				<input type="hidden" name="cmd" value="_s-xclick">
				<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
				">
				<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
				<img alt="" border="0" src="https://www.paypalobjects.com/ru_RU/i/scr/pixel.gif" width="1" height="1">
			</form>
		</div>
	<?
}

function yar_iis_echo_yandex() {
	?>
		<div style="float: left; margin: 10px 40px 10px 0;">
			<h3 style="text-align: center;"><? _e('Donate via Yandex.Money', 'yarri-id-in-slug'); ?></h3>
			<iframe frameborder="0" allowtransparency="true" scrolling="no" src="https://money.yandex.ru/embed/shop.xml?account=410011719012841&quickpay=shop&payment-type-choice=on&mobile-payment-type-choice=on&writer=seller&targets=Thanx+for+plugin+%22ID+in+Slug%22&targets-hint=&default-sum=256&button-text=03&comment=on&hint=%D0%BC%D0%BE%D0%B6%D0%B5%D1%82%D0%B5+%D1%87%D1%82%D0%BE-%D0%BD%D0%B8%D0%B1%D1%83%D0%B4%D1%8C+%D1%82%D1%83%D1%82+%D0%BD%D0%B0%D0%BF%D0%B8%D1%81%D0%B0%D1%82%D1%8C&successURL=" width="450" height="268"></iframe>
		</div>
	<?
}

function yar_iis_echo_other_donation() {
	?>
		<div style="float: left; margin: 10px 40px 10px 0;">
			<h3 style="text-align: center;"><? _e('Donate via other PS', 'yarri-id-in-slug'); ?></h3>
			<p><? _e('If you want to donate via other payment sistem, please,<br />contact us at <a href="http://en.yarri.org/contacts/" target="_blank" alt="Link will open in a new window" title="Link will open in a new window">Contacts Page</a>', 'yarri-id-in-slug'); ?></p>
		</div>
	<?
}

function yar_iis_echo_thanx() {
	?>
		<div>
			<h2><? _e('Thanks to', 'yarri-id-in-slug'); ?></h2>
			<a href="http://xn----8sbdmbn3b3cwe.xn--p1ai/">Ne-Zabud.RF</a><br />
			<a href="http://xn----dtbhjcrvdd0b2a2fb.xn--p1ai/">Plohie-Otzyvy.RF</a><br />
			<a href="http://poterjashka-nsk.ru/">Poterjashka-NSK.ru</a><br />
		</div>
	<?
}

function yar_iis_add_menu() {
	add_options_page(
		'Yarri\'s "Id in slug" settings',
		'Yarri\'s "Id in slug"',
		'manage_options',
		'yarri-id-in-slug',
		'yar_iis_build_settings_page'
	);
}

add_action('admin_menu', 'yar_iis_add_menu');

function yar_iis_load_textdomain() {
    load_plugin_textdomain( 'yarri-id-in-slug', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
}

add_action( 'plugins_loaded', 'yar_iis_load_textdomain' );

?>