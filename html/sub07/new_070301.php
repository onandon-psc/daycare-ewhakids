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

		if (f.mbName.value=="") {
			alert("이름을 입력하십시오!!");
			f.mbName.focus();
			return false;
		}		
		
		if (f.mbEmail.value=="") {
			alert("이메일을 입력하십시오!!");
			f.mbEmail.focus();
			return false;
		}

		return;
		
	}

	function pwdCheck(f){

		if (f.mbId.value=="") {
			alert("아이디를 입력하십시오!!");
			f.mbId.focus();
			return false;
		}

		if (f.mbName.value=="") {
			alert("이름을 입력하십시오!!");
			f.mbName.focus();
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
									<form name="idSearchFrm" method="post" action="../sub07/member_idpw_proc2.php" onsubmit="return idCheck(this);" target="iframe">
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
									<form name="idPwdFrm" method="post" action="../sub07/member_idpw_proc2.php" onsubmit="return pwdCheck(this);" target="iframe">
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
											<td width="20%"><img src="../../images/member/text_06.gif" /></td>
											<td width="80%">
												<input name="mbName" type="text" class="input" id="textfield32" style="width:150px;ime-mode:active" />
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
		<td align="right" style="padding:7px 11px 0px 0px"><img src="../../images/member/text_10.gif" width="211" height="18" /><img src="../../images/member/btn_03.gif" alt="이메일 찾기" border="0" onclick="popEmail2();" style="cursor:pointer"></td>
	</tr>
</table>