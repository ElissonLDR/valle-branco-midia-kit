<?php
/**
 * CPT do mídia kit.
 *
 * @package ValleBrancoMidiaKit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Classe VB_MK_CPT
 */
class VB_MK_CPT {

	const POST_TYPE = 'vb_mk_item';

	/**
	 * Registra o CPT.
	 */
	public static function register() {
		$labels = array(
			'name'               => __( 'Mídia Kit', 'valle-branco-midia-kit' ),
			'singular_name'      => __( 'Produto do kit', 'valle-branco-midia-kit' ),
			'add_new'            => __( 'Adicionar novo', 'valle-branco-midia-kit' ),
			'add_new_item'       => __( 'Adicionar produto', 'valle-branco-midia-kit' ),
			'edit_item'          => __( 'Editar produto', 'valle-branco-midia-kit' ),
			'new_item'           => __( 'Novo produto', 'valle-branco-midia-kit' ),
			'view_item'          => __( 'Ver produto', 'valle-branco-midia-kit' ),
			'search_items'       => __( 'Buscar produtos', 'valle-branco-midia-kit' ),
			'not_found'          => __( 'Nenhum produto encontrado', 'valle-branco-midia-kit' ),
			'not_found_in_trash' => __( 'Nenhum na lixeira', 'valle-branco-midia-kit' ),
			'menu_name'          => __( 'Mídia Kit', 'valle-branco-midia-kit' ),
			'all_items'          => __( 'Todos os produtos', 'valle-branco-midia-kit' ),
			'featured_image'        => __( 'Imagem do produto', 'valle-branco-midia-kit' ),
			'set_featured_image'    => __( 'Definir imagem', 'valle-branco-midia-kit' ),
			'remove_featured_image' => __( 'Remover imagem', 'valle-branco-midia-kit' ),
			'use_featured_image'    => __( 'Usar como imagem do produto', 'valle-branco-midia-kit' ),
		);

		register_post_type(
			self::POST_TYPE,
			array(
				'labels'              => $labels,
				'public'              => false,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'menu_position'       => 26,
				'menu_icon'           => 'dashicons-download',
				'capability_type'     => 'post',
				'hierarchical'        => false,
				'supports'            => array( 'title', 'thumbnail', 'page-attributes' ),
				'has_archive'         => false,
				'rewrite'             => false,
				'query_var'           => false,
				'show_in_rest'        => true,
				'exclude_from_search' => true,
				'publicly_queryable'  => false,
			)
		);
	}
}
