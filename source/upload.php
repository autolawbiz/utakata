<?php
require 'db.php';
// セッション開始
session_start();

// エラーメッセージ、登録完了メッセージの初期化
$errorMessage = "";
$signUpMessage = "";

if (!empty($_POST["idoLat"]) && !empty($_POST["keidoLon"]) && isset($_SESSION["ID"])) {
    // 入力したユーザIDとパスワードを格納
    if (!empty($_POST["comment"])) {
        $comment = $_POST["comment"];
    } else {
        $comment = "";
    }        
    $idoLat = $_POST["idoLat"];
    $keidoLon = $_POST["keidoLon"];
    $geo = "GeomFromText('POINT(".$idoLat." ".$keidoLon.")')";
    echo $geo."<br />";
    if (is_uploaded_file($_FILES["capture"]["tmp_name"])){
        move_uploaded_file($_FILES["capture"]["tmp_name"], $_FILES["capture"]["name"]);
        $photoFile = $_FILES["capture"]["name"];
        echo "upload success<br />";
        echo '<a class="btn btn-link" target="_blank" href="'. $_FILES["capture"]["name"] . '">view file</a><br />';
    } else {
        $photoFile = "";
        echo "no upload file<br />";
    }
    $userid = $_SESSION["ID"];

    // 2. ユーザIDとパスワードが入力されていたら認証する
    $dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8', $db['host'], $db['dbname']);

    // 3. エラー処理
    //try {
        $pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));

        //$stmt = $pdo->prepare("INSERT INTO utakataTable(comment, geo, file, userid) VALUES (:comment, :geo, :photoFile, :userid)");
        $stmt = $pdo->prepare("INSERT INTO utakataTable(comment, geo, file, userid, lat, lon) VALUES (:comment, ".$geo.", :photoFile, :userid, :lat,  :lon)");

        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
        //$stmt->bindParam(':geo', $geo, PDO::PARAM_STR);
        $stmt->bindParam(':photoFile', $photoFile, PDO::PARAM_STR);
        $stmt->bindParam(':userid', $userid, PDO::PARAM_INT);
        $stmt->bindParam(':lat', $idoLat, PDO::PARAM_STR);
        $stmt->bindParam(':lon', $keidoLon, PDO::PARAM_STR);


        $stmt->execute();

    //    $signUpMessage = '登録が完了しました。あなたの登録IDは '. $userid. ' です。パスワードは '. $password. ' です。';  // ログイン時に使用するIDとパスワード
    //} catch (PDOException $e) {
    //    $errorMessage = 'データベースエラー';
        // $e->getMessage() でエラー内容を参照可能（デバッグ時のみ表示）
        // echo $e->getMessage();
    //}
}
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
                    <p class="navbar-text navbar-right"><a class="btn btn-primary" href="index.php">トップ画面へ</a></p>
				</div>
			</div>
		</nav>
		<div class="container">
            <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
            <div><font color="#0000ff"><?php echo htmlspecialchars($signUpMessage, ENT_QUOTES); ?></font></div>
		</div>
	</body>
</html>
