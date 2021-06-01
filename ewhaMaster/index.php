<?
	session_start();
	if( empty($_SESSION['masterSession']) ){
		echo "<script language='javascript'>					
					 location.href='common/login.php';
				  </script>";
	} else {
		$page_url = "member/mb_list.php";
		if( $_SESSION['member_level'] =="9" ) 
		{
			$page_url = ($_SESSION['member_sAdmin']=="Z") ? "/ewhaMaster/sub/index.php?msChk=master&pno=060301" : "member/mb_list.php";
		}
?>
<html>
<head>
<title>++ 관리자 ++</title>
 <meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
 <meta http-equiv="cache-control" content="no-cache">
 <meta http-equiv="pragma" content="no-cache">
 <link href="/include/css/style.css" rel="stylesheet" type="text/css">
</head>
<frameset rows="65,100%" cols="1*" border="0">
	<frame name="topFrame" scrolling="no" marginwidth="0" marginheight="0" src="common/top.php" noresize >
	<frameset rows="1*" cols="158, 100%" border="0">
	<frame name="leftFrame" scrolling="no" marginwidth="0" marginheight="0" src="common/left.php" noresize >
	<frame name="mainFrame" scrolling="auto" marginwidth="0" marginheight="0" src="<?=$page_url?>" noresize >
	</frameset>
	<noframes>
	  <body>
	  <p>이 페이지에서 프레임을 사용하지만 브라우저에서 지원하지 않습니다.</p>
	  </body>
	</noframes>
</frameset>
<? } ?>