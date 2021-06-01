<?
	include $_SERVER['DOCUMENT_ROOT']."/include/global/config.php";
	
	$arrParam = array('send','mbId','childName','childBirth','parentName','class1','class2','class3','homeType','telephone','mobile1','mobile2','mobile3','email1','email2','recordName','recordBirth','sex');

	foreach($arrParam As $val) ${$val} = trim($_POST[$val]);

	$mobile = $mobile1."-".$mobile2."-".$mobile3;
	$email	 = $email1."@".$email2;

	// 관리자는 대기일시를 수정 가능
	if($mbId == 'admin'){
		$regdate = mktime($_REQUEST[regdate_hour],$_REQUEST[regdate_minute],$_REQUEST[regdate_second],$_REQUEST[regdate_month], $_REQUEST[regdate_day], $_REQUEST[regdate_year]);
	}
	else{
		$regdate = mktime();
	}

	$tmp_hometype = explode(",",$homeType);
	$class4 = $tmp_hometype[0];
	
	switch($send){
		case "write":
			if(!$mbId){
				echo "<script>alert('입소신청 되지 않았습니다.');</script>";		
				exit;
			}

			$query = "INSERT INTO ona_application ( 
								mbId , childName , childBirth , parentName , class1 , 
								class2 , class3 , class4 , homeType , telephone , mobile , email , 
								recordName , recordBirth , status , regdate , sex
							) VALUES (
								'$mbId' , '$childName' , '$childBirth' , '$parentName' , '$class1' , 
								'$class2' , '$class3' , '$class4', '$homeType' , '$telephone' , '$mobile' , '$email' , 
								'$recordName' , '$recordBirth' , 'R' , '$regdate' , '$sex'
							)";
			mysql_query($query);
			if($mbId == 'admin'){
				echo"<script>
						alert('입소신청 되었습니다.');
						parent.location.href='/ewhaMaster/sub/index.php?pno=060301';
					 </script>";			
			}
			else{
				echo"<script>
						alert('입소신청 되었습니다.');
						parent.location.href='/html/sub/index.php?pno=060301';
					 </script>";						
			}
			exit;
			break;
		
		case "modify":
			$query = "update `ona_application` set `childName` = '$childName', `childBirth` = '$childBirth', `parentName` = '$parentName', `class1` = '$class1', `class2` = '$class2', `class3` = '$class3', `class4` = '$class4', `homeType` = '$homeType', `telephone` = '$telephone', `mobile` = '$mobile', `email` = '$email', `recordName` = '$recordName', `recordBirth` = '$recordBirth', `status` = 'R', `sex` = '$sex', `waittype` = '$waitType', `position1` = '$position1', `position2` = '$position2' where `idx` = '$_REQUEST[modify_idx]'";

			mysql_query($query);
			if($mbId == 'admin'){
				$query = "update `ona_application` set `regdate` = '$regdate' where `idx` = '$_REQUEST[modify_idx]'";
				mysql_query($query);
			}
			
			if($mbId == 'admin'){
				echo "<script>alert('수정하였습니다.');parent.location = '/ewhaMaster/sub/index.php?pno=060301&childAge=$childAge&page=$page';</script>";
			}
			else{
				echo "<script>alert('수정하였습니다.');parent.location = '/html/sub/index.php?pno=060301&childAge=$childAge&page=$page';</script>";
			}
			exit;
			break;

		case "delete":
			$query = "delete from ona_application where idx = '$idx'";
			mysql_query($query);
			
			if($mbId == 'admin'){
				echo "<script>alert('삭제하였습니다.');parent.location.href('/ewhaMaster/sub/index.php?pno=060301&childAge=$childAge&page=$page');</script>";	
			}
			else
			{
				echo "<script>alert('삭제하였습니다.');parent.location.href('/html/sub/index.php?pno=060301&childAge=$childAge&page=$page');</script>";	
			}
			exit;
			break;
	}
?>