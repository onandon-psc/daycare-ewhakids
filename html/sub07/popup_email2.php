<?
	include "../../include/global/config.php"; 

	$mbName		= trim($_POST['mbName']);
	$mbJumin		= trim($_POST['mbJumin1'])."-".trim($_POST['mbJumin2']);

	if( $mbName && $mbJumin){
		$query = "SELECT * FROM ona_member WHERE mbName='".$mbName."' && mbJumin='".$mbJumin."' && mbStatus!='C'";
		$result	= mysql_query($query);
		$row		= @mysql_fetch_array($result);

		if (!$row[mbEmail]){
			echo "<script>					
						alert('�Է��Ͻ� ������ ��ġ�ϴ� ������ �����ϴ�.');
						location.href='../../html/sub07/popup_email2.php';
					  </script>";
		}
	}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<title>++ ��ȸ ��2 ������� �湮�� ȯ���մϴ�. ++</title>
<link href="../../include/css/style.css" rel="stylesheet" type="text/css">
<script language="javascript">
<!--
	function next_check(f){

		var Chk = 0;
		var yy  = f.mbJumin1.value.substring(0,2);
		var mm  = f.mbJumin1.value.substring(2,4);
		var dd  = f.mbJumin1.value.substring(4,6);

		if ( !f.mbName.value ){
			alert("�̸��� �Է��ϼ���!!");
			f.mbName.focus();
			return false;
		}		

		if ( f.mbJumin1.value == "" ){
			alert("�ֹε�Ϲ�ȣ�� �Է��Ͻʽÿ�!!");
			f.mbJumin1.focus();
			return false;
		}

		if ( f.mbJumin2.value == "" ){
			alert("�ֹε�Ϲ�ȣ�� �Է��Ͻʽÿ�!!");
			f.mbJumin2.focus();
			return false;
		}			
	
		if (f.mbJumin1.value.length != 6 || mm < 1 || mm > 12 || dd < 1 || dd > 31) {
			alert("�ֹε�Ϲ�ȣ�� ����� �Է����ּ���. ");
			f.mbJumin1.focus();
			return false;
		}

		if (f.mbJumin2.value.length != 7) {
			alert("�ֹε�Ϲ�ȣ�� ����� �Է����ּ���. ");
			f.mbJumin2.focus();
			return false;
		}

		for (i=1;i<f.mbJumin1.value.length+1;i++)      {
			tempw=parseInt(f.mbJumin1.value.substring(i-1,i));
			if (isNaN(tempw)== true) {
				alert("�ֹε�Ϲ�ȣ ���� �߸� �ԷµǾ����ϴ�.");
				f.mbJumin1.focus();
				return false;
			}
		}

		for (i=1;i<f.mbJumin2.value.length+1;i++)      {
			tempw=parseInt(f.mbJumin2.value.substring(i-1,i));
			if (isNaN(tempw)== true) {
				alert("�ֹε�Ϲ�ȣ ���� �߸� �ԷµǾ����ϴ�.");
				f.mbJumin2.focus();
				return false;
			}
		}

		for (var i = 0; i <=5 ; i++) {
			Chk = Chk + ((i%8+2) * parseInt(f.mbJumin1.value.substring(i,i+1)))
		}

		for (var i = 6; i <=11 ; i++) {
			Chk = Chk + ((i%8+2) * parseInt(f.mbJumin2.value.substring(i-6,i-5)))
		}

		Chk = 11 - (Chk %11)
		Chk = Chk % 10

		if (Chk != f.mbJumin2.value.substring(6,7)) {
			 alert ("��ȿ���� ���� �ֹε�Ϲ�ȣ�Դϴ�.");
			 f.mbJumin2.focus();
			 return false;
		}
		return;
	}

	function lengthCheck( checkTag ){

		f = document.frm;

		if ( checkTag.name == "mbJumin1" ){
			if ( checkTag.value.length >= 6 )
			{
				checkTag.blur();					
				f.mbJumin2.focus();
			}
		}

	}
//-->
</script>
</head>
<body class="popup_style">
<table width="450" height="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td height="37" background="../../images/member/box2_top.gif">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td style="padding:0px 0px 0px 21px"><img src="../../images/member/ptitle_email.gif"></td>
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
		<? if( !$row[mbEmail] ){ ?>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<form name="frm" method="post" action="../../html/sub07/popup_email2.php" onsubmit="return next_check(this)">
				<tr>
					<td><img src="../../images/member/ptxt_12.gif" style="margin-bottom:10px;"></td>
				</tr>
				<tr>
					<td>
						<!---�����Է�--->
						<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableA">
							<tr>
								<td width="130" class="input_tit">�� ��</td>
								<td width="270" class="input_item">
									<input name="mbName" type="text" class="input" style="width:150;IME-MODE:active;">
								</td>
							</tr>
							<tr>
								<td class="input_tit" style="border-bottom:none;">�ֹε�Ϲ�ȣ</td>
								<td class="input_item" style="border-bottom:none;">
									<input name="mbJumin1" type="text" class="input" id="number_01" style="width:90px" maxlength="6" onKeyUp="if(this.value.match(/[^0-9]/)) { alert('���ڸ� �־��ּ���'); this.value = ''; this.focus(); return false; };lengthCheck( this );">
									-
									<input name="mbJumin2" type="password" class="input" id="number_02" style="width:90px" maxlength="7
									" onKeyUp="if(this.value.match(/[^0-9]/)) { alert('���ڸ� �־��ּ���'); this.value = ''; this.focus(); return false; };lengthCheck( this );">
								</td>
							</tr>
						</table>
						<!---�����Է�(e)--->
					</td>
				</tr>
				<tr>
					<td align="center" style="padding-top:25px;"><input type="image" src="../../images/member/btn_confirm02.gif" alt="Ȯ��" style="cursor:pointer"></td>
				</tr>
			</form>
			</table><script>document.frm.mbName.focus();</script>
		<? 
		}else{ 
			$exEmail = explode("@",$row[mbEmail]);
			$email = substr($exEmail[0],0,2);
			for($n=2; $n<strlen($exEmail[0]); $n++){
				$email = $email."*";
			}
		?>
		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
			<tr>
				<td height="80" align="center" valign="middle" class="font_gray1">���Խ� ����Ͻ� �̸����� <span class="center wline">"<b><?=$email?>@<?=$exEmail[1]?></b>"</span> �Դϴ�.</td>
			</tr>
			<tr>
				<td align="center" valign="middle" class="font_gray1"><img src="../../images/member/btn_confirm02.gif" alt="Ȯ��" border="0" align="absmiddle" onclick="window.close()" style="cursor:pointer"></td>
			</tr>
		</table>
		<? } ?>
		</td>
	</tr>
	<tr>
		<td height="30"><img src="../../images/member/box2_bottom.gif" width="450" height="30"></td>
	</tr>
</table>
</body>
</html>
