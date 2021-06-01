<?
	$exp = explode(".",basename($_SERVER['PHP_SELF']));
?>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<script language="javascript">
<!--
	function run(){
		window.returnValue = 1;
		window.close();		
	}
//-->
</script>
<iframe src="<?=$exp[0]?>_iframe.php?<?=$_SERVER['QUERY_STRING']?>" style="width:100%;height:100%"></iframe>