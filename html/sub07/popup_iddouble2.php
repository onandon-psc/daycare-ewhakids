<?
	include "../../include/global/config.php"; 

	$mbId = $_REQUEST['mbId'];

	if($mbId){
		$query	= "SELECT count(*) FROM ona_member WHERE mbId='".$mbId."'";
		$result	= mysql_query($query);
		$row		= mysql_fetch_array($result);
	}else{
		exit;
	}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<link href="../../include/css/style.css" rel="stylesheet" type="text/css">
<script language="javascript">
<!--
	function inputCheck(f){
		if (f.mbId.value=="") {
			alert("���̵� �Է��Ͻʽÿ�!!");
			f.mbId.focus();
			return false;
		}
		if (!f.mbId.value.match(/^[a-z\d]{5,15}$/)) {
			alert("���̵�� 5���̻� 16�� �̸�, ���� �� ���ڸ� ��밡���մϴ�.");
			f.mbId.focus();
			f.mbId.select();
			return false;
		}
		return;
	}

	function confirmID(f){
		parent.submit(f.mbId.value);
	}
//-->
</script>
</head>
<body class="popup_style">
<table width="450" border="0" cellspacing="0" cellpadding="0">
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
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td><img src="../../images/member/ptxt_01.gif" style="margin-bottom:10px;"></td>
						</tr>
						<tr>
							<td class="popup_box center text11_gray4">
								���̵� <span class="text11_orenge3 bold">&quot;<?=$mbId?>&quot;</span>�� ����Ͻ� �� <?=$row[0]=="0"?"��":"��"?>���ϴ�.<br>
								<? if($row[0]=="0"){?>�� ���̵� ����Ϸ��� ���̵� ����ư�� Ŭ���ϼ���.<?}?>
							</td>
						</tr>
						<? if($row[0]=="0"){?>
						<form onsubmit="confirmID(this);">
						<input type="hidden" name="mbId" value="<?=$mbId?>">
						<tr>
							<td align="center" style="padding:10px 0px 20px 0px;"><input type="image" src="../../images/member/btn_idconfirm.gif" alt="���̵� ���"></td>
						</tr>
						</form>
						<?}?>
						<tr>
							<td><img src="../../images/member/ptxt_02.gif" style="margin-bottom:10px;"></td>
						</tr>
						<form action="<?=$PHP_SELF?>" onsubmit="return inputCheck(this);">	
						<tr>
							<td class="popup_box center text11_gray4">
								<span class="bold">�ٸ� ���̵� �Է�</span>
								<input name="mbId" type="text" class="input" id="textfield" style="width:100px;">
								<input type="image" src="../../images/member/btn_iddouble.gif" alt="�ߺ�Ȯ��" align="absmiddle" style="margin-left:1px;">
							</td>
						</tr>
						<tr>
							<td align="center" style="padding-top:15px;"><img src="../../images/member/btn_confirm03.gif" alt="Ȯ��" onClick="window.close();" style="cursor:pointer"></td>
						</tr>
						</form>
					</table>
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
