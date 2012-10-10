<?php
	//初期値設定
	$opt_val = array();
/*
	$opt_val = array(
		"rcmd_id"		=> "",
		"thumb"			=> "",
		"recommend_tmp"		=> "wp-recommend",
		"recommend_position"	=> 0,
		"history_tmp"		=> "wp-history",
		"history_position"	=> 0,
		"ranking_span"		=> "week",
		"ranking_type"		=> "pv",
		"ranking_tmp"		=> "wp-ranking",
		"ranking_position"	=> 0
	);
*/

	// データベースから既存の設定値を読み込む
	if( isset( $opt_val ) ){
		$opt_val = get_option( 'rcmd_opt' );
	} 

	//初期値設定
	if($opt_val['recommend_tmp'] ==""){ $opt_val['recommend_tmp'] = "wp-recommend"; }
	if($opt_val['recommend_position'] ==""){ $opt_val['recommend_position'] = 0; }
	if($opt_val['history_tmp'] ==""){ $opt_val['history_tmp'] = "wp-history"; }
	if($opt_val['history_position'] ==""){ $opt_val['history_position'] = 0; }
	if($opt_val['ranking_span'] ==""){ $opt_val['ranking_span'] = "week"; }
	if($opt_val['ranking_type'] ==""){ $opt_val['ranking_type'] = "pv"; }
	if($opt_val['ranking_tmp'] ==""){ $opt_val['ranking_tmp'] = "wp-ranking"; }
	if($opt_val['ranking_position'] ==""){ $opt_val['ranking_position'] = 0; }

/*
	if( isset( $opt_val ) ){
		$opt_val = get_option( 'rcmd_opt' );
	} 
*/

