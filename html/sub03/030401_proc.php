<?
	include $_SERVER['DOCUMENT_ROOT']."/include/global/config.php";	

	$send			= trim($_POST['send']);
	$idx				= trim($_POST['idx']);
	$mbId			= trim($_POST['mbId']);
	$childName	= trim($_POST['childName']);
	$childClass	= trim($_POST['childClass']);
	$childClass2	= trim($_POST['childClass2']);
	$childTime1	= trim($_POST['childTime1']);
	$childTime2	= trim($_POST['childTime2']);
	$childMemo	= trim($_POST['childMemo']);
	
	$wdate			= date("Y-m-d");
	$regdate		= mktime();
	$childTime	= $childTime1.":".$childTime2;

	switch($send)
	{
		case "write":
			if($mbId){
				$query = "INSERT INTO ona_030401 ( 
									wdate , mbId , childName , childClass , childTime , childMemo , regdate, childClass2 ) 
								VALUES (
									'$wdate', '$mbId', '$childName', '$childClass', '$childTime', '$childMemo', '$regdate', '$childClass2'
								)";
				mysql_query($query);

				echo "<script>
							 alert('야간보육신청 되었습니다.');
							 parent.location.href('/html/sub/index.php?pno=030402');
						  </script>";
				exit;
			}else{
				echo "<script>
							 alert('야간보육신청이 되지 않았습니다.');
							 parent.location.href('/html/sub/index.php?pno=070101');
						  </script>";
				exit;
			}	
			break;

		case "modify":
			if($mbId){
				$query = "UPDATE ona_030401 SET 
									childName='$childName' , 
									childClass='$childClass' , 
									childClass2='$childClass2' , 
									childTime='$childTime' , 
									childMemo='$childMemo'
								WHERE mbId='".$_SESSION[member_id]."' && wdate='".date('Y-m-d')."'";
				mysql_query($query);

				echo "<script>
							 alert('야간보육신청이 수정 되었습니다.');
							 parent.location.href('/html/sub/index.php?pno=030402');
						  </script>";
				exit;
			}else{
				echo "<script>
							 alert('야간보육신청이 수정되지 않았습니다.');
							 parent.location.href('/html/sub/index.php?pno=070101');
						  </script>";
				exit;
			}	
			break;

		case "delete":
			$query = "DELETE FROM ona_030401 WHERE idx='$idx'";
			mysql_query($query);
			echo "<script>
						 alert('야간보육신청 취소되었습니다.');
						 parent.location.href('/html/sub/index.php?pno=030401');
					  </script>";
			break;
	}
?>