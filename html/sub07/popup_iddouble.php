<!--
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<title>++ 아이디 중복확인 ++</title>
<script language="javascript">
	function submit(mbId){
		of = dialogArguments.document.frm;		
		of.mbId.value = mbId;
		of.idCheck.value = mbId;
		of.mbName.focus();
		window.close();		
	}
</script>
<iframe src="popup_iddouble2.php?mbId=<?=$mbId?>" style="width:100%;height:100%;"></iframe>
-->
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<title>++ 아이디 중복확인 ++</title>
<script language="javascript">
	function submit(mbId){
		of = window.opener.document.frm;		
		of.mbId.value = mbId;
		of.idCheck.value = mbId;
		of.mbName.focus();
		window.close();		
	}
</script>
<iframe src="popup_iddouble2.php?mbId=<?=$mbId?>" style="width:100%;height:100%;"></iframe>