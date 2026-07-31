<?php
/**
 * Shortcode.
 *
 * @package ValleBrancoMidiaKit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Classe VB_MK_Shortcode
 */
class VB_MK_Shortcode {

	/**
	 * Hooks.
	 */
	public function hooks() {
		add_shortcode( 'vb_midia_kit', array( $this, 'render' ) );
		add_shortcode( 'valle_midia_kit', array( $this, 'render' ) );
	}

	/**
	 * Render.
	 *
	 * @param array $atts Atributos.
	 * @return string
	 */
	public function render( $atts ) {
		$atts = shortcode_atts(
			array(
				'titulo'       => '',
				'subtitulo'    => '',
				'eyebrow'      => '',
				'colunas'      => '4',
				'download'     => '1',
				'mostrar_titulo' => '1',
			),
			$atts,
			'vb_midia_kit'
		);

		return VB_MK_Frontend::render(
			array(
				'heading'      => $atts['titulo'] ? $atts['titulo'] : __( 'Imagens dos produtos', 'valle-branco-midia-kit' ),
				'subtitle'     => $atts['subtitulo'] ? $atts['subtitulo'] : __( 'Selecione a marca e baixe a imagem da embalagem em alta resolução.', 'valle-branco-midia-kit' ),
				'eyebrow'      => $atts['eyebrow'] ? $atts['eyebrow'] : __( 'Downloads', 'valle-branco-midia-kit' ),
				'columns'      => (int) $atts['colunas'],
				'download'     => (bool) (int) $atts['download'],
				'show_heading' => (bool) (int) $atts['mostrar_titulo'],
			)
		);
	}
}
