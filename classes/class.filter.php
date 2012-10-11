<?php
//Recommend Align
function rcmd_filter($content) {

	//Read Database
	$opt_val = get_option( 'rcmd_opt' );

	$recommend_tmp = $opt_val['recommend_tmp'];
	$history_tmp = $opt_val['history_tmp'];
	$ranking_span = $opt_val['ranking_span'];
	$ranking_type = $opt_val['ranking_type'];
	$ranking_tmp = $opt_val['ranking_tmp'];

	//Define Recommend Tag

	//history
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

	//Recommend
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

	//Ranking
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

	//Before
	if ($opt_val['history_position'] == "1"){
		$content = $history_tag . $content;
	}
	//After
	if ($opt_val['history_position'] == "2"){
		$content = $content . $history_tag;
	}
	//Both
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
}

?>