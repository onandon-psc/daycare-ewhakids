<?
	include "../../include/global/config.php";
	include "../board_session.php"; 

	$regdate = mktime();

	$mode				= $_POST[mode];
	$kind				= $_POST[kind];
	$tblName			= trim($_POST[tblName]);
	$tblNameMmr	= trim($_POST[tblNameMmr]);

	if($tblName == "" || $tblName == "ona_board_") $tblName = "ona_board_".$cate1.$cate2.$cate3.$cate4.$cate5.$cate6;
	
	// 테이블 생성
	function createTable()
	{
		global $tblName;
		$query = "CREATE TABLE $tblName (
						  board_idx int(11) unsigned NOT NULL auto_increment,
						  board_kind varchar(10) NOT NULL default '',
						  board_id varchar(30) NOT NULL default '',
						  board_pwd varchar(12) NOT NULL default '',
						  board_name varchar(30) NOT NULL default '',
						  board_email varchar(30) NOT NULL default '',
						  board_subject varchar(255) NOT NULL default '',
						  board_content text NOT NULL,
						  board_notice enum('N','Y') NOT NULL default 'N',
						  board_secret enum('N','Y') NOT NULL default 'N',
						  board_hit int(4) unsigned NOT NULL default '0',
						  board_regdate varchar(10) NOT NULL default '',
						  board_ip varchar(15) NOT NULL default '',
						  board_group int(11) unsigned NOT NULL default '0',
						  board_depth int(11) unsigned NOT NULL default '0',
						  board_order int(4) unsigned NOT NULL default '0',
						  board_file1 varchar(255) NOT NULL,
						  board_file2 varchar(255) NOT NULL,
						  board_file3 varchar(255) NOT NULL,
						  board_file4 varchar(255) NOT NULL,
						  board_file5 varchar(255) NOT NULL,
						  board_state char(1) NOT NULL default '1',
						  PRIMARY KEY  (board_idx),
						  KEY subject (board_subject)
						)";
		mysql_query($query);
	}	

	switch ($mode){		

		case "modify": // 수정

			if($tblName && ereg("1",$kind) ){

				$query = "SHOW TABLES LIKE '".$tblName."'";
				$result	= mysql_query($query);
				$row		= mysql_fetch_array($result);
				
				if( !trim($row[0]) ){
					createTable();
				}else{
					if($tblName != $tblNameMmr){
?>
					<script language='javascript'>
						alert('이미 등록된 테이블이 있습니다.\n다른 테이블명으로 등록하세요!');
					</script>
<?					exit;
					}					
				}
			}else{
				$tblName = "";
			}

			$pno			= $hidpno;
			$hidpno	= $cate1.$cate2.$cate3.$cate4.$cate5.$cate6;

			// 대분류명 얻기
			$codeQuery	= "SELECT * FROM BOARD_MANAGER_CATE WHERE viewType='Y' && menuCode='$cate1'";
			$codeResult	= mysql_query($codeQuery);
			$codeRow	= mysql_fetch_array($codeResult);

			$new_seq	= $hidseq + 1;			

			$query	= "INSERT INTO BOARD_MANAGER (
								pno, use_yn, last_yn, del_yn, 
								cate1, cate2, cate3, cate4, cate5, cate6,
								kind, boardkind, tblName, link_file, bd_list, bd_comment, 
								bd_prenext, bd_reply, bd_view, bd_write, bd_file, bd_secu ,tab_file, regdate
								,content
							)
							select 
								'$hidpno', '$use_yn', 'Y', 'N', 
								'$codeRow[MENUNAME]',  '$cate2Name', '$cate3Name', '$cate4Name', '$cate5Name', '$cate6Name',
								'$kind', '$boardkind', '$tblName', '$link_file', '$bd_list', '$bd_comment', 
								'$bd_prenext', '$bd_reply', '$bd_view', '$bd_write', $bd_file,'$bd_secu','$tab_file', '$regdate',
								'$bd_comment'
							FROM BOARD_MANAGER
							WHERE pno = '$pno' && seq = '$hidseq'";
			mysql_query($query);

			$query	= "UPDATE BOARD_MANAGER 
							SET last_yn = 'N'
							WHERE pno = '$pno' and seq = '$hidseq'";
			mysql_query($query);

			echo "<script language='javascript'>
						 alert('수정되었습니다.');
						 parent.run();
					  </script>";
			exit;
			break;

		case "write" : // 등록
			
			if($tblName && ereg("1",$kind) ){

				$query = "SHOW TABLES LIKE '".$tblName."'";
				$result	= mysql_query($query);
				$row		= mysql_fetch_array($result);

				if( !trim($row[0]) ){
					createTable();
				}else{
?>
					<script language='javascript'>
					<!--
						alert('이미 등록된 테이블이 있습니다.\n다른 테이블명으로 등록하세요!!');
					//-->
					</script>
<?					exit;
				}
			}else{
				$tblName = "";
			}

			$r_pno	= $cate1.$cate2.$cate3.$cate4;

			if($cate5){ $r_pno = $r_pno.$cate5; }
			if($cate6){ $r_pno = $r_pno.$cate6; }

			// 기존에 동일한 pno가 존재하는 지 검사.
			$query = "SELECT seq FROM BOARD_MANAGER WHERE pno ='$r_pno'";
			$result	= mysql_query($query);
			$row		= mysql_fetch_array($result);

			if( $row[seq] ) {
				echo "<script language='javascript'>
							  alert('".$r_pno." 이미 등록된 코드 입니다.');
							  history.back();
						  </script>";
				exit;
			} 			

			// 대분류명 얻기
			$codeQuery	= "SELECT * FROM BOARD_MANAGER_CATE WHERE viewType='Y' && menuCode='$cate1'";
			$codeResult	= mysql_query($codeQuery);
			$codeRow	= mysql_fetch_array($codeResult);
			
			$query	= "INSERT INTO BOARD_MANAGER (
								pno, use_yn, last_yn, del_yn, 
								cate1, cate2, cate3, cate4, cate5, cate6,
								kind, boardkind, tblName, link_file, bd_list, bd_comment, 
								bd_prenext, bd_reply, bd_view, bd_write, bd_file, bd_secu, tab_file,regdate
							) VALUES(
								'$r_pno', '$use_yn', 'Y', 'N', 
								'$codeRow[MENUNAME]', '$cate2Name', '$cate3Name', '$cate4Name', '$cate5Name', '$cate6Name',
								'$kind', '$boardkind', '$tblName', '$link_file', '$bd_list', '$bd_comment',
								'$bd_prenext', '$bd_reply', '$bd_view', '$bd_write', $bd_file,'$bd_secu','$tab_file', '$regdate' 
							)";
			mysql_query($query);

			echo "<script language='javascript'>
						  alert('등록되었습니다');
						  parent.run();
					  </script>";
			exit;
			break;
	}
?>
