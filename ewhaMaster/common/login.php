<?
	include "../../include/global/config.php"; 
?>
<script language="javascript">
<!--
	function inputCheck(f){
		if(f.mbId.value==''){
			alert('���̵� �Է��� �ֽʽÿ�!!');
			f.mbId.focus();
			return false;
		}

		if(f.mbPwd.value==''){
			alert('��й�ȣ�� �Է��� �ֽʽÿ�!!');
			f.mbPwd.focus();
			return false;
		}
		return true;
	}

	function MM_openBrWindow(theURL,winName,features) { //v2.0
		window.open(theURL,winName,features);
	}
//-->
</script>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<title>++ ��ȸ ��2 ������� �湮�� ȯ���մϴ�. ++</title>
<link href="../../include/css/style.css" rel="stylesheet" type="text/css">
</head>
<body class="popup_style" onLoad="thisForm.mbId.focus();">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td height="5" bgcolor="a1c949">
			<table width="880" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td><img src="../../images/add/img_03.gif" width="682"></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<table width="880" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td height="678" valign="top" background="../../images/add/img_04.gif" style="padding:196px 0px 0px 420px">
						<!---�α���--->
						<table border="0" cellspacing="0" cellpadding="0">
						<form name="thisForm" method="post" action="../common/login_proc.php"  onsubmit="return inputCheck(this);" target="iframe">
							<tr>
								<td>
									<img src="../../images/member/txt_01.gif" align="absmiddle" />
									<input name="mbId" type="text" class="input_type01" style="width:180px" tabindex=1 onpaste="return false;" style="IME-MODE:disabled">
								</td>
								<td rowspan="3" style="padding-left:7px;">
									<input type="image" src="../../images/member/btn_login.gif" alt="�α���" border="0" id="Image1">
								</td>
							</tr>
							<tr>
								<td height="4"></td>
							</tr>
							<tr>
								<td>
									<img src="../../images/member/txt_02.gif" align="absmiddle" />
									<input name="mbPwd" type="password" class="input_type01" style="width:180px" tabindex=2>
								</td>
							</tr>
						</form>
						</table>
						<!---�α���(e)--->
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</body>
</html>
