<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<meta property="og:type"         content="video/mp4" />
<meta property="og:type"         content="video.other" />
<meta property="og:video:type"   content="video/mp4" />
<meta property="og:site_name"    content="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" />
<meta property="og:title"        content="<?php echo esc_attr( get_the_title() ); ?>" />
<meta property="og:url"          content="<?php echo esc_url(  $gifv_data['permalink'] ); ?>" />
<meta property="og:description"  content="<?php echo esc_attr( $gifv_data['caption'] ); ?>" />
<meta property="og:image"        content="<?php echo esc_url(  $gifv_data['thumbnail_url'] ); ?>" />
<meta property="og:image:width"  content="<?php echo esc_attr( $gifv_data['attachment_width'] ); ?>" />
<meta property="og:image:height" content="<?php echo esc_attr( $gifv_data['attachment_height'] ); ?>" />
<meta property="og:video"        content="<?php echo esc_url(  $gifv_data['mp4_url'] ); ?>" />
<meta property="og:video:width"  content="<?php echo esc_attr( $gifv_data['attachment_width'] ); ?>" />
<meta property="og:video:height" content="<?php echo esc_attr( $gifv_data['attachment_height'] ); ?>" />
<?php if ( is_ssl() ) : ?>
<meta property="og:image:secure_url" content="<?php echo esc_url(  $gifv_data['thumbnail_url'] ); ?>" />
<meta property="og:video:secure_url" content="<?php echo esc_url(  $gifv_data['mp4_url'] ); ?>" />
<?php endif; ?>
