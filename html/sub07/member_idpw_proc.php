<?
	include "../../include/global/config.php"; 
	include "../../include/global/sendmail.class.php"; 
	
	$modeType	= trim($_POST['modeType']);
	$mbName		= trim($_POST['mbName']);
	$mbJumin		= trim($_POST['mbJumin1'])."-".trim($_POST['mbJumin2']);
	$mbId			= trim($_POST['mbId']);		
	$mbEmail		= trim($_POST['mbEmail']);

	if( $modeType == "id" ){

		$name	= trim($_POST['name']);			
		
		$query = "SELECT mbId FROM ona_member WHERE mbName='".$mbName."' && mbJumin='".$mbJumin."' && mbStatus != 'C'";
		$result	= mysql_query($query);
		$row		= mysql_fetch_array($result);

		if($row[mbId]){
			echo "<script>
					  <!--
						f = parent.idSearchFrm;
						f.mbName.value = '';
						f.mbJumin1.value = '';
						f.mbJumin2.value = '';
						f.mbName.focus();
						parent.popInfo('$row[mbId]','popup_id');						
					  -->
				      </script>";
		}else{
			echo "<script>					
					  <!--
						f = parent.idSearchFrm;
						alert('입력하신 정보가 일치하지 않습니다.');
						f.mbName.value = '';
						f.mbJumin1.value = '';
						f.mbJumin2.value = '';
						f.mbName.focus();
					  //-->
					  </script>";
		}
		
	}else{		

		$query = "SELECT mbId, mbName, mbPwd, mbEmail FROM ona_member WHERE mbId='".$mbId."' && mbJumin='".$mbJumin."' && mbEmail='".$mbEmail."' and mbStatus != 'C'";
		$result	= mysql_query($query);
		$row		= mysql_fetch_array($result);

		if($row[mbId]){

			$mailFile		 = "password_email.html";
			$mailContent = join ('', file ($mailFile));
			$mailContent = str_replace("{host}", $INFO[url], $mailContent);
			$mailContent = str_replace("{mbId}", $row[mbId], $mailContent);
			$mailContent = str_replace("{mbPwd}", $row[mbPwd], $mailContent);


			$email_title = "[ ".$INFO[company]." ] ".$row[mbName]."님의 아이디/패스워드 입니다.";
			$email_content = $mailContent;

			$dMail = new Sendmail; 
			$dMail->setUseSMTPServer(true);
			$dMail->setFrom($INFO[email], $INFO[company]); 
			$dMail->setSubject($email_title); 
			$dMail->setMailBody($email_content, true); 
			$dMail->addTo($row[mbEmail], $row[mbName]); 
			$dMail->send(); 

			echo "<script>
					  <!--
						f = parent.idPwdFrm;
						f.mbId.value = '';
						f.mbJumin1.value = '';
						f.mbJumin2.value = '';
						f.mbEmail.value = '';
						f.mbId.focus();
						alert('회원가입시 입력하신 이메일로 전송되었습니다.');
					  -->
				      </script>";		
		}else{
			echo "<script>					
					  <!--
						f = parent.idPwdFrm;
						alert('입력하신 정보가 일치하지 않습니다.');
						f.mbId.value = '';
						f.mbJumin1.value = '';
						f.mbJumin2.value = '';
						f.mbEmail.value = '';
						f.mbId.focus();
					  //-->
					  </script>";
		}

	}
?>