<?
	include "../../include/global/config.php"; 
?>
<script language="javascript">
<!--
	function inputCheck(f){
		if(f.mbPwd.value==''){
			alert('���� ��й�ȣ�� �Է��� �ֽʽÿ�!!');
			f.mbPwd.focus();
			return false;
		}
		if(f.newPwd.value==''){
			alert('�� ��й�ȣ�� �Է��� �ֽʽÿ�!!');
			f.newPwd.focus();
			return false;
		}
		return true;
	}
//-->
</script>


<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>�����ڽý���</title>
<link href="css/common.css" rel="stylesheet" type="text/css" />
</head>
<body onload="thisForm.mbPwd.focus()" style="margin:10 0 0 10">

<table align="left" border="0" cellpadding="0" cellspacing="0" style="padding:0 0 0 10">
<form name="thisForm" method="post" action="../common/admin_modify_proc.php"  onsubmit="return inputCheck(this);" target="iframe">
	<tr>
		<td width="100" class="board_tit" style="padding-left:15">ID</td>
		<td>
			<input name="mbId" type="hidden"value="<?=$_SESSION['member_id']?>"><?=$_SESSION['member_id']?>
		</td>
	</tr>
	<tr>
		<td width="100" class="board_tit" style="padding-left:15">���� ��й�ȣ</td>
		<td>
			<input name="mbPwd" type="password" style="width:130px">
		</td>
	</tr>
	<tr>
		<td width="100" class="board_tit" style="padding-left:15">�� ��й�ȣ</td>
		<td>
			<input name="newPwd" type="password" style="width:130px">
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center" style="padding:10 0 0 0;"><input type="image" src="../../images/btn/btn_confirm.gif" alt="Ȯ��" border="0" style="margin-left:5"></td>
	</tr>
</table>
</form>
</body>
</html>

