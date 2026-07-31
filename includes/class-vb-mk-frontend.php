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

	const CATALOGO_PDF = 'https://darkviolet-cod-230737.hostingersite.com/wp-content/uploads/2026/07/CATALAGO-VALLE-BRANCO-ATUAL-2026.pdf';

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
		wp_register_script(
			'vb-mk-front',
			VB_MK_URL . 'public/js/midia-kit.js',
			array(),
			VB_MK_VERSION,
			true
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
		wp_enqueue_script( 'vb-mk-front' );
	}

	/**
	 * Detecta se o item é logo/símbolo.
	 *
	 * @param string $title Título.
	 * @param string $key   Seed key.
	 * @return bool
	 */
	public static function is_logo_item( $title, $key = '' ) {
		$blob = mb_strtolower( trim( $title . ' ' . $key ) );
		return (bool) preg_match( '/logo|simbolo|s[ií]mbolo/', $blob );
	}

	/**
	 * Detecta marca do item.
	 *
	 * @param string $title Título.
	 * @param string $key   Seed key.
	 * @return string
	 */
	public static function detect_brand( $title, $key = '' ) {
		$blob = mb_strtolower( trim( $title . ' ' . $key ) );
		$blob = str_replace( array( 'ã', 'á', 'â' ), 'a', $blob );

		if ( false !== strpos( $blob, 'castelao' ) ) {
			return 'Castelão';
		}
		if ( false !== strpos( $blob, 'aene' ) ) {
			return 'Aene';
		}
		if ( false !== strpos( $blob, 'vita' ) ) {
			return 'Vita';
		}
		return 'Valle Branco';
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
				'heading'      => __( 'Imagens dos produtos', 'valle-branco-midia-kit' ),
				'subtitle'     => __( 'Selecione a marca e baixe a imagem da embalagem em alta resolução.', 'valle-branco-midia-kit' ),
				'eyebrow'      => __( 'Downloads', 'valle-branco-midia-kit' ),
				'show_heading' => true,
				'columns'      => 4,
				'download'     => true,
				'catalogo_url' => self::CATALOGO_PDF,
				'extra_class'  => '',
			)
		);

		$posts = VB_MK_Query::get_items();
		if ( empty( $posts ) ) {
			return '';
		}

		$produtos = array();
		$logos    = array();
		$marcas   = array();

		foreach ( $posts as $post ) {
			$thumb_id  = (int) get_post_thumbnail_id( $post );
			$thumb_url = $thumb_id ? wp_get_attachment_image_url( $thumb_id, 'large' ) : '';
			$full_url  = $thumb_id ? wp_get_attachment_image_url( $thumb_id, 'full' ) : '';
			$key       = (string) get_post_meta( $post->ID, '_vb_mk_seed_key', true );
			$title     = get_the_title( $post );
			$marca     = self::detect_brand( $title, $key );

			$item = array(
				'id'       => (int) $post->ID,
				'nome'     => $title,
				'thumb'    => $thumb_url,
				'full'     => $full_url ? $full_url : $thumb_url,
				'thumb_id' => $thumb_id,
				'marca'    => $marca,
				'key'      => $key,
			);

			if ( self::is_logo_item( $title, $key ) ) {
				$logos[] = $item;
				continue;
			}

			$produtos[] = $item;
			$marcas[ $marca ] = $marca;
		}

		$marcas = array_values( $marcas );
		usort(
			$marcas,
			static function ( $a, $b ) {
				$order = array( 'Valle Branco' => 1, 'Castelão' => 2, 'Aene' => 3, 'Vita' => 4 );
				return ( $order[ $a ] ?? 99 ) <=> ( $order[ $b ] ?? 99 );
			}
		);

		$front = new self();
		$front->enqueue_assets();

		$columns      = max( 1, min( 6, (int) $args['columns'] ) );
		$catalogo_url = ! empty( $args['catalogo_url'] ) ? (string) $args['catalogo_url'] : self::CATALOGO_PDF;

		ob_start();
		include VB_MK_PATH . 'public/views/grade.php';
		return (string) ob_get_clean();
	}
}
