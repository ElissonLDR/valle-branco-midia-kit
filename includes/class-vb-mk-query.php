<?php
/**
 * Consultas do mídia kit.
 *
 * @package ValleBrancoMidiaKit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Classe VB_MK_Query
 */
class VB_MK_Query {

	/**
	 * Lista itens publicados ordenados.
	 *
	 * @param array $args Args: ids.
	 * @return WP_Post[]
	 */
	public static function get_items( $args = array() ) {
		$args = wp_parse_args(
			$args,
			array(
				'ids' => array(),
			)
		);

		$query_args = array(
			'post_type'      => VB_MK_CPT::POST_TYPE,
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => array(
				'menu_order' => 'ASC',
				'title'      => 'ASC',
			),
			'no_found_rows'  => true,
		);

		if ( ! empty( $args['ids'] ) && is_array( $args['ids'] ) ) {
			$query_args['post__in'] = array_map( 'absint', $args['ids'] );
			$query_args['orderby']  = 'post__in';
		}

		$q = new WP_Query( $query_args );
		return $q->posts;
	}
}
