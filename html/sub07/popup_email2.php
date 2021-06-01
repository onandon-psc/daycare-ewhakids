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
						alert('입력하신 정보와 일치하는 정보가 없습니다.');
						location.href='../../html/sub07/popup_email2.php';
					  </script>";
		}
	}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<title>++ 국회 제2 어린이집의 방문을 환영합니다. ++</title>
<link href="../../include/css/style.css" rel="stylesheet" type="text/css">
<script language="javascript">
<!--
	function next_check(f){

		var Chk = 0;
		var yy  = f.mbJumin1.value.substring(0,2);
		var mm  = f.mbJumin1.value.substring(2,4);
		var dd  = f.mbJumin1.value.substring(4,6);

		if ( !f.mbName.value ){
			alert("이름을 입력하세요!!");
			f.mbName.focus();
			return false;
		}		

		if ( f.mbJumin1.value == "" ){
			alert("주민등록번호를 입력하십시오!!");
			f.mbJumin1.focus();
			return false;
		}

		if ( f.mbJumin2.value == "" ){
			alert("주민등록번호를 입력하십시오!!");
			f.mbJumin2.focus();
			return false;
		}			
	
		if (f.mbJumin1.value.length != 6 || mm < 1 || mm > 12 || dd < 1 || dd > 31) {
			alert("주민등록번호를 제대로 입력해주세요. ");
			f.mbJumin1.focus();
			return false;
		}

		if (f.mbJumin2.value.length != 7) {
			alert("주민등록번호를 제대로 입력해주세요. ");
			f.mbJumin2.focus();
			return false;
		}

		for (i=1;i<f.mbJumin1.value.length+1;i++)      {
			tempw=parseInt(f.mbJumin1.value.substring(i-1,i));
			if (isNaN(tempw)== true) {
				alert("주민등록번호 값이 잘못 입력되었습니다.");
				f.mbJumin1.focus();
				return false;
			}
		}

		for (i=1;i<f.mbJumin2.value.length+1;i++)      {
			tempw=parseInt(f.mbJumin2.value.substring(i-1,i));
			if (isNaN(tempw)== true) {
				alert("주민등록번호 값이 잘못 입력되었습니다.");
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
			 alert ("유효하지 않은 주민등록번호입니다.");
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
						<!---정보입력--->
						<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableA">
							<tr>
								<td width="130" class="input_tit">성 명</td>
								<td width="270" class="input_item">
									<input name="mbName" type="text" class="input" style="width:150;IME-MODE:active;">
								</td>
							</tr>
							<tr>
								<td class="input_tit" style="border-bottom:none;">주민등록번호</td>
								<td class="input_item" style="border-bottom:none;">
									<input name="mbJumin1" type="text" class="input" id="number_01" style="width:90px" maxlength="6" onKeyUp="if(this.value.match(/[^0-9]/)) { alert('숫자만 넣어주세요'); this.value = ''; this.focus(); return false; };lengthCheck( this );">
									-
									<input name="mbJumin2" type="password" class="input" id="number_02" style="width:90px" maxlength="7
									" onKeyUp="if(this.value.match(/[^0-9]/)) { alert('숫자만 넣어주세요'); this.value = ''; this.focus(); return false; };lengthCheck( this );">
								</td>
							</tr>
						</table>
						<!---정보입력(e)--->
					</td>
				</tr>
				<tr>
					<td align="center" style="padding-top:25px;"><input type="image" src="../../images/member/btn_confirm02.gif" alt="확인" style="cursor:pointer"></td>
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
				<td height="80" align="center" valign="middle" class="font_gray1">가입시 등록하신 이메일은 <span class="center wline">"<b><?=$email?>@<?=$exEmail[1]?></b>"</span> 입니다.</td>
			</tr>
			<tr>
				<td align="center" valign="middle" class="font_gray1"><img src="../../images/member/btn_confirm02.gif" alt="확인" border="0" align="absmiddle" onclick="window.close()" style="cursor:pointer"></td>
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
