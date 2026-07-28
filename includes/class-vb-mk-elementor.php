<?php
/**
 * Elementor bootstrap.
 *
 * @package ValleBrancoMidiaKit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Classe VB_MK_Elementor
 */
class VB_MK_Elementor {

	/**
	 * Hooks.
	 */
	public function hooks() {
		add_action( 'elementor/widgets/register', array( $this, 'register_widgets' ) );
		add_action( 'elementor/elements/categories_registered', array( $this, 'register_category' ) );
	}

	/**
	 * Categoria Valle Branco (ou própria se ainda não existir).
	 *
	 * @param \Elementor\Elements_Manager $elements_manager Manager.
	 */
	public function register_category( $elements_manager ) {
		$elements_manager->add_category(
			'valle-branco',
			array(
				'title' => __( 'Valle Branco', 'valle-branco-midia-kit' ),
				'icon'  => 'fa fa-plug',
			)
		);
	}

	/**
	 * Widgets.
	 *
	 * @param \Elementor\Widgets_Manager $widgets_manager Manager.
	 */
	public function register_widgets( $widgets_manager ) {
		if ( ! did_action( 'elementor/loaded' ) && ! class_exists( '\Elementor\Widget_Base' ) ) {
			return;
		}
		require_once VB_MK_PATH . 'includes/elementor/class-widget-midia-kit.php';
		$widgets_manager->register( new VB_MK_Widget_Midia_Kit() );
	}
}
