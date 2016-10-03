<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$twitter_handle = get_option( 'son-of-gifv-twitter-handle' );
?>
<meta name="twitter:card"                       content="player" />
<meta name="twitter:domain"                     content="<?php echo esc_attr( $gifv_data['domain'] ); ?>" />
<meta name="twitter:url"                        content="<?php echo esc_attr( $gifv_data['permalink'] ); ?>" />
<meta name="twitter:title"                      content="<?php echo esc_attr( get_the_title() ); ?>" />
<meta name="twitter:description"                content="<?php echo esc_attr( $gifv_data['caption'] ); ?>" />
<meta name="twitter:image"                      content="<?php echo esc_attr( $gifv_data['thumbnail_url'] ); ?>" />
<meta name="twitter:player"                     content="<?php echo esc_attr( $gifv_data['permalink'] ); ?>" />
<meta name="twitter:player:width"               content="<?php echo esc_attr( $gifv_data['attachment_width'] ); ?>" />
<meta name="twitter:player:height"              content="<?php echo esc_attr( $gifv_data['attachment_height'] ); ?>" />
<meta name="twitter:player:stream"              content="<?php echo esc_attr( $gifv_data['mp4_url'] ); ?>" />
<meta name="twitter:player:stream:content_type" content="video/mp4" />
<?php if ( ! empty( $twitter_handle ) ) : ?>
<meta name="twitter:site"                       content="<?php echo esc_attr( '@' . $twitter_handle ); ?>" />
<?php endif; ?>