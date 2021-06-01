<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td style="padding-bottom:26px;"> </td>
	</tr>
	<tr>
		<td class="img_copy"><img src="../../images/member/img_07.gif" /></td>
	</tr>
	<tr>
		<td>
			<table width="635" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td width="181" rowspan="3" valign="top"><img src="../../images/member/img_08.gif" /></td>
					<td width="421" valign="top"><img src="../../images/member/img_10.gif" /></td>
					<td width="33" rowspan="3" valign="top"><img src="../../images/member/img_09.gif" /></td>
				</tr>
				<tr>
					<td valign="top">
						<table width="402" border="0" cellspacing="0" cellpadding="0">
						<form name="loginFrm" method="post" action="/html/sub07/070101_proc.php" onSubmit="return login_check(this)" target="iframe">	
							<input type="hidden" name="ret_host" value="<?=$_SERVER['HTTP_HOST']?>">
							<input type="hidden" name="ret_url" value="<?=$_REQUEST['ret_url']?>">
							<tr>
								<td height="89" align="left" valign="top" background="../../images/member/img_bg1.gif" style="padding:15px 0px 0px 28px">
									<!---로그인--->
									<table border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td>
												<img src="../../images/member/txt_01.gif" align="absmiddle" />
												<input name="mbId" type="text" class="input_type01" id="name2" style="width:180px;ime-mode:inactive" tabindex="1">
											</td>
											<td rowspan="3" style="padding-left:7px;"><input type="image" src="../../images/member/btn_login.gif" alt="로그인" /></td>
										</tr>
										<tr>
											<td height="4"></td>
										</tr>
										<tr>
											<td>
												<img src="../../images/member/txt_02.gif" align="absmiddle" />
												<input name="mbPwd" type="password" class="input_type01" id="name" style="width:180px;" tabindex="2">
											</td>
										</tr>
									</table>
									<!---로그인 (e)--->
								</td>
							</tr>
						</form>
						</table>
					</td>
				</tr>
				<tr>
					<td height="34" valign="top"><img src="../../images/member/text_03.gif" /></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td style="padding:28px 0px 0px 0px">
			<table width="615" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td><img src="../../images/member/box3_top.gif" /></td>
				</tr>
				<tr>
					<td background="../../images/member/box3_bg.gif" style="padding:0px 31px 0px 31px">
						<!---회원가입, 아이디/비밀번호찾기--->
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="33%"><img src="../../images/member/text_04.gif" width="178" height="18" /><a href="javascript:menu('7','2','1')"><img src="../../images/member/btn_01.gif" alt="회원가입" border="0" /></a></td>
							</tr>
							<tr>
								<td><img src="../../images/member/text_05.gif" /><a href="javascript:menu('7','3','1')"><img src="../../images/member/btn_02.gif" alt="아이디/비밀번호 찾기" width="133" height="18" border="0" /></a></td>
							</tr>
						</table>
						<!---회원가입, 아이디/비밀번호찾기(e)--->
					</td>
				</tr>
				<tr>
					<td><img src="../../images/member/box3_bottom.gif" /></td>
				</tr>
			</table>
		</td>
	</tr>
</table>