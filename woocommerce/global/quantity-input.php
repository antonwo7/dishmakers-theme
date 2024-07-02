<?php
if ( ! defined( 'ABSPATH' ) ) exit;

if ( $max_value && $min_value === $max_value ) {
	?><div class="quantity hidden"><input type="hidden" id="<?php echo esc_attr( $input_id ); ?>" class="qty" name="<?php echo esc_attr( $input_name ); ?>" value="<?php echo esc_attr( $min_value ); ?>" /></div><?php
} elseif ( ! empty( $max_value ) && ! empty( $step ) ) {
	?><div class="quantity">
		<label class="screen-reader-text" for="<?php echo esc_attr( $input_id ); ?>"><?php esc_html_e( 'Quantity', 'woocommerce' ); ?></label>
		<?php if( is_cart() ):
			echo sprintf( _n( '%d Person', '%d Persons', $input_value * 2, 'woocommerce' ), $input_value * 2 );
		else:?>
			<select name="<?php echo esc_attr( $input_name ); ?>" class="select-css qty" id="<?php echo esc_attr( $input_id ); ?>"><?php
			for ( $i = $min_value; $i <= $max_value; $i = $i + $step ) :
				?><option value="<?php echo absint( $i ) / 2; ?>" <?php selected( $input_value, absint( $i ) / 2 ); ?>><?php echo sprintf( _n( '%d Person', '%d Persons', $i, 'woocommerce' ), $i ); ?></option><?php

				if ( $i == 1 ) $i--;
			endfor;
		?></select>
		<?php endif;?>
	</div><?php
} else {
	?><div class="quantity">
		<label class="screen-reader-text" for="<?php echo esc_attr( $input_id ); ?>"><?php esc_html_e( 'Quantity', 'woocommerce' ); ?></label>
		<input type="number" id="<?php echo esc_attr( $input_id ); ?>" class="input-text qty text" step="<?php echo esc_attr( $step ); ?>" min="<?php echo esc_attr( $min_value ); ?>" max="<?php echo esc_attr( 0 < $max_value ? $max_value : '' ); ?>" name="<?php echo esc_attr( $input_name ); ?>" value="<?php echo esc_attr( $input_value ); ?>" title="<?php echo esc_attr_x( 'Qty', 'Product quantity input tooltip', 'woocommerce' ) ?>" size="4" pattern="<?php echo esc_attr( $pattern ); ?>" inputmode="<?php echo esc_attr( $inputmode ); ?>" aria-labelledby="<?php echo ! empty( $args['product_name'] ) ? sprintf( esc_attr__( '%s quantity', 'woocommerce' ), $args['product_name'] ) : ''; ?>" />
	</div><?php
}
