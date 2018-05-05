<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>cactusfellow</title>
		<!-- BootstrapのCSS読み込み -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<!-- jQuery読み込み -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<!-- BootstrapのJS読み込み -->
		<script src="js/bootstrap.min.js"></script>
		
		<script type="text/javascript">
            var watchId;
			// 位置情報取得処理に渡すオプション
			var options = {
				// 高精度な位置情報を取得するか(デフォルトはfalse)
				enableHightAccuracy: true,
				// 何秒でタイムアウトとするか(ミリ秒。タイムアウトするとerrorCallback()がコールされる)
				timeout: 120000,
				// 取得した位置情報をキャッシュする時間(ミリ秒。デフォルトは0)
				maximumAge: 0
			}

			// 位置情報取得処理が成功した時にコールされる関数
			// 引数として、coords(coordinates。緯度・経度など)とtimestamp(タイムスタンプ)の2つを持ったpositionが渡される
			function successCallback(position){
				// メッセージを表示
				// document.getElementById("message").innerHTML += "API成功<br />";

				// 引数positionからcoordinates(緯度・経度など)を取り出す
				// ただし、“★必ず取得できる”以外は中身が空っぽの可能性もある

				// 緯度(-180～180度) ★必ず取得できる
				var latitude = position.coords.latitude;

				// 経度(-90～90度) ★必ず取得できる
				var longitude = position.coords.longitude;

				// 高度(m)
				var altitude = position.coords.altitude;

				// 緯度・経度の誤差(m) ★必ず取得できる
				var accuracy = position.coords.accuracy;

				// 高度の誤差(m)
				var altitudeAccuracy = position.coords.altitudeAccuracy;

				// 方角(0～360度)
				var heading = position.coords.heading;

				// 速度(m/秒)
				var speed = position.coords.speed;


				// 引数positionからtimestamp(位置情報を取得した時刻のミリ秒)を取り出す ★必ず取得できる
				var timestamp = position.timestamp;

				// timestampをDate型に変換
				var successDate = new Date(timestamp);

				// メッセージを表示
				// document.getElementById("message").innerHTML += "取得日時：" + successDate.toLocaleString() + "<br />";
				document.getElementById("idoLat").value = latitude;
				document.getElementById("keidoLon").value = longitude;
				// document.getElementById("message").innerHTML += "高度：" + altitude + " m<br />";
				// document.getElementById("message").innerHTML += "緯度・経度の誤差：" + accuracy + " m<br />";
				// document.getElementById("message").innerHTML += "高度の誤差：" + altitudeAccuracy + " m<br />";
				// document.getElementById("message").innerHTML += "方角：" + heading + " 度<br />";
				// document.getElementById("message").innerHTML += "速度：" + speed + " m/秒<br />";

				// 緯度・経度を地図上で確認するためにGoogleMapへのリンクを作成
				document.getElementById("confirm").innerHTML = "<a class='btn btn-primary' target='_blank' href='https://maps.google.co.jp/maps?q=" 
				    + latitude + "," + longitude + "+%28%E7%8F%BE%E5%9C%A8%E4%BD%8D%E7%BD%AE%29&iwloc=A'>Googleマップ確認</a><br /><br />";
			}

			// 位置情報取得処理が失敗した時にコールされる関数
			// 引数として、code(コード)とmessage(メッセージ)の2つを持ったpositionErrorが渡される
			function errorCallback(positionError){

				// メッセージを表示
				document.getElementById("message").innerHTML = "API failed.<br />";


				// 引数positionErrorの中身2つを取り出す

				// コード(1～3のいずれかの値)
				var code = positionError.code;

				// メッセージ(開発者向けデバッグ用メッセージ)
				var message = positionError.message;


				// コードに応じたメッセージを表示
				switch (code) {
					case positionError.PERMISSION_DENIED: // codeが1
						document.getElementById("message").innerHTML += "You do not have permission for Geolocation API.<br />";
						break;

					case positionError.POSITION_UNAVAILABLE: // codeが2
						document.getElementById("message").innerHTML += "Could not determine current location information.<br />";
						break;

					case positionError.TIMEOUT: // codeが3
						document.getElementById("message").innerHTML += "The current location information could not be specified within the specified timeout period.<br />";
						break;
				}

                if (code == 3) {
                    // 開発者向けデバッグ用メッセージを表示
				    document.getElementById("message").innerHTML = "タイムアウトにより測位をストップしました<br />";
                }
			}

			// 位置情報取得開始
			function start(){
				// メッセージ表示領域をクリア
				// document.getElementById("message").innerHTML = "";

				// ブラウザがGeolocation APIに対応しているかをチェック
				if (navigator.geolocation) {
					// 対応している → 位置情報取得開始
					// 位置情報取得成功時にsuccessCallback()、そして取得失敗時にerrorCallback()がコールされる
					// optionsはgetCurrentPosition()に渡す設定値
					//navigator.geolocation.getCurrentPosition(successCallback, errorCallback , options);
                    watchId = navigator.geolocation.watchPosition(successCallback, errorCallback , options);

					// メッセージを表示。↑は非同期処理なので、直ぐにメッセージが表示される
					document.getElementById("message").innerHTML = "測位中...<br />";

				} else {
					// 対応していない → alertを表示するのみ
					//alert("Geolocation not supported in this browser");
					document.getElementById("message").innerHTML = "位置情報は利用できません<br /><br />";
				}
			}

			// 位置情報取得ストップ
			function stop(){
				// メッセージ表示領域をクリア
				// document.getElementById("message").innerHTML = "";

				// ブラウザがGeolocation APIに対応しているかをチェック
				if (navigator.geolocation) {
					// 対応している → 位置情報取得開始
					// 位置情報取得成功時にsuccessCallback()、そして取得失敗時にerrorCallback()がコールされる
					// optionsはgetCurrentPosition()に渡す設定値
					//navigator.geolocation.getCurrentPosition(successCallback, errorCallback , options);
                    //watchId = navigator.geolocation.watchPosition(successCallback, errorCallback , options);
                    navigator.geolocation.clearWatch(watchId);

					// メッセージを表示。↑は非同期処理なので、直ぐにメッセージが表示される
					document.getElementById("message").innerHTML = "測位をストップしました<br />";

				} else {
					// 対応していない → alertを表示するのみ
					//alert("Geolocation not supported in this browser");
					document.getElementById("message").innerHTML = "位置情報は利用できません<br /><br />";
				}
			}
		</script>
	</head>
	<body>
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navigation">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="#">cactusfellow</a>
				</div>
				<div class="collapse navbar-collapse" id="navigation">
