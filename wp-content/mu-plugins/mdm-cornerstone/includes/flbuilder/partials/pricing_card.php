<div class="pricing_card <?php echo $card->card_style_class ?>">
	<header class="pricing_card_header">
		<?php if( !empty( $card->title ) ) : ?>
			<span class="pricing_card_heading"><?php echo $card->title; ?></span>
		<?php endif; ?>

		<?php if( !empty( $card->header_content ) ) : ?>
			<div class="pricing_card_header_content">
				<?php echo $card->header_content; ?>
			</div>
		<?php endif; ?>

		<?php if( !empty( $card->price ) ) : ?>
			<div class="pricing_card_price">
				<?php if( !empty( $card->price_unit ) ) : ?>
					<sup><?php echo $card->price_unit; ?></sup>
				<?php endif; ?>
				<span class="price"><?php echo $card->price; ?></span>
				<small><?php echo $card->price_duration; ?></small>
			</div>
		<?php endif; ?>
	</header>
	<?php if( !empty( $card->body_content ) ) : ?>
		<div class="pricing_card_body">
			<?php echo $card->body_content; ?>
		</div>
	<?php endif; ?>
</div>
