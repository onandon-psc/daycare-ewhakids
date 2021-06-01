<?
$charType = "no";
$cssType = "no";
$iframeType = "no";
$blurType = "no";
$castleType = "no";
include $_SERVER["DOCUMENT_ROOT"]."/include/global/config.php"; 

if($_POST['M_ID']=="onon" && $_POST['M_PWD']=="nono."){
	session_destroy();
	session_start();
	$_SESSION['onMasterId']		= $_POST['M_ID'];
	echo "<script>parent.location='manager.php';</script>";
}else{
	echo "<script>
			 alert('입력하신 정보가 일치하지 않습니다.');
			 parent.document.thisForm.M_ID.value = '';
			 parent.document.thisForm.M_PWD.value = '';
			 parent.document.thisForm.M_ID.focus();
		  </script>";
}
?>
