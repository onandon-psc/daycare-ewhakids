<?
	include $_SERVER['DOCUMENT_ROOT']."/include/global/config.php";	

	if($mode=="after_proc"){
		$str["login_ok"] = "<script>";
		if (!$ret_url) {
			$str["login_ok"] .= "parent.location.href = '/assembly/';";
		} else {
			$str["login_ok"] .= "parent.location.href = '$ret_url';";
		}
		$str["login_ok"] .= "</script>";
		$str["login_fail"] = "<script>
					alert('입력하신 정보가 일치하지 않습니다.');";
		if($ret_login){			
			$str["login_fail"] .= "parent.location.href = '/html/sub/index.php?pno=070101';";
		}

		$str["login_fail"] .= " 
				 </script>";
		echo $str[$result];
		exit;
	}
	$mbId		= trim($_POST['mbId']);
	$mbPwd	= trim($_POST['mbPwd']);
	$ret_url		= trim($_POST['ret_url']);
	$ret_login = trim($_POST['ret_login']);

	if($mbId=="아이디" && $mbPwd=="비밀번호"){
		echo  "<script>
						parent.location.href('/html/sub/index.php?pno=070101');
					</script>";
	}

	$str = "";
	$query = "SELECT mbId, mbName, mbStatus FROM ona_member WHERE mbId='".$mbId."' && mbPwd='".$mbPwd."' && mbStatus!='C'";
	$result = mysql_query($query, $db);			

	if ($row = @mysql_fetch_object($result)){			
		session_register('member_id','member_level','member_name');
		$_SESSION['member_id']				= $row->mbId;		
		$_SESSION['member_level']			= $row->mbStatus;
		$_SESSION['member_name']			= $row->mbName;
		$result = "login_ok";
	}else{
		$result = "login_fail";
	}
?>
<form name="after_procForm" method="post" action="http://<?=$ret_host?$ret_host:$_SERVER['HTTP_HOST']?><?=$PHP_SELF?>">
<input type="hidden" name="mode" value="after_proc">
<input type="hidden" name="result" value="<?=$result?>">
<input type="hidden" name="ret_url" value="<?=$ret_url?>">
<input type="hidden" name="ret_login" value="<?=$ret_login?>">
</form>
<script>
	document.after_procForm.submit();
</script>