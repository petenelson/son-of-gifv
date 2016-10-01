<?php
// TODO
// <meta name="twitter:site"                       content="@imgur" />
?>
<meta name="twitter:card"                       content="player" />
<meta name="twitter:player:stream:content_type" content="video/mp4">
<meta name="twitter:domain"                     content="<?php echo esc_attr( $gifv_data['domain'] ); ?>" />
<meta name="twitter:title"                      content="<?php echo esc_attr( get_the_title() ); ?>" />
<meta name="twitter:description"                content="<?php echo esc_attr( $gifv_data['caption'] ); ?>" />
<meta name="twitter:image"                      content="<?php echo esc_attr( $gifv_data['thumbnail_url'] ); ?>" />
<meta name="twitter:player"                     content="<?php echo esc_attr( $gifv_data['permalink'] ); ?>?twitter#t" />
<meta name="twitter:player:width"               content="<?php echo esc_attr( $gifv_data['attachment_width'] ); ?>" />
<meta name="twitter:player:height"              content="<?php echo esc_attr( $gifv_data['attachment_height'] ); ?>" />
<meta name="twitter:player:stream"              content="<?php echo esc_attr( $gifv_data['mp4_url'] ); ?>" />
