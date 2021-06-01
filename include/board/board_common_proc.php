<?
	set_time_limit(0);
	include "../../include/global/config.php"; 

	$table					= trim($_POST['boardName']);
	$send					= trim($_POST['send']);
	$board_idx			= trim($_POST['board_idx']);
	$board_kind			= trim($_POST['board_kind']);
	$board_pwd          = trim($_POST['event_kind']);
	$board_id				= trim($_POST['board_id']);
	$board_name		= trim($_POST['board_name']);
	$board_email		= trim($_POST['board_email']);
	$board_subject	= trim($_POST['board_subject']);
	$board_notice		= trim($_POST['board_notice']);
	$board_secret		= trim($_POST['board_secret']);
	$boardStyle			= trim($_POST['boardStyle']);
	$boardFileNum		= trim($_POST['boardFileNum']);	
	$regdate				= mktime();
	$uip						= $_SERVER['REMOTE_ADDR'];
	
	if($pno=="050103" || $pno=="050301" || (substr($pno,0,2)=="04" && substr($pno,4,2)=="03"))
	{
	   if($mode != "reply")
	   {
	      if($board_kind == "")
	      {
		      $board_kind = trim($_POST[board_class]);
	      }
	      if($board_pwd == "")
	      {
		      $board_pwd = trim($_POST[board_kid]);
	      }

		  if($board_name == "" || $_SESSION['masterSession'])
		  {
			   $board_name = trim($_POST[board_teacher]);
		  }
	   }
	   else
	   {
		   if($board_name == "")
		   {
			   $board_name = trim($_POST[board_teacher]);
		   }
	   }
	}

	$board_state		= trim($_POST['board_state']);

	if(empty($board_notice)) $board_notice = 'N';
	if(empty($board_secret)) $board_secret = 'N';

	if($pno=="030301"){
		$board_kind2			= trim($_POST['board_kind2']);
		if($board_kind=="전체") 
		{
			$board_kind = "";
		}
		else
		{
			$board_kind = $board_kind.",".$board_kind2;
		}
	}
	switch($send){

		case "write":

			# 파일처리
			for($n=1; $n<=$boardFileNum; $n++ ) 
			{
				if(${"file".$n}){
					$fileName				= $_FILES['file'.$n]['name'];	
					$tmpName			= $_FILES['file'.$n]['tmp_name'];
					${"fileName".$n}	= File_Process($tmpName,$fileName,$fileUrl,"insert",'');
				}
			}

			$query	= "INSERT INTO $table (
								board_kind, board_pwd, board_id, board_name, board_email, board_subject, board_content, 
								board_notice, board_secret, board_regdate, board_ip, 
								board_file1, board_file2, board_file3, board_file4, board_file5
								$fild1
							) VALUES(
								'$board_kind', '$board_pwd', '$board_id', '$board_name', '$board_email', '$board_subject', '$board_content', 
								'$board_notice', '$board_secret', '$regdate', '".$_SERVER['REMOTE_ADDR']."', 
								'$fileName1', '$fileName2', '$fileName3', '$fileName4', '$fileName5'
								$fild2
							)";
			//echo $query;
			mysql_query($query);
			
			$query	= "SELECT max(board_idx) as board_idx FROM $table";
			$result	= mysql_query($query);
			$row		= mysql_fetch_array($result);
							
			$query	= "UPDATE $table SET board_group='$row[board_idx]', board_depth='1', board_order='1' WHERE board_idx='".$row[board_idx]."'";
			mysql_query($query);

			echo"<script>
						parent.location.href='$returnUrl';
					 </script>";
			
			break;

		case "modify":
			
			$query	= "SELECT * FROM $table WHERE board_idx='".$board_idx."'";
			$result	= mysql_query($query);
			$row		= @mysql_fetch_array($result);
			
			if( ( $row[board_pwd] == $board_pwd ) || $_SESSION['masterSession'] ){

				# 파일처리
				for($n=1; $n<=5; $n++){
					if( ${fileDel.$n} == "Y" ){
						@unlink($file_url.${board_file.$n});
						$setAdd .= ", board_file$n=''";
					}
				}

				for($n=1; $n<=$boardFileNum; $n++ ) 
				{
					if(${"file".$n}){
						$fileName			 = $_FILES['file'.$n]['name'];	
						$tmpName		 = $_FILES['file'.$n]['tmp_name'];
						${"fileName".$n} = File_Process($tmpName,$fileName,$fileUrl,"edit",$row['board_file'.$n]);
						$setAdd .= ", board_file".$n."='".${'fileName'.$n}."'";
					}
				}				

				if($board_state && $pno!="030101") $setAdd .= ", board_state='$board_state'";

				if($pno=="050103" || $pno=="050301" || (substr($pno,0,2)=="04" && substr($pno,4,2)=="03"))
				{
					if($board_name == "" || $_SESSION['masterSession'])
					{
						$board_name = trim($_POST[board_teacher]);
						$setAdd .= ", board_name='$board_name'";
					}
				}
				
				$query	= "UPDATE $table SET 
									board_kind='$board_kind'
									, board_email='$board_email'
									, board_subject='$board_subject'
									, board_content='$board_content' 
									, board_notice='$board_notice'
									, board_secret='$board_secret'
									, board_pwd='$board_pwd'
									$setAdd 
								WHERE
									board_idx='".$board_idx."'";
				mysql_query($query);
				$returnUrl = $returnUrl."&board_idx=".$board_idx;

				echo"<script>
							alert('수정되었습니다.');
							parent.location.href='$returnUrl';
						 </script>";
				}

				break;
	
			case "reply":

				$query	= "SELECT board_id, board_group, board_depth, board_order FROM $table WHERE board_idx='".$board_idx."'";	
				$result	= mysql_query($query);
				$row		= mysql_fetch_array($result);

				if($row){
					$board_group	= $row[board_group];
					$board_depth	= $row[board_depth] + 1;
					$board_order	= $row[board_order] + 1;

					$update_query = "UPDATE $table SET board_order=board_order+1 WHERE board_group='$board_group' && board_order>='$board_order'";
					mysql_query($update_query);
				}

				if($board_secret=="Y") $board_id = $row[board_id];

				if($board_state && $pno!="030101")
				{
					$insertAdd1 = ", board_state";
					$insertAdd2 = ", '$board_state'";
				}

				$query	= "INSERT INTO $table (
									board_kind, board_id, board_name, board_subject, board_content, board_secret, board_regdate, board_ip $insertAdd1
								) VALUES(
									'$board_kind', '$board_id', '$board_name', '$board_subject', '$board_content', '$board_secret', '$regdate', '$REMOTE_ADDR' $insertAdd2
								)";
				mysql_query($query);

				$query	= "SELECT max(board_idx) as board_idx FROM $table";
				$result	= mysql_query($query);
				$row		= mysql_fetch_array($result);
								
				$query	= "UPDATE $table SET board_group='$board_group', board_depth='$board_depth', board_order='$board_order' WHERE board_idx='".$row[board_idx]."'";
				mysql_query($query);

				echo"<script>
							parent.location.href='$returnUrl';
						 </script>";
				break;

	}
?>