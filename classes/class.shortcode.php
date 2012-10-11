<?php

//Create Short Code ranking
function rcmd_ranking_sc($atts) {

	//Read Database
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

//Create Short Code recommend
function rcmd_recommend_sc($atts) {

	//Read Database
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


//Create Short Code history
function rcmd_history_sc($atts) {

	//Read Database
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

?>