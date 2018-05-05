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
	</head>
	<body>
		<h1>HTML Media Capture Sample Upload</h1>
<?php
if (is_uploaded_file($_FILES["capture"]["tmp_name"])){
    move_uploaded_file($_FILES["capture"]["tmp_name"], $_FILES["capture"]["name"]);
    echo "upload success<br />";
    echo '<a class="btn btn-link" target="_blank" href="'. $_FILES["capture"]["name"] . '">view file</a><br />';
}else{
    echo "no upload file<br />";
}
?>
	</body>
</html>
