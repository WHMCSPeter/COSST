<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>SHA1 Encrypter</title>
</head>

<body>
<?php
if(isset($_GET['string'])) {
	echo '<p>Encrypted '.$_GET['string'].': <br /><br />';
	echo '<strong>'.sha1($_GET['string']).'</strong></p>';
}
?>

<form action="sha1_encrypter.php" method="get">
<input type="text" name="string" placeholder="Text to Encrypt" />
<input type="submit" />
</form>

</body>
</html>