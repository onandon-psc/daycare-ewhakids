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

		// ȸ������ Ż��
		$query  = "UPDATE ona_member SET mbStatus='C' WHERE mbId='".$row[mbId]."'";
		mysql_query($query);

		$query = "DELETE FROM ona_member_family WHERE mbId='".$row[mbId]."'";
		mysql_query($query);
		
	}else{
		echo"<script>
					alert('ȸ�������� ��ġ���� �ʽ��ϴ�.');	
				 </script>";
		exit;
	}	
	
?>
<script language="javascript">
	alert('ȸ��Ż�� �Ǿ����ϴ�.');
	parent.location.href='../sub07/member_logout.php';
</script>