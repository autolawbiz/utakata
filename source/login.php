<?php
require 'db.php';
// セッション開始
session_start();

// エラーメッセージの初期化
$errorMessage = "";

// ログインボタンが押された場合
if (isset($_POST["login"])) {
	// 1. ユーザIDの入力チェック
	if (empty($_POST["userid"])) {  // emptyは値が空のとき
		$errorMessage = 'ユーザーIDが未入力です。';
	} else if (empty($_POST["password"])) {
		$errorMessage = 'パスワードが未入力です。';
	}

	if (!empty($_POST["userid"]) && !empty($_POST["password"])) {
		// 入力したユーザIDを格納
		$userid = $_POST["userid"];

		// 2. ユーザIDとパスワードが入力されていたら認証する
		$dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8', $db['host'], $db['dbname']);

		// 3. エラー処理
		try {
			$pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));

			$stmt = $pdo->prepare('SELECT * FROM userData WHERE name = ?');
			$stmt->execute(array($userid));

			$password = $_POST["password"];

			if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				if (password_verify($password, $row['password'])) {
					session_regenerate_id(true);

					// 入力したIDのユーザー名を取得
					$id = $row['id'];
					$sql = "SELECT * FROM userData WHERE id = $id";  //入力したIDからユーザー名を取得
					$stmt = $pdo->query($sql);
					foreach ($stmt as $row) {
						$row['name'];  // ユーザー名
					}
					$_SESSION["NAME"] = $row['name'];
					header("Location: index.php");  // メイン画面へ遷移
					exit();  // 処理終了
				} else {
					// 認証失敗
					$errorMessage = 'ユーザーIDあるいはパスワードに誤りがあります。';
				}
			} else {
				// 4. 認証成功なら、セッションIDを新規に発行する
				// 該当データなし
				$errorMessage = 'ユーザーIDあるいはパスワードに誤りがあります。';
			}
		} catch (PDOException $e) {
			$errorMessage = 'データベースエラー';
			//$errorMessage = $sql;
			// $e->getMessage() でエラー内容を参照可能（デバッグ時のみ表示）
			// echo $e->getMessage();
		}
	}
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
            <?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?>
			<form id="loginForm" name="loginForm" action="" method="post">
				<div class="form-group">
					<input type="text" class="form-control" id="userid" name="userid" placeholder="ユーザ名" value="">
				</div>
				<div class="form-group">
					<input type="password" class="form-control" id="password" name="password" value="" placeholder="パスワード">
				</div>
                <p><button type="submit" class="btn btn-primary" id="login" name="login">ログイン</button></p>
			</form>
            <p><a class="btn btn-primary" href="register.php">新規ユーザ登録画面へ</a></p>
		</div>
	</body>
</html>
