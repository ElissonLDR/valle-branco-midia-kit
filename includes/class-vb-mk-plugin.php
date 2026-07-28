<?php
/**
 * Orquestra o plugin.
 *
 * @package ValleBrancoMidiaKit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Classe VB_MK_Plugin
 */
class VB_MK_Plugin {

	/**
	 * Liga módulos.
	 */
	public function run() {
		load_plugin_textdomain( 'valle-branco-midia-kit', false, dirname( VB_MK_BASENAME ) . '/languages' );

		add_action( 'init', array( 'VB_MK_CPT', 'register' ), 5 );
		add_action( 'init', array( $this, 'maybe_upgrade' ), 99 );

		$shortcode = new VB_MK_Shortcode();
		$shortcode->hooks();

		$front = new VB_MK_Frontend();
		$front->hooks();

		if ( is_admin() ) {
			$admin = new VB_MK_Admin();
			$admin->hooks();
		}

		$elementor = new VB_MK_Elementor();
		$elementor->hooks();
	}

	/**
	 * Upgrade / flush quando a versão muda.
	 */
	public function maybe_upgrade() {
		$stored = get_option( 'vb_mk_version', '' );
		if ( VB_MK_VERSION !== $stored ) {
			flush_rewrite_rules( false );
			update_option( 'vb_mk_version', VB_MK_VERSION );
		}
	}
}