//	$opt_val['rcmd_id'] = get_option( 'rcmd_id' );
//	$opt_val['post_align'] = get_option( 'post_align' );


        // 送信ボタンを押したときの処理
	if ( isset( $_POST['rcmd_submit'] ) ) {
		//レコメンドのオプションのフォームから値を投稿されているかチェック
		check_admin_referer("rcmd_options" , "rcmd_submit_wpnonce" ); 
		
		//投稿されたデータを取得&エスケープ)
	        $opt_val['rcmd_id']		= stripslashes( $_POST['rcmd_id'] );
	        $opt_val['thumb']		= stripslashes( clean_url( $_POST['thumb'] ) );
		$opt_val['recommend_tmp']	= stripslashes( $_POST['recommend_tmp'] );
	        $opt_val['recommend_position']	= intval( $_POST['recommend_position'] );
		$opt_val['history_tmp']		= stripslashes( $_POST['history_tmp'] );
	        $opt_val['history_position']	= intval( $_POST['history_position'] );
		$opt_val['ranking_span']	= stripslashes( $_POST['ranking_span'] );
		$opt_val['ranking_type']	= stripslashes( $_POST['ranking_type'] );
		$opt_val['ranking_tmp']		= stripslashes( $_POST['ranking_tmp'] );
	        $opt_val['ranking_position']	= intval( $_POST['ranking_position'] );

		//データベース更新
//       		update_option( 'rcmd_id', $opt_val['rcmd_id'] );
//       		update_option( 'post_align', $opt_val['post_align'] );
       		update_option( 'rcmd_opt', $opt_val );

//デバッグ用
//		$opt_val = delete_option( 'rcmd_opt' );


	// 画面に更新されたことを伝えるメッセージを表示

?>
	<div class="updated"><p><strong>保存されました。</strong></p></div>
	<?php } ?>

	<form name="form1" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
	<?php wp_nonce_field( "rcmd_options" , "rcmd_submit_wpnonce" ); ?>

	<div class="wrap">
	<h2>レコメンドエンジン設定画面</h2>
	<h3>基本情報</h3>
	<table class="form-table">
		<tbody>
			<tr valign="top">
				<th scome="row">レコメンドID</th>
				<td><input type="text" name="rcmd_id" value="<?php echo esc_attr( $opt_val['rcmd_id'] ); ?>" size="20"></td>
			</tr>
		</tbody>
	</table>

	<h3>アイテム収集</h3>
	<table class="form-table">
		<tbody>
			<tr valign="top">
				<th scome="row">コード</th>
				<td>投稿のIDを自動取得</td>
			</tr>
			<tr valign="top">
				<th scome="row">URL</th>
				<td>投稿のURLを自動取得</td>
			</tr>
			<tr valign="top">
				<th scome="row">タイトル</th>
				<td>投稿のタイトルを自動取得</td>
			</tr>
			<tr valign="top">
				<th scome="row">画像URL:フルパスで指定</th>
				<td><input type="text" name="thumb" value="<?php echo clean_url( $opt_val['thumb'] ); ?>" size="60"><br />アイキャッチ・投稿の第一画像がない場合に取得させます</td>
			</tr>
		</tbody>
	</table>

	<h3>レコメンド</h3>

	<table class="form-table">
		<tbody>
			<tr valign="top">
				<th scome="row">コード</th>
				<td>投稿のIDを自動取得</td>
			</tr>
			<tr valign="top">
				<th scome="row">テンプレート名</th>
				<td><input type="text" name="recommend_tmp" value="<?php echo esc_attr( $opt_val['recommend_tmp'] ); ?>" size="20"></td>
			</tr>
			<tr valign="top">
				<th scome="row">表示位置</th>
				<td>
					<input type="radio" name="recommend_position" value="0" <?php if ($opt_val['recommend_position'] == "0") {echo 'checked="checked"';} ?>>なし
					<input type="radio" name="recommend_position" value="1" <?php if ($opt_val['recommend_position'] == "1") {echo 'checked="checked"';} ?>>上
					<input type="radio" name="recommend_position" value="2" <?php if ($opt_val['recommend_position'] == "2") {echo 'checked="checked"';} ?>>下
					<input type="radio" name="recommend_position" value="3" <?php if ($opt_val['recommend_position'] == "3") {echo 'checked="checked"';} ?>>両方
				</td>
			</tr>
		</tbody>
	</table>

	<h3>ランキング</h3>

	<table class="form-table">
		<tbody>
			<tr valign="top">
				<th scome="row">間隔</th>
				<td><input type="text" name="ranking_span" value="<?php echo esc_attr( $opt_val['ranking_span'] ); ?>" size="20"></td>
			</tr>
			<tr valign="top">
				<th scome="row">タイプ</th>
				<td><input type="text" name="ranking_type" value="<?php echo esc_attr( $opt_val['ranking_type'] ); ?>" size="20"></td>
			</tr>
			<tr valign="top">
				<th scome="row">テンプレート名</th>
				<td><input type="text" name="ranking_tmp" value="<?php echo esc_attr( $opt_val['ranking_tmp'] ); ?>" size="20"></td>
			</tr>
			<tr valign="top">
				<th scome="row">表示位置</th>
				<td>
					<input type="radio" name="ranking_position" value="0" <?php if ($opt_val['ranking_position'] == "0") {echo 'checked="checked"';} ?>>なし
					<input type="radio" name="ranking_position" value="1" <?php if ($opt_val['ranking_position'] == "1") {echo 'checked="checked"';} ?>>上
					<input type="radio" name="ranking_position" value="2" <?php if ($opt_val['ranking_position'] == "2") {echo 'checked="checked"';} ?>>下
					<input type="radio" name="ranking_position" value="3" <?php if ($opt_val['ranking_position'] == "3") {echo 'checked="checked"';} ?>>両方
				</td>
			</tr>
		</tbody>
	</table>

	<h3>履歴</h3>
	<table class="form-table">
		<tbody>
			<tr valign="top">
				<th scome="row">コード</th>
				<td>投稿のIDを自動取得</td>
			</tr>
			<tr valign="top">
				<th scome="row">テンプレート名</th>
				<td><input type="text" name="history_tmp" value="<?php echo esc_attr( $opt_val['history_tmp'] ); ?>" size="20"></td>
			</tr>
			<tr valign="top">
				<th scome="row">表示位置</th>
				<td>
					<input type="radio" name="history_position" value="0" <?php if ($opt_val['history_position'] == "0") {echo 'checked="checked"';} ?>>なし
					<input type="radio" name="history_position" value="1" <?php if ($opt_val['history_position'] == "1") {echo 'checked="checked"';} ?>>上
					<input type="radio" name="history_position" value="2" <?php if ($opt_val['history_position'] == "2") {echo 'checked="checked"';} ?>>下
					<input type="radio" name="history_position" value="3" <?php if ($opt_val['history_position'] == "3") {echo 'checked="checked"';} ?>>両方
				</td>
			</tr>
		</tbody>
	</table>

	<p class="submit"><input type="submit" class="button-primary" name="rcmd_submit" value="Update Options" /></p>
	</form>

<hr />

	<h3>ショートコードを使ってどこにでも表示</h3>
	<p>投稿や固定ページ以外の場所（テーマファイルなど）にレコメンドを表示させることができます。</p>
	<table class="form-table">
		<tbody>
			<tr valign="top">
				<th scome="row">レコメンド [rcmd_recommend]</th>
				<td>ex. [rcmd_recommend code="1234" tmp="recommend"]</td>
			</tr>
			<tr valign="top">
				<th scome="row">ランキング [rcmd_ranking]</th>
				<td>ex. [rcmd_ranking span="week" type="pv" tmp="ranking"]</td>
			</tr>
			<tr valign="top">
				<th scome="row">閲覧履歴 [rcmd_history]</th>
				<td>ex. [rcmd_history code="1234" tmp="history" ]</td>
		</tbody>
	</table>

	<h3>パラメーターの設定</h3>
	<p>表示タイプを変更したい場合は、パラメータを設定してください。</p>
	<p>※ショートコードはWordPressループ内での使用をお願いします。</p>
	<table class="form-table">
		<tbody>
			<tr valign="top">
				<th scome="row">code</th>
				<td>コード</td>
			</tr>
			<tr valign="top">
				<th scome="row">tmp</th>
				<td>テンプレート名</td>
			</tr>
			<tr valign="top">
				<th scome="row">span</th>
				<td>間隔(week,month,day)</td>
			</tr>
			<tr valign="top">
				<th scome="row">type</th>
				<td>表示タイプ(pv)</td>
			</tr>
		</tbody>
	</table>
</div>
