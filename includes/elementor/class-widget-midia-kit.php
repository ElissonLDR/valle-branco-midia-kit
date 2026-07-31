<?php
/**
 * Widget Elementor: Mídia Kit.
 *
 * @package ValleBrancoMidiaKit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Classe VB_MK_Widget_Midia_Kit
 */
class VB_MK_Widget_Midia_Kit extends \Elementor\Widget_Base {

	/**
	 * @return string
	 */
	public function get_name() {
		return 'vb-midia-kit';
	}

	/**
	 * @return string
	 */
	public function get_title() {
		return __( 'Mídia Kit', 'valle-branco-midia-kit' );
	}

	/**
	 * @return string
	 */
	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	/**
	 * @return array
	 */
	public function get_categories() {
		return array( 'valle-branco', 'general' );
	}

	/**
	 * @return array
	 */
	public function get_keywords() {
		return array( 'midia', 'kit', 'imprensa', 'produtos', 'download' );
	}

	/**
	 * @return array
	 */
	public function get_style_depends() {
		return array( 'vb-mk-front' );
	}

	/**
	 * @return array
	 */
	public function get_script_depends() {
		return array( 'vb-mk-front' );
	}

	/**
	 * Controles.
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'section_content',
			array(
				'label' => __( 'Conteúdo', 'valle-branco-midia-kit' ),
			)
		);

		$this->add_control(
			'show_heading',
			array(
				'label'        => __( 'Mostrar título', 'valle-branco-midia-kit' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'eyebrow',
			array(
				'label'     => __( 'Eyebrow', 'valle-branco-midia-kit' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'default'   => __( 'Downloads', 'valle-branco-midia-kit' ),
				'condition' => array( 'show_heading' => 'yes' ),
			)
		);

		$this->add_control(
			'heading',
			array(
				'label'     => __( 'Título', 'valle-branco-midia-kit' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'default'   => __( 'Imagens dos produtos', 'valle-branco-midia-kit' ),
				'condition' => array( 'show_heading' => 'yes' ),
			)
		);

		$this->add_control(
			'subtitle',
			array(
				'label'     => __( 'Subtítulo', 'valle-branco-midia-kit' ),
				'type'      => \Elementor\Controls_Manager::TEXTAREA,
				'default'   => __( 'Selecione a marca e baixe a imagem da embalagem em alta resolução.', 'valle-branco-midia-kit' ),
				'condition' => array( 'show_heading' => 'yes' ),
			)
		);

		$this->add_control(
			'columns',
			array(
				'label'   => __( 'Colunas', 'valle-branco-midia-kit' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
				),
				'default' => '4',
			)
		);

		$this->add_control(
			'download',
			array(
				'label'        => __( 'Botão baixar imagem', 'valle-branco-midia-kit' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render.
	 */
	protected function render() {
		$s = $this->get_settings_for_display();
		echo VB_MK_Frontend::render( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			array(
				'heading'      => $s['heading'],
				'subtitle'     => $s['subtitle'],
				'eyebrow'      => $s['eyebrow'],
				'columns'      => (int) $s['columns'],
				'download'     => 'yes' === $s['download'],
				'show_heading' => 'yes' === $s['show_heading'],
			)
		);
	}
}
