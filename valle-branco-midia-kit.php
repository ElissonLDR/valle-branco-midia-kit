<?php
/**
 * Plugin Name:       Valle Branco — Mídia Kit
 * Plugin URI:        https://github.com/ElissonLDR/valle-branco-midia-kit
 * Description:       Gerencie produtos do mídia kit (nome e imagem). Shortcode e widget Elementor.
 * Version:           1.0.4
 * Requires at least: 6.0
 * Requires PHP:      7.4
 * Author:            Valle Branco
 * Author URI:        https://vallebranco.com.br
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       valle-branco-midia-kit
 *
 * @package ValleBrancoMidiaKit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'VB_MK_VERSION', '1.0.4' );
define( 'VB_MK_FILE', __FILE__ );
define( 'VB_MK_PATH', plugin_dir_path( __FILE__ ) );
define( 'VB_MK_URL', plugin_dir_url( __FILE__ ) );
define( 'VB_MK_BASENAME', plugin_basename( __FILE__ ) );

require_once VB_MK_PATH . 'includes/class-vb-mk-cpt.php';
require_once VB_MK_PATH . 'includes/class-vb-mk-query.php';
require_once VB_MK_PATH . 'includes/class-vb-mk-frontend.php';
require_once VB_MK_PATH . 'includes/class-vb-mk-shortcode.php';
require_once VB_MK_PATH . 'includes/class-vb-mk-elementor.php';
require_once VB_MK_PATH . 'includes/class-vb-mk-admin.php';
require_once VB_MK_PATH . 'includes/class-vb-mk-plugin.php';

/**
 * Ativação.
 */
function vb_mk_activate() {
	VB_MK_CPT::register();
	flush_rewrite_rules( false );
	update_option( 'vb_mk_version', VB_MK_VERSION );
}
register_activation_hook( __FILE__, 'vb_mk_activate' );

/**
 * Desativação.
 */
function vb_mk_deactivate() {
	flush_rewrite_rules( false );
}
register_deactivation_hook( __FILE__, 'vb_mk_deactivate' );

/**
 * Boot.
 */
function vb_mk_run() {
	$plugin = new VB_MK_Plugin();
	$plugin->run();
}
add_action( 'plugins_loaded', 'vb_mk_run' );
