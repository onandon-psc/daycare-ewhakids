<?
	include "../../include/global/config.php"; 
	$mbId = trim($_REQUEST['mbId']);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<title>++ 국회 제2 어린이집의 방문을 환영합니다. ++</title>
<link href="../../include/css/style.css" rel="stylesheet" type="text/css">
</head>
<body class="popup_style">
<table width="450" height="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td height="37" background="../../images/member/box2_top.gif">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td style="padding:0px 0px 0px 21px"><img src="../../images/member/ptitle_id.gif" width="122" height="36"></td>
					<td align="right" style="padding:0px 21px 0px px"><img src="../../images/common/btn_close.gif" onClick="window.close()" style="cursor:pointer"></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td height="29" valign="top"><img src="../../images/member/box2_img.gif" width="450"></td>
	</tr>
	<tr>
		<td valign="top" background="../../images/member/box2_bg.gif" style="padding:0px 25px 0px 25px">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td><img src="../../images/member/ptxt_11.gif" style="margin-bottom:10px;"></td>
				</tr>
				<tr>
					<!---아이디 출력--->
					<td class="popup_box center font_orenge">&quot;<?=$mbId?>&quot;</td>
					<!---아이디 출력(e)--->
				</tr>
				<tr>
					<td align="center" style="padding-top:15px;"><a href="#"><img src="../../images/member/btn_confirm03.gif" alt="확인"></a></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td height="30"><img src="../../images/member/box2_bottom.gif" width="450" height="30"></td>
	</tr>
</table>
</body>
</html>
