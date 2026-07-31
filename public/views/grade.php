<?php
/**
 * View: grade do mídia kit (layout Lovable).
 *
 * Variáveis: $args, $produtos, $logos, $columns, $marcas, $catalogo_url
 *
 * @package ValleBrancoMidiaKit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$extra   = ! empty( $args['extra_class'] ) ? ' ' . sanitize_html_class( $args['extra_class'] ) : '';
$cols_cl = ' vb-mk--cols-' . (int) $columns;

$download_icon = '<svg class="vb-mk__download-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M12 3v12m0 0l4-4m-4 4l-4-4M4 19h16" stroke="currentColor" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round"/></svg>';

$render_card = static function ( $item, $args, $download_icon ) {
	?>
	<li class="vb-mk__item" data-vb-mk-brand="<?php echo esc_attr( $item['marca'] ); ?>">
		<article class="vb-mk__card">
			<div class="vb-mk__thumb">
				<?php if ( ! empty( $item['thumb_id'] ) ) : ?>
					<?php
					echo wp_get_attachment_image( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						$item['thumb_id'],
						'medium',
						false,
						array(
							'class'   => 'vb-mk__img',
							'loading' => 'lazy',
							'alt'     => $item['nome'],
						)
					);
					?>
				<?php else : ?>
					<div class="vb-mk__placeholder" aria-hidden="true"></div>
				<?php endif; ?>
			</div>
			<div class="vb-mk__meta">
				<h3 class="vb-mk__name"><?php echo esc_html( $item['nome'] ); ?></h3>
				<?php if ( ! empty( $args['download'] ) && ! empty( $item['full'] ) ) : ?>
					<a
						class="vb-mk__download"
						href="<?php echo esc_url( $item['full'] ); ?>"
						download
						target="_blank"
						rel="noopener noreferrer"
					>
						<?php echo $download_icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<span><?php esc_html_e( 'Baixar', 'valle-branco-midia-kit' ); ?></span>
					</a>
				<?php endif; ?>
			</div>
		</article>
	</li>
	<?php
};
?>
<section class="vb-mk vb-mk--lovable<?php echo esc_attr( $cols_cl . $extra ); ?>" data-vb-mk>
	<?php if ( ! empty( $args['show_heading'] ) ) : ?>
		<header class="vb-mk__intro">
			<div class="vb-mk__intro-main">
				<div class="vb-mk__intro-text">
					<?php if ( ! empty( $args['eyebrow'] ) ) : ?>
						<p class="vb-mk__eyebrow"><?php echo esc_html( $args['eyebrow'] ); ?></p>
					<?php endif; ?>
					<?php if ( ! empty( $args['heading'] ) ) : ?>
						<h2 class="vb-mk__heading"><?php echo esc_html( $args['heading'] ); ?></h2>
					<?php endif; ?>
					<?php if ( ! empty( $args['subtitle'] ) ) : ?>
						<p class="vb-mk__subtitle"><?php echo esc_html( $args['subtitle'] ); ?></p>
					<?php endif; ?>
				</div>
				<?php if ( ! empty( $catalogo_url ) ) : ?>
					<a class="vb-mk__catalog" href="<?php echo esc_url( $catalogo_url ); ?>" target="_blank" rel="noopener noreferrer">
						<?php echo $download_icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<span><?php esc_html_e( 'Catálogo PDF', 'valle-branco-midia-kit' ); ?></span>
					</a>
				<?php endif; ?>
			</div>
		</header>
	<?php endif; ?>

	<?php if ( ! empty( $produtos ) && count( $marcas ) > 1 ) : ?>
		<div class="vb-mk__filters" role="tablist" aria-label="<?php esc_attr_e( 'Filtrar por marca', 'valle-branco-midia-kit' ); ?>">
			<button type="button" class="vb-mk__tab is-active" role="tab" aria-selected="true" data-vb-mk-filter="">
				<?php esc_html_e( 'Todas', 'valle-branco-midia-kit' ); ?>
			</button>
			<?php foreach ( $marcas as $marca ) : ?>
				<button type="button" class="vb-mk__tab" role="tab" aria-selected="false" data-vb-mk-filter="<?php echo esc_attr( $marca ); ?>">
					<?php echo esc_html( $marca ); ?>
				</button>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

	<?php if ( ! empty( $produtos ) ) : ?>
		<ul class="vb-mk__grid" data-vb-mk-products>
			<?php foreach ( $produtos as $item ) : ?>
				<?php $render_card( $item, $args, $download_icon ); ?>
			<?php endforeach; ?>
		</ul>
		<p class="vb-mk__empty" data-vb-mk-empty hidden>
			<?php esc_html_e( 'Nenhuma imagem para esta marca.', 'valle-branco-midia-kit' ); ?>
		</p>
	<?php endif; ?>

	<?php if ( ! empty( $logos ) ) : ?>
		<div class="vb-mk__logos">
			<p class="vb-mk__eyebrow"><?php esc_html_e( 'Identidade', 'valle-branco-midia-kit' ); ?></p>
			<h3 class="vb-mk__heading vb-mk__heading--sm"><?php esc_html_e( 'Logotipos', 'valle-branco-midia-kit' ); ?></h3>
			<ul class="vb-mk__grid vb-mk__grid--logos">
				<?php foreach ( $logos as $item ) : ?>
					<?php $render_card( $item, $args, $download_icon ); ?>
				<?php endforeach; ?>
			</ul>
		</div>
	<?php endif; ?>

	<p class="vb-mk__press">
		<?php esc_html_e( 'Para solicitações de imprensa ou arquivos em outros formatos, escreva para', 'valle-branco-midia-kit' ); ?>
		<a href="mailto:atendimento@vallebranco.com.br">atendimento@vallebranco.com.br</a>.
	</p>
</section>
