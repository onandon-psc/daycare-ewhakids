<?
	include $_SERVER['DOCUMENT_ROOT']."/include/global/config.php";

	function ChkNickName($mbNick)
	{
		// �г��� �ߺ�üũ
		$query	= "SELECT count(*) FROM $tableName WHERE mbNick='".$mbNick."'";
		$result	= mysql_query($query);
		$row		= mysql_fetch_array($result);
		if($row[0]>0){
			echo"<script>
						alert('�̹� ��ϵ� �г����Դϴ�.');
					 </script>";
			exit;
		}
	}

	if($mode=="after_proc"){
		$str["write_ok"] = "<script>";
		$str["write_ok"] .= "alert('ȸ������ �Ǿ����ϴ�.');";
		$str["write_ok"] .= "parent.locationFrm.pno.value			= '070203';";
		$str["write_ok"] .= "parent.locationFrm.mbId.value		= '$mbId';";
		$str["write_ok"] .= "parent.locationFrm.mbPwd.value	= '$mbPwd';";
		$str["write_ok"] .= "parent.locationFrm.mbName.value	= '$mbName';";
		$str["write_ok"] .= "parent.locationFrm.action				= '/html/sub/index.php';";
		$str["write_ok"] .= "parent.locationFrm.submit();";
		$str["write_ok"] .= "</script>";

		$str["modify_ok"] = "<script>";
		$str["modify_ok"] .= "alert('ȸ�������� ���� �Ǿ����ϴ�.');";
		$str["modify_ok"] .= "parent.location.reload();";
		$str["modify_ok"] .= "</script>";
		echo $str[$result];
		exit;
	}

	$tableName	 = "ona_member";
	$tableName2 = "ona_member_family";

	$mbRegdate			= mktime();	
	$mode					= trim($_POST['mode']);
	$mbId					= trim($_POST['mbId']);
	$mbPwd				= trim($_POST['mbPwd']);
	$mbPwd2				= trim($_POST['mbPwd2']);
	$mbName				= trim($_POST['mbName']);

	//$mbJumin				= trim($_POST['mbJumin1'])."-".trim($_POST['mbJumin2']);
	$jumin1 = substr($birth1,2,2).$birth2.$birth3;

	$jumin2 = trim($_POST['sex']);

	if($birth1 > 1999)
	{
		$jumin2 = $jumin2+2;
	}
	$mbJumin				= $jumin1."-".$jumin2;

	$mbEmail				= trim($_POST['mbEmail1']).'@'.trim($_POST['mbEmail2']);
	$mbGroup				= trim($_POST['mbGroup']);
	/*
	$mbNick				= trim($_POST['mbNick']);	
	$mbNickOld			= trim($_POST['mbNickOld']);
	*/

	switch ($mode){

		case "write":			

			// �ֹε�Ϲ�ȣ �ߺ�üũ
			/*$query	= "SELECT count(*) FROM $tableName WHERE mbJumin='".$mbJumin."' && mbStatus!='C'";
			$result	= mysql_query($query);
			$row		= mysql_fetch_array($result);
			if($row[0]>0){
				echo"<script>
							alert('�̹� ��ϵ� �ֹε�Ϲ�ȣ�Դϴ�.');
						 </script>";
				exit;
			}*/
			
			$query	= "SELECT count(*) FROM $tableName WHERE mbEmail='".$mbEmail."' && mbStatus!='C'";
			$result	= mysql_query($query);
			$row		= mysql_fetch_array($result);
			if($row[0]>0){
				echo"<script>
							alert('�̹� ��ϵ� �����ּ��Դϴ�.');
						 </script>";
				exit;
			}

			// �г��� �ߺ�üũ
			//ChkNickName($mbNick);

			if( $mbId && $mbPwd && $mbJumin ){
				$tmpchk = mysql_fetch_array(mysql_query("select count(*) from ona_member where mbId = '$mbId' and mbStatus != 'C'"));
				if($tmpchk[0]>0){
					echo"<script>
								alert('�̹� ó�� �Ǿ����ϴ�.');
							 </script>";
					exit;
				}

				$tmpchk = mysql_fetch_array(mysql_query("select count(*) from ona_member_family where mbId = '$mbId' and mbStatus != 'C'"));
				if($tmpchk[0]>0){
					echo"<script>
								alert('�̹� ó�� �Ǿ����ϴ�.');
							 </script>";
					exit;
				}				

				//mbStatus - R : ��ȸ�� / Y : ��ȸ�� / C :ȸ��Ż��

				$query = "INSERT INTO $tableName (
									 mbId , mbName , mbJumin , mbPwd , mbEmail , 
									 mbGroup , mbNick, mbStatus , mbRegdate
							   ) VALUES (
									'$mbId', '$mbName', '$mbJumin', '$mbPwd', '$mbEmail', 
									'$mbGroup', '$mbNick', 'R', '$mbRegdate'
							   )";

				mysql_query($query);		

				// �ڳ�
				if ($childName) {
					foreach ($childName as $k=>$vArr) {
						if(trim($childName[$k])){
							$query = "INSERT INTO $tableName2 ( 
											  mbId, childName, childBirth
										   ) VALUES ( 
											 '$mbId', '$childName[$k]', '$childBirth[$k]'
										   )";
							mysql_query($query);
						}
					}
				}
			}
			break;
		
		case "modify":
			
			// �г��� �ߺ�üũ
			//if($mbNickOld != $mbNick) ChkNickName($mbNick);

			$query = "SELECT count(*) FROM ona_member WHERE mbId='".$mbId."' && mbPwd='".$mbPwd."' and mbStatus!='C'";
			$result	= mysql_query($query);
			$row		= @mysql_fetch_array($result);

			if($row[0]>0){					

				$setAdd = "";

				if($mbPwd2) $setAdd = ", mbPwd='$mbPwd2'"; 

				$query = "UPDATE $tableName SET 
									mbEmail='$mbEmail'
									, mbGroup='$mbGroup'								
									, mbNick='$mbNick'								
									$setAdd
								WHERE mbId='".$mbId."' and mbStatus !='C'";

					mysql_query($query);					
					
					// �ڳ����
					$query = "DELETE FROM $tableName2 WHERE mbId='$mbId'";
					mysql_query($query);

					if ($childName) {
						foreach ($childName as $k=>$vArr) {
							if(trim($childName[$k])){
								$query = "INSERT INTO $tableName2 ( 
												  mbId, childName, childBirth
											   ) VALUES ( 
												 '$mbId', '$childName[$k]', '$childBirth[$k]'
											   )";
								mysql_query($query);
							}
						}
					}
			}else{
				echo "<script>						
							alert('��й�ȣ�� ��ġ���� �ʽ��ϴ�.');
						  </script>";
				exit;
			}
			break;

			case "modify2":
			
			// �г��� �ߺ�üũ
			//if($mbNickOld != $mbNick) ChkNickName($mbNick);

			$query = "SELECT count(*) FROM ona_member WHERE mbId='".$mbId."' && mbPwd='".$mbPwd."' and mbStatus!='C'";
			$result	= mysql_query($query);
			$row		= @mysql_fetch_array($result);

			if($row[0]>0){					

				$setAdd = "";

				if($mbPwd2) $setAdd = ", mbPwd='$mbPwd2'"; 

				$query = "UPDATE $tableName SET
									mbName='$mbName'
									, mbEmail='$mbEmail'
									, mbGroup='$mbGroup'								
									, mbNick='$mbNick'								
									$setAdd
								WHERE mbId='".$mbId."' and mbStatus !='C'";

					mysql_query($query);					
					
					// �ڳ����
					$query = "DELETE FROM $tableName2 WHERE mbId='$mbId'";
					mysql_query($query);

					if ($childName) {
						foreach ($childName as $k=>$vArr) {
							if(trim($childName[$k])){
								$query = "INSERT INTO $tableName2 ( 
												  mbId, childName, childBirth
											   ) VALUES ( 
												 '$mbId', '$childName[$k]', '$childBirth[$k]'
											   )";
								mysql_query($query);
							}
						}
					}
			}else{
				echo "<script>						
							alert('��й�ȣ�� ��ġ���� �ʽ��ϴ�.');
						  </script>";
				exit;
			}
			break;
	}

if($mode=="write") $result = "write_ok";
if($mode=="modify") $result = "modify_ok";
if($mode=="modify2") $result = "modify_ok";
?>
<form name="after_procForm" method="post" action="http://<?=$ret_host?$ret_host:$_SERVER['HTTP_HOST']?><?=$PHP_SELF?>">
	<input type="hidden" name="mode" value="after_proc">
	<input type="hidden" name="result" value="<?=$result?>">
</form>
<script>document.after_procForm.submit();</script>
