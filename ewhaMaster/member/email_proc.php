<?
	include "../../include/global/config.php"; 
	include "../../include/global/sendmail.class.php"; 

	$emailType	= $_POST['emailType'];

	$memtype1	= $_POST['memtype1'];
	$search		= $_POST['search'];
	$keyword		= $_POST['keyword'];

	$position		= $_POST['position'];
	$email_title		= $_POST['email_title'];
	$email_content		= $_POST['email_content'];

	// �����η�
	$email_content	 = str_replace('"/include/','"http://'.$_SERVER['HTTP_HOST'].'/include/',$email_content);

	$delValue		= $_POST['delValue'];
	
	$insertQuery = "INSERT INTO email_history (
								idx, title, content, regdate 
							 ) VALUES (
								'', '$email_title', '$email_content', now()
							 )";	
	mysql_query($insertQuery);
	$pidx = mysql_insert_id();
	
	$email_content = stripslashes($email_content);

	
	switch($emailType){
		case "S":	// �˻��� ȸ��
			$position = "�˻���ȸ��";
			if( $memtype1 ) {
				$whereAnd .= " && memtype1='$memtype1' ";
			}
			if($search){
				$whereAnd .= " && ($search like '%$keyword%') ";
			}	
			$count = "0";
			$query	= "SELECT userid,email,name FROM ona_member WHERE mobile!='' and status1!='2' $whereAnd ORDER BY idx DESC";
			$result	= mysql_query($query);			
			while( $row = mysql_fetch_array($result)){
				$insertQuery = "INSERT INTO email_history_member (
											idx, pidx, userid, receive, receivedate
										 ) VALUE (
											'', '$pidx', '$row[userid]', 'N', ''
										 )";
				mysql_query($insertQuery);
				$cidx = mysql_insert_id();

				$receivechecktag = "<img src='".$INFO[url]."/emailreceivecheck.php?idx=$cidx' style='display:none;'>";
				$dMail = new Sendmail; 
				$dMail->setUseSMTPServer(true); 
				$dMail->setSMTPServer("222.122.158.112");
				$dMail->setSMTPUser("ccicmail@onandon.co.kr");
				$dMail->setSMTPPasswd("~ccicmail!@#");
				$dMail->setFrom($INFO[email], $INFO[company]); 
				$dMail->setSubject($email_title); 
				$dMail->setMailBody($email_content.$receivechecktag, true); 
				$dMail->addTo($row[email], $row[name]); 
				$dMail->send(); 
				unset($dMail);

				$count++;
			}
			break;
		case "C":	// ���õ�ȸ��
			$position = "���õ�ȸ��";				
			$count = "0";
			$ex	 = explode(",",$delValue);
			for($i=0; $i < count($ex); $i++){
				$query	= "SELECT userid,email,name FROM ona_member WHERE mobile!='' and status1!='2' && idx='".$ex[$i]."'";
				$result	= mysql_query($query);
				$row		= mysql_fetch_array($result);
				$insertQuery = "INSERT INTO email_history_member (
											idx, pidx, userid, receive, receivedate
										 ) VALUE (
											'', '$pidx', '$row[userid]', 'N', ''
										 )";
				mysql_query($insertQuery);
				$cidx = mysql_insert_id();

				$receivechecktag = "<img src='".$INFO[url]."/emailreceivecheck.php?idx=$cidx' style='display:none;'>";
				$dMail = new Sendmail; 
				$dMail->setUseSMTPServer(true); 
				$dMail->setSMTPServer("222.122.158.112");
				$dMail->setSMTPUser("ccicmail@onandon.co.kr");
				$dMail->setSMTPPasswd("~ccicmail!@#");
				$dMail->setFrom($INFO[email], $INFO[company]); 
				$dMail->setSubject($email_title); 
				$dMail->setMailBody($email_content.$receivechecktag, true); 
				$dMail->addTo($row[email], $row[name]); 
				$dMail->send(); 
				unset($dMail);
				$count++;
			}			
			break;
		case "A":	// ��üȸ��
			$position = "��üȸ��";
			$count = "0";
			$query	= "SELECT userid,email,name FROM ona_member WHERE mobile!='' and status1!='2' ORDER BY idx DESC";
			$result	= mysql_query($query);			
			while( $row = mysql_fetch_array($result)){
				$insertQuery = "INSERT INTO email_history_member (
											idx, pidx, userid, receive, receivedate
										 ) VALUE (
											'', '$pidx', '$row[userid]', 'N', ''
										 )";
				mysql_query($insertQuery);
				$cidx = mysql_insert_id();

				$receivechecktag = "<img src='".$INFO[url]."/emailreceivecheck.php?idx=$cidx' style='display:none;'>";
				$dMail = new Sendmail; 
				$dMail->setUseSMTPServer(true); 
				$dMail->setSMTPServer("222.122.158.112");
				$dMail->setSMTPUser("ccicmail@onandon.co.kr");
				$dMail->setSMTPPasswd("~ccicmail!@#");
				$dMail->setFrom($INFO[email], $INFO[company]); 
				$dMail->setSubject($email_title); 
				$dMail->setMailBody($email_content.$receivechecktag, true); 
				$dMail->addTo($row[email], $row[name]); 
				$dMail->send(); 
				unset($dMail);
				$count++;
			}			
			break;
	}



	echo "<script>
				 alert('$count ���� EMAIL�� �߼� �Ǿ����ϴ�.');
				 parent.searchForm.submit();
			  </script>";

?>
