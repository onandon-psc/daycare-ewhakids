<?
	include "../../include/global/config.php"; 

	$mbId		= $_POST[mbId];
	$mbPwd	= $_POST[mbPwd];
	$newPwd	= $_POST[newPwd];

	$query	= "SELECT count(*) As cnt FROM ona_member WHERE mbId='$mbId' && mbPwd='$mbPwd' && mbStatus='M'";
	$result	= mysql_query($query);
	$row		= mysql_fetch_array($result);

	if($row["cnt"]!="0"){
		$query	= "UPDATE ona_member SET mbPwd='$newPwd' WHERE mbId='$mbId' && mbStatus='M'";
		$result	= mysql_query($query);
		$str = "<script>
					 alert(\"수정 되었습니다.\");
					 parent.location.reload();
				  </script>";
	}
	else{
		$str = "<script>
					 alert(\"기존 비밀번호가 일치하지 않습니다.\");
					 parent.document.thisForm.mbPwd.value = '';
					 parent.document.thisForm.newPwd.value = '';
					 parent.document.thisForm.mbPwd.focus();
				  </script>";
	}
	echo $str;
?>