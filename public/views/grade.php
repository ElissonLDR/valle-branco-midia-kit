<?php
/**
 * View: grade do mídia kit.
 *
 * Variáveis: $args, $items, $columns
 *
 * @package ValleBrancoMidiaKit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$extra   = ! empty( $args['extra_class'] ) ? ' ' . sanitize_html_class( $args['extra_class'] ) : '';
$cols_cl = ' vb-mk--cols-' . (int) $columns;
?>
<section class="vb-mk<?php echo esc_attr( $cols_cl . $extra ); ?>">
	<?php if ( ! empty( $args['show_heading'] ) ) : ?>
		<header class="vb-mk__intro">
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
		</header>
	<?php endif; ?>

	<ul class="vb-mk__grid">
		<?php foreach ( $items as $item ) : ?>
			<li class="vb-mk__item">
				<figure class="vb-mk__figure">
					<?php if ( ! empty( $item['thumb_id'] ) ) : ?>
						<?php
						echo wp_get_attachment_image( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							$item['thumb_id'],
							'large',
							false,
							array(
								'class'    => 'vb-mk__img',
								'loading'  => 'lazy',
								'alt'      => $item['nome'],
							)
						);
						?>
					<?php else : ?>
						<div class="vb-mk__placeholder" aria-hidden="true"></div>
					<?php endif; ?>
				</figure>
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
							<?php esc_html_e( 'Baixar imagem', 'valle-branco-midia-kit' ); ?>
						</a>
					<?php endif; ?>
				</div>
			</li>
		<?php endforeach; ?>
	</ul>
</section>