<?php
                    if (isset($_SESSION["NAME"])) {
?>
                        <p class="navbar-text navbar-right"><a class="btn btn-primary" href="logout.php">ログアウト</a></p>
<?php
                    } else {
?>
                        <p class="navbar-text navbar-right"><a class="btn btn-primary" href="index.php">トップ画面へ</a></p>
<?php
                    }
?>
				</div>
			</div>
		</nav>
		<div class="container">
<?php
                    if (isset($_SESSION["NAME"])) {
?>
                        <p>ようこそ<?php echo htmlspecialchars($_SESSION["NAME"], ENT_QUOTES); ?>さん</p>  <!-- ユーザー名をechoで表示 -->
                        <form action="upload.php" method="post" enctype="multipart/form-data">
                            <p><button type="button" class="btn btn-primary" onclick="start()">スタート</button>&nbsp;<button type="button" class="btn btn-primary" onclick="stop()">ストップ</button></p>
                            <div id="message"></div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="idoLat" placeholder="緯度">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="keidoLon" placeholder="経度">
                            </div>
                            <div id="confirm"></div>
                            <div class="form-group">
                                <input type="file" class="btn btn-primary" id="capture" name="capture" accept="image/*" capture="camera">				
                            </div>
                            <button type="submit" class="btn btn-primary">位置情報登録</button>
                        </form>
<?php
                    } else {
?>
                        <p>ようこそゲストさん</p>  <!-- ユーザー名をechoで表示 -->
                        <a class="btn btn-primary" href="login.php">ログイン画面へ</a>
<?php
                    }
?>
		</div>
	</body>
</html>
