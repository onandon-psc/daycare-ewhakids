<?
    include "../../include/global/config.php";

	$regdate	= mktime();

	$mbId		= $_POST['mbId'];
	$mbPwd	= $_POST['mbPwd'];
	$contents	= $_POST['contents'];

	$query = "SELECT mbId FROM ona_member WHERE mbId='".$mbId."' && mbPwd='".$mbPwd."' && mbStatus!='C' ";
	$result	= mysql_query($query);
	$row		= mysql_fetch_array($result);
	
	if($row['mbId']){

		$query = "INSERT INTO ona_member_withdraw ( 
							mbId, contents, regdate
						) VALUES (
							'$row[mbId]', '$contents', '$regdate'
						)";	
		mysql_query($query);

		// 회원정보 탈퇴
		$query  = "UPDATE ona_member SET mbStatus='C' WHERE mbId='".$row[mbId]."'";
		mysql_query($query);

		$query = "DELETE FROM ona_member_family WHERE mbId='".$row[mbId]."'";
		mysql_query($query);
		
	}else{
		echo"<script>
					alert('회원정보가 일치하지 않습니다.');	
				 </script>";
		exit;
	}	
	
?>
<script language="javascript">
	alert('회원탈퇴 되었습니다.');
	parent.location.href='../sub07/member_logout.php';
</script>