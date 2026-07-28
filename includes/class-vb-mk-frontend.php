<?php
/**
 * Frontend: assets + render.
 *
 * @package ValleBrancoMidiaKit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Classe VB_MK_Frontend
 */
class VB_MK_Frontend {

	/**
	 * Hooks.
	 */
	public function hooks() {
		add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ) );
	}

	/**
	 * Registra assets.
	 */
	public function register_assets() {
		wp_register_style(
			'vb-mk-front',
			VB_MK_URL . 'public/css/midia-kit.css',
			array(),
			VB_MK_VERSION
		);
	}

	/**
	 * Enfileira.
	 */
	public function enqueue_assets() {
		if ( ! wp_style_is( 'vb-mk-front', 'registered' ) ) {
			$this->register_assets();
		}
		wp_enqueue_style( 'vb-mk-front' );
	}

	/**
	 * Renderiza a grade do mídia kit.
	 *
	 * @param array $args Args.
	 * @return string
	 */
	public static function render( $args = array() ) {
		$args = wp_parse_args(
			$args,
			array(
				'heading'      => __( 'Mídia Kit', 'valle-branco-midia-kit' ),
				'subtitle'     => __( 'Baixe as imagens dos nossos produtos para uso em matérias e divulgações.', 'valle-branco-midia-kit' ),
				'eyebrow'      => __( 'Imprensa', 'valle-branco-midia-kit' ),
				'show_heading' => true,
				'columns'      => 4,
				'download'     => true,
				'extra_class'  => '',
			)
		);

		$posts = VB_MK_Query::get_items();
		if ( empty( $posts ) ) {
			return '';
		}

		$items = array();
		foreach ( $posts as $post ) {
			$thumb_id  = (int) get_post_thumbnail_id( $post );
			$thumb_url = $thumb_id ? wp_get_attachment_image_url( $thumb_id, 'large' ) : '';
			$full_url  = $thumb_id ? wp_get_attachment_image_url( $thumb_id, 'full' ) : '';

			$items[] = array(
				'id'       => (int) $post->ID,
				'nome'     => get_the_title( $post ),
				'thumb'    => $thumb_url,
				'full'     => $full_url ? $full_url : $thumb_url,
				'thumb_id' => $thumb_id,
			);
		}

		$front = new self();
		$front->enqueue_assets();

		$columns = max( 1, min( 6, (int) $args['columns'] ) );

		ob_start();
		include VB_MK_PATH . 'public/views/grade.php';
		return (string) ob_get_clean();
	}
}
