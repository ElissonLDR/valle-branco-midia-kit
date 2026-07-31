<?php
/**
 * Seed do Mídia Kit a partir do catálogo Lovable,
 * reutilizando attachments já existentes no WordPress.
 *
 * Uso: php bin/seed-lovable.php
 *
 * @package ValleBrancoMidiaKit
 */

if ( ! defined( 'ABSPATH' ) ) {
	$root = dirname( __DIR__, 4 );
	require_once $root . '/wp-load.php';
}

if ( ! class_exists( 'VB_MK_CPT' ) ) {
	fwrite( STDERR, "Plugin valle-branco-midia-kit não ativo.\n" );
	exit( 1 );
}

/**
 * Resolve attachment ID pelo basename do arquivo (exato ou contém).
 *
 * @param string[] $candidates Nomes de arquivo.
 * @return int
 */
function vb_mk_find_attachment( array $candidates ) {
	global $wpdb;

	foreach ( $candidates as $name ) {
		$name = basename( (string) $name );
		if ( '' === $name ) {
			continue;
		}

		// Basename exato (evita casar cropped-Logotipo com Logotipo).
		$rows = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT post_id, meta_value FROM {$wpdb->postmeta}
				WHERE meta_key = '_wp_attached_file' AND meta_value LIKE %s
				ORDER BY post_id ASC",
				'%' . $wpdb->esc_like( $name )
			)
		);

		if ( empty( $rows ) ) {
			continue;
		}

		foreach ( $rows as $row ) {
			if ( strcasecmp( basename( (string) $row->meta_value ), $name ) === 0 ) {
				return (int) $row->post_id;
			}
		}
	}

	return 0;
}

/**
 * Cria ou atualiza item do mídia kit.
 *
 * @param string $key      Chave estável.
 * @param string $title    Título.
 * @param int    $thumb_id Attachment.
 * @param int    $order    menu_order.
 * @return string created|updated|skipped
 */
function vb_mk_upsert_item( $key, $title, $thumb_id, $order ) {
	$existing = get_posts(
		array(
			'post_type'      => VB_MK_CPT::POST_TYPE,
			'post_status'    => 'any',
			'posts_per_page' => 1,
			'meta_key'       => '_vb_mk_seed_key',
			'meta_value'     => $key,
			'fields'         => 'ids',
		)
	);

	$postarr = array(
		'post_type'   => VB_MK_CPT::POST_TYPE,
		'post_status' => 'publish',
		'post_title'  => $title,
		'menu_order'  => (int) $order,
	);

	if ( ! empty( $existing ) ) {
		$post_id = (int) $existing[0];
		$postarr['ID'] = $post_id;
		wp_update_post( $postarr );
		if ( $thumb_id ) {
			set_post_thumbnail( $post_id, $thumb_id );
		}
		return 'updated';
	}

	$post_id = wp_insert_post( $postarr, true );
	if ( is_wp_error( $post_id ) ) {
		fwrite( STDERR, "Erro {$key}: " . $post_id->get_error_message() . "\n" );
		return 'skipped';
	}

	update_post_meta( $post_id, '_vb_mk_seed_key', $key );
	if ( $thumb_id ) {
		set_post_thumbnail( $post_id, $thumb_id );
	}

	return 'created';
}

