<?php
//Recommend Basic Tag & Get Item Tag
function basic_tag(){
	if( !is_preview() ){

		//Read Database
		$opt_val = get_option( 'rcmd_opt' );

		echo "\n<!-- Recommend basic_tag -->
<script type=\"text/javascript\">
<!--
if (!window._rcmdjp) document.write(unescape(\"%3Cscript src='\" + document.location.protocol + \"//d.rcmd.jp/" . $opt_val['rcmd_id'] . "/item/recommend.js' type='text/javascript' charset='UTF-8'%3E%3C/script%3E\"));
//--></script>
<!-- Recommend basic_tag END -->\n";

		//▼Get Thumbnail Script▼
		function rcmd_no_thumb() {

			if( has_post_thumbnail() ) {
				$thumb_id = get_post_thumbnail_id();
				$thumb_url = wp_get_attachment_image_src($thumb_id);
				$thumb_url = $thumb_url[0];
				return $thumb_url;
			} else {
				global $post;
				$set_img = '';
				ob_start();
				ob_end_clean();
				$output = preg_match_all( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches );
				$set_img = $matches[1][0];

				/* if not exist images */
				if( empty( $set_img ) ) {
					//Read Database
					$opt_val = get_option( 'rcmd_opt' );

					$set_img = $opt_val['thumb']; //NoImage URL
				}
				return $set_img;
			}
		}
		//▲Get Thumbnail Script▲

		//Get Item Data
		if( !is_preview() && !is_archive() && !is_home() && !is_page() ){
			echo "\n<!-- Recommend Set Item Data -->
<script type=\"text/javascript\">
<!--
try{
  _rcmdjp._setItemData({
    code:	'" . get_the_ID() . "',
    url:	'" . clean_url( get_permalink() ) . "',
    name:	'" . esc_attr( get_the_title() ) . "',
    image:	'" . clean_url( rcmd_no_thumb() ) . "'
  });
} catch(err) {}
//-->
</script>
<!-- Recommend Set Item Data END-->\n";
		}
	}
}
?>