<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?><div class="son-of-gifv-form-fields">
	<button class="button son-of-gifv-convert" data-id="<?php echo esc_attr( $gifv_data['id'] ); ?>"><?php esc_html_e( 'Convert to GIFV', 'son-of-gifv' ); ?></button>
	<p class="description please-wait hidden"><?php esc_html_e( 'Converting, may take several seconds...', 'son-of-gifv' ); ?> <span class="spinner"></span></p>
	<span class="error-message hidden"></span>
</div>