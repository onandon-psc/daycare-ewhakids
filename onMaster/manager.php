<?
	// config.php iframe ���(x)
	$iframeType = "no";
	include "../include/global/config.php"; 
	if($_SESSION['onMasterId']!="onon"){
		echo "<script>top.location.href='./login.php';</script>";
	} else {
?>
<html>
<frameset rows="31,100%" cols="1*" border="0">
	<frame name="topFrame" scrolling="no" marginwidth="0" marginheight="0" src="top.php" noresize >
	<frameset rows="1*" cols="150, 100%" border="0">
	<frame name="leftFrame" scrolling="no" marginwidth="0" marginheight="0" src="left.php" noresize >
	<frame name="mainFrame" scrolling="auto" marginwidth="0" marginheight="0" src="boardman/index.php" >
	</frameset>
	<noframes>
	  <body>
	  <p>�� ���������� �������� ��������� ���������� �������� �ʽ��ϴ�.</p>
	  </body>
	</noframes>
</frameset>
</html>
<? } ?>