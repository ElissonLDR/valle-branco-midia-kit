<?php
/**
 * Admin: labels, colunas e dicas.
 *
 * @package ValleBrancoMidiaKit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Classe VB_MK_Admin
 */
class VB_MK_Admin {

	/**
	 * Hooks.
	 */
	public function hooks() {
		add_filter( 'enter_title_here', array( $this, 'title_placeholder' ), 10, 2 );
		add_action( 'edit_form_after_title', array( $this, 'editor_hint' ) );
		add_filter( 'manage_' . VB_MK_CPT::POST_TYPE . '_posts_columns', array( $this, 'columns' ) );
		add_action( 'manage_' . VB_MK_CPT::POST_TYPE . '_posts_custom_column', array( $this, 'column_content' ), 10, 2 );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
	}

	/**
	 * Placeholder do título.
	 *
	 * @param string  $text Placeholder.
	 * @param WP_Post $post Post.
	 * @return string
	 */
	public function title_placeholder( $text, $post ) {
		if ( $post && VB_MK_CPT::POST_TYPE === $post->post_type ) {
			return __( 'Nome do produto…', 'valle-branco-midia-kit' );
		}
		return $text;
	}

	/**
	 * Dica abaixo do título.
	 *
	 * @param WP_Post $post Post.
	 */
	public function editor_hint( $post ) {
		if ( ! $post || VB_MK_CPT::POST_TYPE !== $post->post_type ) {
			return;
		}
		echo '<p class="description vb-mk-admin-hint">';
		esc_html_e( 'Defina a imagem do produto na caixa à direita (Imagem do produto). Use Ordem (Atributos da página) para organizar a grade.', 'valle-branco-midia-kit' );
		echo '</p>';
	}

	/**
	 * Colunas.
	 *
	 * @param array $cols Colunas.
	 * @return array
	 */
	public function columns( $cols ) {
		$new = array();
		foreach ( $cols as $key => $label ) {
			$new[ $key ] = $label;
			if ( 'title' === $key ) {
				$new['vb_mk_thumb'] = __( 'Imagem', 'valle-branco-midia-kit' );
				$new['vb_mk_ordem'] = __( 'Ordem', 'valle-branco-midia-kit' );
			}
		}
		return $new;
	}

	/**
	 * Conteúdo das colunas.
	 *
	 * @param string $col     Coluna.
	 * @param int    $post_id ID.
	 */
	public function column_content( $col, $post_id ) {
		if ( 'vb_mk_thumb' === $col ) {
			if ( has_post_thumbnail( $post_id ) ) {
				echo get_the_post_thumbnail( $post_id, array( 48, 48 ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			} else {
				echo '—';
			}
			return;
		}
		if ( 'vb_mk_ordem' === $col ) {
			$post = get_post( $post_id );
			echo esc_html( $post ? (string) (int) $post->menu_order : '0' );
		}
	}

	/**
	 * CSS mínimo no admin do CPT.
	 *
	 * @param string $hook Hook.
	 */
	public function enqueue( $hook ) {
		$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
		if ( ! $screen || VB_MK_CPT::POST_TYPE !== $screen->post_type ) {
			return;
		}
		wp_enqueue_style(
			'vb-mk-admin',
			VB_MK_URL . 'admin/css/admin.css',
			array(),
			VB_MK_VERSION
		);
	}
}
