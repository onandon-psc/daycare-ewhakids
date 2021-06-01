<?
	include "../../include/global/config.php"; 

	$mbName		= trim($_POST['mbName']);

	$jumin1 = substr($birth1,2,2).$birth2.$birth3;
	$jumin2 = trim($_POST['sex']);
	if($birth1 > 1999)
	{
		$jumin2 = $jumin2+2;
	}
	$mbJumin				= $jumin1."-".$jumin2;

	if( $mbName && $mbJumin){
		$query = "SELECT * FROM ona_member WHERE mbName='".$mbName."' && mbJumin='".$mbJumin."' && mbStatus!='C' order by mbRegdate desc";
		$result	= mysql_query($query);
		$row		= @mysql_fetch_array($result);

		if (!$row[mbEmail]){
			echo "<script>					
						alert('입력하신 정보와 일치하는 정보가 없습니다.');
						location.href='../../html/sub07/new_popup_email2.php';
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

		return;
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
			<form name="frm" method="post" action="../../html/sub07/new_popup_email2.php" onsubmit="return next_check(this)">
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
								<td class="input_tit" style="border-bottom:none;">생년월일</td>
								<td class="input_item" style="border-bottom:none;">
									<select class="form" name='birth1'>
									<? for ($y = date("Y")-110; $y <= date("Y"); $y++) { 
											if($m < 10) {$m = "0".$m;}
										?>	
											<option value='<?=$y?>' <? if($y == date("Y")){?>selected<?}?>><?=$y?></option>
										<? } ?>
									</select>
									-
									<select class="form" name='birth2'>
									<? for ($m = 1; $m < 13; $m++) { 
											if($m < 10) {$m = "0".$m;}
										?>	
											<option value='<?=$m?>' <? if($m == date("m")){?>selected<?}?>><?=$m?></option>
										<? } ?>
									</select>
									-
									<select class="form" name='birth3'>
										<? for ($d = 1; $d < 32; $d++) { 
											if($d < 10) { $d = "0".$d;}
										?>
											<option value='<?=$d?>' <? if($d == date("d")){?>selected<?}?>><?=$d?></option>
										<? } ?>
									</select>
									<input type='radio' name='sex' value='1' checked>남<input type='radio' name='sex' value='2'>여
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