// Espelha itensProdutosMidiaKit() do Lovable (uma entrada por embalagem/imagem).
$items = array(
	array(
		'key'   => 'arroz-extra-premium-valle-branco-t1-5kg',
		'title' => 'Arroz Extra Premium Valle Branco tipo 1 5kg',
		'files' => array( 'arroz-extra-premium-5kg-1.webp', 'arroz-extra-premium-5kg.webp', 'Arroz-Extra-Premium-Valle-Branco-T1-6x5kg.webp' ),
		'order' => 10,
	),
	array(
		'key'   => 'arroz-integral-valle-branco-t1-1kg',
		'title' => 'Arroz Integral Valle Branco tipo 1 1kg',
		'files' => array( 'arroz-integral-1kg.webp', 'Arroz-Integral-Valle-Branco-T1-10x1kg.webp' ),
		'order' => 20,
	),
	array(
		'key'   => 'arroz-parboilizado-valle-branco-t1-5kg',
		'title' => 'Arroz Parboilizado Valle Branco tipo 1 5kg',
		'files' => array( 'arroz-parboilizado-5kg.webp', 'Arroz-Parboilizado-Valle-Branco-T1-6x5kg.webp' ),
		'order' => 30,
	),
	array(
		'key'   => 'arroz-arborio-valle-branco-10x1kg',
		'title' => 'Arroz Arbório Valle Branco 1kg',
		'files' => array( 'arroz-arborio-1kg.webp', 'ArrozArborioValleBranco10x1.webp', 'ArrozArborioValleBranco5x1.webp' ),
		'order' => 40,
	),
	array(
		'key'   => 'feijao-carioca-valle-branco-t1-30x1kg',
		'title' => 'Feijão Carioca Valle Branco tipo 1 1kg',
		'files' => array( 'feijao-carioca-1kg.webp', 'Feijao-Carioca-Valle-Branco-T1-10x1kg.webp' ),
		'order' => 50,
	),
	array(
		'key'   => 'feijao-preto-valle-branco-t1-30x1kg',
		'title' => 'Feijão Preto Valle Branco tipo 1 1kg',
		'files' => array( 'feijao-preto-1kg.webp', 'Feijao-Preto-Valle-Branco-T1-30x1kg.webp' ),
		'order' => 60,
	),
	array(
		'key'   => 'feijao-bolinha-valle-branco-t1-1kg',
		'title' => 'Feijão Bolinha Valle Branco tipo 1 1kg',
		'files' => array( 'feijao-bolinha-1kg.webp', 'Feijao-Bolinha-Valle-Branco-T1-10x1kg.webp' ),
		'order' => 70,
	),
	array(
		'key'   => 'queijo-ralado-valle-branco-fiapo-40g',
		'title' => 'Queijo Ralado Valle Branco Fiapo 40g',
		'files' => array( 'queijo-ralado-40g.webp', 'Queijo-Ralado-Valle-Branco-Fiapo-25x40g.webp' ),
		'order' => 75,
	),
	array(
		'key'   => 'palmito-valle-branco-pupunha-inteiro-300g',
		'title' => 'Palmito Valle Branco Pupunha Inteiro 300g',
		'files' => array( 'palmito-inteiro-300g.webp', 'Palmito-Valle-Branco-Pupunha-Inteiro-6x300g.webp' ),
		'order' => 78,
	),
	array(
		'key'   => 'palmito-valle-branco-pupunha-picado-300g',
		'title' => 'Palmito Valle Branco Pupunha Picado 300g',
		'files' => array( 'palmito-picado-300g.webp', 'Palmito-Valle-Branco-Pupunha-Picado-6x300g.webp' ),
		'order' => 80,
	),
	array(
		'key'   => 'palmito-valle-branco-pupunha-rodelas-300g',
		'title' => 'Palmito Valle Branco Pupunha Rodelas 300g',
		'files' => array( 'palmito-rodelas-300g.webp', 'Palmito-Valle-Branco-Pupunha-Rodelas-6x300g.webp' ),
		'order' => 82,
	),
	array(
		'key'   => 'arroz-castelao-t1-5kg',
		'title' => 'Arroz Castelão tipo 1 5kg',
		'files' => array( 'arroz-castelao-5kg.webp', 'Arroz-Castelao-T1-6x5kg.webp' ),
		'order' => 100,
	),
	array(
		'key'   => 'arroz-castelao-t2-5kg',
		'title' => 'Arroz Castelão tipo 2 5kg',
		'files' => array( 'arroz-castelao-tipo-2-5kg.webp', 'Arroz-Castelao-T2-6x5kg.webp' ),
		'order' => 110,
	),
	array(
		'key'   => 'arroz-castelao-t3-5kg',
		'title' => 'Arroz Castelão tipo 3 5kg',
		'files' => array( 'arroz-castelao-tipo-3-5kg.webp', 'Arroz-Castelao-T3-6x5kg.webp' ),
		'order' => 120,
	),
	array(
		'key'   => 'arroz-castelao-serie-ouro-t1-5kg',
		'title' => 'Arroz Castelão Série Ouro tipo 1 5kg',
		'files' => array( 'arroz-castelao-serie-ouro-5kg.webp', 'Arroz-Castelao-Serie-Ouro-T1-6x5kg.webp' ),
		'order' => 130,
	),
	array(
		'key'   => 'feijao-castelao-t1-30x1kg',
		'title' => 'Feijão Castelão tipo 1 1kg',
		'files' => array( 'feijao-castelao-1kg.webp', 'Feijao-Castelao-T1-10x1kg.webp', 'Feijao-Castelao-T1-30x1kg.webp' ),
		'order' => 140,
	),
	array(
		'key'   => 'feijao-castelao-economico-t1-1kg',
		'title' => 'Feijão Castelão Econômico tipo 1 1kg',
		'files' => array( 'feijao-castelao-economico-1kg.webp', 'Feijao-Castelao-Economico-T1-30x1kg.webp' ),
		'order' => 150,
	),
	array(
		'key'   => 'arroz-aene-t1-5kg',
		'title' => 'Arroz Aene tipo 1 5kg',
		'files' => array( 'arroz-aene-5kg.webp', 'Arroz-Aene-T1-6x5kg.webp' ),
		'order' => 160,
	),
	array(
		'key'   => 'arroz-aene-mix-t1-5kg',
		'title' => 'Arroz Aene Mix tipo 1 5kg',
		'files' => array( 'arroz-aene-mix-5kg.webp', 'Arroz-Aene-Mix-T1-6x5kg.webp' ),
		'order' => 170,
	),
	array(
		'key'   => 'arroz-vita-abaixo-padrao-5kg',
		'title' => 'Arroz Vita Abaixo Padrão 5kg',
		'files' => array( 'arroz-vita-abaixo-5kg.webp', 'Arroz-Vita-Abaixo-Padrao-6x5kg.webp' ),
		'order' => 180,
	),
	array(
		'key'   => 'simbolo-b-valle-branco',
		'title' => 'Símbolo B Valle Branco',
		'files' => array( 'simbolo-b-valle-branco.png', 'logo.png' ),
		'order' => 910,
	),
);

$stats = array(
	'created' => 0,
	'updated' => 0,
	'skipped' => 0,
	'missing' => array(),
);

foreach ( $items as $item ) {
	$thumb = vb_mk_find_attachment( $item['files'] );
	if ( ! $thumb ) {
		$stats['missing'][] = $item['key'] . ' (' . implode( ', ', $item['files'] ) . ')';
		$stats['skipped']++;
		echo "MISSING image: {$item['title']}\n";
		continue;
	}

	$status = vb_mk_upsert_item( $item['key'], $item['title'], $thumb, $item['order'] );
	$stats[ $status ]++;
	echo strtoupper( $status ) . " [{$thumb}] {$item['title']}\n";
}

echo "\nResumo: created={$stats['created']} updated={$stats['updated']} skipped={$stats['skipped']}\n";
if ( $stats['missing'] ) {
	echo "Sem imagem:\n- " . implode( "\n- ", $stats['missing'] ) . "\n";
}
