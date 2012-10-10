<?php
/**
* class exist check
*/
if (!class_exists('rcmd_plugin')) {
	class rcmd_plugin {

function __construct() {
	add_action('wp_head', array( &$this, 'basic_tag' ) );
	add_filter( 'the_content', array( &$this, 'rcmd_filter' ) );
	add_shortcode('rcmd_ranking', array( &$this, 'rcmd_ranking_sc' ) );
	add_shortcode('rcmd_recommend', array( &$this, 'rcmd_recommend_sc' ) );
	add_shortcode('rcmd_history', array( &$this, 'rcmd_history_sc' ) );
}

//レコメンド位置
function rcmd_filter($content) {

	//データベースから設定値を全部読み込み
	$opt_val = get_option( 'rcmd_opt' );

	$recommend_tmp = $opt_val['recommend_tmp'];
	$history_tmp = $opt_val['history_tmp'];
	$ranking_span = $opt_val['ranking_span'];
	$ranking_type = $opt_val['ranking_type'];
	$ranking_tmp = $opt_val['ranking_tmp'];

//レコメンドタグ定義



//履歴タグ
$history_tag	= "<script type=\"text/javascript\">
<!--
try{
  _rcmdjp._displayHistory({
    code: '" . get_the_ID() . "',
    template: '$history_tmp'
  });
} catch(err) {}
//-->
</script>";

//レコメンドタグ
$recommend_tag	= "<script type=\"text/javascript\">
<!--
try{
  _rcmdjp._displayRecommend({
    code: '" . get_the_ID() . "',
    template: '$recommend_tmp'
  });
} catch(err) {}
//-->
</script>";

//ランキングタグ
$ranking_tag	= "<script type=\"text/javascript\">
<!--
try{
  _rcmdjp._displayRanking({
    span: '$ranking_span',
    type: '$ranking_type',
    template: '$ranking_tmp'
  });
} catch(err) {}
_rcmdjp._trackRecommend();
//-->
</script>";

	//記事の上に設置
	if ($opt_val['history_position'] == "1"){
		$content = $history_tag . $content;
	}
	//記事の下に設置
	if ($opt_val['history_position'] == "2"){
		$content = $content . $history_tag;
	}
	//記事の両方に設置
	if ($opt_val['history_position'] == "3"){
		$content = $history_tag . $content . $history_tag;
	}

	if ($opt_val['ranking_position'] == "1"){
		$content = $ranking_tag . $content;
	}

	if ($opt_val['ranking_position'] == "2"){
		$content = $content . $ranking_tag;
	}

	if ($opt_val['ranking_position'] == "3"){
		$content = $ranking_tag . $content . $ranking_tag;
	}

	if ($opt_val['recommend_position'] == "1"){
		$content = $recommend_tag . $content;
	}

	if ($opt_val['recommend_position'] == "2"){
		$content = $content . $recommend_tag;
	}

	if ($opt_val['recommend_position'] == "3"){
		$content = $recommend_tag . $content . $recommend_tag;
	}

	return $content;

add_filter( 'the_content', array( &$this, 'rcmd_filter' ) );

}

//ショートコード作成 ranking
function rcmd_ranking_sc($atts) {

	//データベースから読み込み
	$opt_val = get_option( 'rcmd_opt' );

	extract(shortcode_atts(array(
		'id' => $opt_val['rcmd_id'],
		'span' => $opt_val['ranking_span'],
		'type' => $opt_val['ranking_type'],
		'tmp'  => $opt_val['ranking_tmp'],
		), $atts));

	$data = "<script type=\"text/javascript\">
	<!--
	try{
	  _rcmdjp._displayRanking({
	    span: '$span',
	    type: '$type',
	    template: '$tmp'
	  });
	} catch(err) {}
	_rcmdjp._trackRecommend();
	//-->
	</script>";

	return $data;
}

//ショートコード作成 recommend
function rcmd_recommend_sc($atts) {

	//データベースから読み込み
	$opt_val = get_option( 'rcmd_opt' );
	
	extract(shortcode_atts(array(
		'id' => $opt_val['rcmd_id'],
		'code' => get_the_ID(),
		'tmp'  => $opt_val['recommend_tmp'],
		), $atts));

	$data = "<script type=\"text/javascript\">
	<!--
	try{
	  _rcmdjp._displayRecommend({
	    code: '$code',
	    template: '$tmp'
	  });
	} catch(err) {}
	//-->
	</script>";

	return $data;
}





//ショートコード作成 history
function rcmd_history_sc($atts) {

	//データベースから読み込み
	$opt_val = get_option( 'rcmd_opt' );
	
	extract(shortcode_atts(array(
		'id' => $opt_val['rcmd_id'],
		'code' => get_the_ID(),
		'tmp'  => $opt_val['history_tmp'],
		), $atts));

	$data = "<script type=\"text/javascript\">
	<!--
	try{
	  _rcmdjp._displayHistory({
	    code: '$code',
	    template: '$tmp'
	  });
	} catch(err) {}
	//-->
	</script>";

	return $data;
}

//基本タグと収集タグを設定
function basic_tag(){
	if( !is_preview() ){

		//データベースから読み込み
		$opt_val = get_option( 'rcmd_opt' );

		echo "\n<!-- Recommend basic_tag -->
<script type=\"text/javascript\">
<!--
if (!window._rcmdjp) document.write(unescape(\"%3Cscript src='\" + document.location.protocol + \"//d.rcmd.jp/" . $opt_val['rcmd_id'] . "/item/recommend.js' type='text/javascript' charset='UTF-8'%3E%3C/script%3E\"));
//--></script>
<!-- Recommend basic_tag END -->\n";

		//▼レコメンド用画像取得スクリプト▼
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
					//データベースから読み込み
					$opt_val = get_option( 'rcmd_opt' );

					$set_img = $opt_val['thumb']; //noimage画像のパスを指定
				}
				return $set_img;
			}
		}
		//▲レコメンド用画像取得スクリプト▲

		//アイテム取得
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

add_action('wp_head', array( &$this, 'basic_tag' ) );

	}


}


	}

}



/*クラス定義*/
if (class_exists("rcmd_plugin")) { $rcmd_plugin = new rcmd_plugin(); }

?>