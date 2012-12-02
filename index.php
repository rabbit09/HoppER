<?php include 'config.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title><?=($JConfig->title);?></title>
		<?php include 'head.php'; ?>
		<?php include 'script.php'; ?>
	</head>

	<body onload="initm();">
		<?php include 'header.php'; ?>
		<?php include 'map.php'; ?>
		<?php include "footer.php"; ?>
	</body>
</html>
