<?php
/**
 * affiliates-wellcome-email.php
 *
 * Copyright (c) 2011,2012 Antonio Blanco http://www.eggemplo.com
 *
 * This code is released under the GNU General Public License.
 * See COPYRIGHT.txt and LICENSE.txt.
 *
 * This code is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This header and all notices must be kept intact.
 *
 * @author Antonio Blanco	
 * @package affiliates-extra-tokens
 * @since affiliates-extra-tokens 1.0
 *
 * Plugin Name: Affiliates Wellcome Email
 * Plugin URI: http://www.eggemplo.com
 * Description: Send a wellcome email to new affiliate.
 * Version: 1.0
 * Author: eggemplo
 * Author URI: http://www.eggemplo.com
 * License: GPLv3
 */

define( 'AFFILIATES_WELLCOME_EMAIL_DOMAIN', 'affiliateswellcomeemail' );

define( 'AFFILIATES_WELLCOME_EMAIL_FILE', __FILE__ );


class Affiliates_Wellcome_Email_Plugin {
	
	private static $notices = array();
	
	public static function init() {

		add_action( 'init', array( __CLASS__, 'wp_init' ) );
		add_action( 'admin_notices', array( __CLASS__, 'admin_notices' ) );
	}
	
	public static function wp_init() {
		if ( !defined ( 'AFFILIATES_PLUGIN_DOMAIN' ) )  {
			self::$notices[] = "<div class='error'>" . __( '<strong>Affiliates Wellcome Email</strong> plugin requires <a href="http://www.itthinx.com/plugins/affiliates-pro" target="_blank">Affiliates Pro</a> or <a href="http://www.itthinx.com/plugins/affiliates-enterprise" target="_blank">Affiliates Enterprise</a>.', AFFILIATES_WELLCOME_EMAIL_DOMAIN ) . "</div>";
		} else {
		
			add_action( "affiliates_added_affiliate", array(__CLASS__, "affiliates_added_affiliate" ) );
		}
		
	}
		
	
	public static function admin_notices() { 
		if ( !empty( self::$notices ) ) {
			foreach ( self::$notices as $notice ) {
				echo $notice;
			}
		}
	}
	
	
	public static function affiliates_added_affiliate ($affiliate_id) {
		$affiliate = affiliates_get_affiliate( $affiliate_id );
		
		if ( ( $affiliate ) && ( strlen( $affiliate['email'] ) > 0 ) ) {
			$headers = 'From: ' . get_option( 'blogname' ) . ' <' . get_option( 'admin_email' ) .'>' . "\r\n";
			$to = $affiliate['email'];
			
			$subject = 'Wellcome to the affiliates program';
			$message = 'Thanks to subscribe to the affiliates program.';
			
			@wp_mail( $to, $subject, $message, $headers );
		}
	}
}

Affiliates_Wellcome_Email_Plugin::init();
?>
