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
                        <a class="btn btn-primary" href="input.php">位置情報登録画面へ</a>
                        <!--ユーザのコンテンツリスト-->
<?php
                    } else {
?>
                        <p>ようこそゲストさん</p>  <!-- ユーザー名をechoで表示 -->
                        <a class="btn btn-primary" href="login.php">ログイン画面へ</a>
                        <!--サイト説明、紹介文、事業理念など-->
<?php
                    }
?>
		</div>
	</body>
</html>
