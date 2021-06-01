<?
if(!in_array($_SERVER["REMOTE_ADDR"],Array("112.218.172.44","127.0.0.1"))) exit;
if($_SESSION['onMasterId']!="onon"){
	echo "<script>top.location.href='/onMaster/login.php';</script>";
	exit;
}
?>