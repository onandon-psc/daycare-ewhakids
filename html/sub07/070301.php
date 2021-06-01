<?
	if($_SERVER['REMOTE_ADDR']!='112.218.172.4233')
	{
		include "new_070301.php";
		return;
	}
?>
<script language="javascript">
<!--
	// 아이디, 패스워드 찾기
	function popInfo(mbId,url) {
		url = "/html/sub07/"+url+".php?mbId="+mbId;
		window.showModalDialog(url, window, "dialogWidth:410px; dialogHeight:200px;scroll:no;status:no;help:no");
	}

	function popInfo2(mbId,mbPwd,url) {
		url = "/html/sub07/"+url+".php?mbId="+mbId+"&mbPwd="+mbPwd;
		window.showModalDialog(url, window, "dialogWidth:410px; dialogHeight:180px;status:no;help:no");
	}

	function lengthCheck( f, checkTag ){

		if ( checkTag.name == "mbJumin1" ){
			if ( checkTag.value.length >= 6 )
			{
				checkTag.blur();					
				f.mbJumin2.focus();
			}
		}

	}

	function idCheck(f){

		var Chk = 0;
		var yy  = f.mbJumin1.value.substring(0,2);
		var mm  = f.mbJumin1.value.substring(2,4);
		var dd  = f.mbJumin1.value.substring(4,6);

		if (f.mbName.value=="") {
			alert("이름을 입력하십시오!!");
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

	function pwdCheck(f){

		var Chk = 0;
		var yy  = f.mbJumin1.value.substring(0,2);
		var mm  = f.mbJumin1.value.substring(2,4);
		var dd  = f.mbJumin1.value.substring(4,6);

		if (f.mbId.value=="") {
			alert("아이디를 입력하십시오!!");
			f.mbId.focus();
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

		if (f.mbEmail.value=="") {
			alert("이메일을 입력하십시오!!");
			f.mbEmail.focus();
			return false;
		}

		return;
		
	}
//-->
</script>
<script language="javascript" src="../../include/js/member.js"></script>
<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td style="padding-bottom:26px;"> </td>
	</tr>
	<tr>
		<td><img src="../../images/member/img_11.gif" /></td>
	</tr>
	<tr>
		<td align="center">
			<!---아이디 찾기--->
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td><img src="../../images/member/box4_top.gif" /></td>
				</tr>
				<tr>
					<td background="../../images/member/box4_bg.gif" style="padding:0px 21px 0px 21px">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="32%"><img src="../../images/member/img_12.gif" /></td>
								<td width="68%">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<form name="idSearchFrm" method="post" action="../sub07/member_idpw_proc.php" onsubmit="return idCheck(this);" target="iframe">
										<input type="hidden" name="modeType" value="id">
										<tr>
											<td width="20%"><img src="../../images/member/text_06.gif" /></td>
											<td width="80%">
												<input name="mbName" type="text" class="input" id="textfield32" style="width:150px;ime-mode:active" />
											</td>
										</tr>
										<tr>
											<td height="2" colspan="2"></td>
										</tr>
										<tr>
											<td><img src="../../images/member/text_07.gif" /></td>
											<td>
												<input name="mbJumin1" type="text" class="input" style="width:100px;" maxlength="6" onKeyUp="if(this.value.match(/[^0-9]/)) { alert('숫자만 넣어주세요'); this.value = ''; this.focus(); return false; };lengthCheck( this.form, this );">
												-
												<input name="mbJumin2" type="password" class="input" style="width:100px;" maxlength="7" onKeyUp="if(this.value.match(/[^0-9]/)) { alert('숫자만 넣어주세요'); this.value = ''; this.focus(); return false; };">
												<input type="image" src="../../images/member/btn_confirm02.gif" alt="확인" border="0" align="absmiddle">
											</td>
										</tr>
									</form>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td><img src="../../images/member/box4_bottom.gif" /></td>
				</tr>
			</table>
			<!---아이디 찾기(e)--->
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>
			<!---비밀번호 찾기--->
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td><img src="../../images/member/box4_top.gif" /></td>
				</tr>
				<tr>
					<td background="../../images/member/box4_bg.gif" style="padding:0px 21px 0px 21px">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="32%"><img src="../../images/member/img_13.gif" width="195" height="54" /></td>
								<td width="68%">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<form name="idPwdFrm" method="post" action="../sub07/member_idpw_proc.php" onsubmit="return pwdCheck(this);" target="iframe">
										<input type="hidden" name="modeType" value="pwd">
										<tr>
											<td width="20%"><img src="../../images/member/text_08.gif" width="83" height="13" /></td>
											<td width="80%">
												<input name="mbId" type="text" class="input" id="textfield323" style="width:150px" />
											</td>
										</tr>
										<tr>
											<td height="2" colspan="2"></td>
										</tr>
										<tr>
											<td><img src="../../images/member/text_07.gif" /></td>
											<td>
												<input name="mbJumin1" type="text" class="input" style="width:100px;" maxlength="6" onKeyUp="if(this.value.match(/[^0-9]/)) { alert('숫자만 넣어주세요'); this.value = ''; this.focus(); return false; };lengthCheck( this.form, this );">
												-
												<input name="mbJumin2" type="password" class="input" style="width:100px;" maxlength="7" onKeyUp="if(this.value.match(/[^0-9]/)) { alert('숫자만 넣어주세요'); this.value = ''; this.focus(); return false; };">
											</td>
										</tr>
										<tr>
											<td height="2" colspan="2"></td>
										</tr>
										<tr>
											<td><img src="../../images/member/text_09.gif" width="83" height="13" /></td>
											<td>
												<input name="mbEmail" type="text" class="input" id="textfield3232" style="width:214px" />
												<input type="image" src="../../images/member/btn_confirm02.gif" alt="확인" border="0" align="absmiddle" />
											</td>
										</tr>
									</form>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td><img src="../../images/member/box4_bottom.gif" /></td>
				</tr>
			</table>
			<!---비밀번호 찾기(e)--->
		</td>
	</tr>
	<tr>
		<td align="right" style="padding:7px 11px 0px 0px"><img src="../../images/member/text_10.gif" width="211" height="18" /><img src="../../images/member/btn_03.gif" alt="이메일 찾기" border="0" onclick="popEmail();" style="cursor:pointer"></td>
	</tr>
</table>