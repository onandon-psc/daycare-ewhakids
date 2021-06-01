	<? include "inc_0302.php"; ?>
	<? if(!$_SESSION[masterSession]){ ?>
	<tr>
		<td align="right" style="padding:5px 0 0 0">
			<table width="100%" cellspacing="0" cellpadding="0" border="0">			
				<tr>
					<td align="right"><img src="/images/btn/btn_excel.gif" align="absmiddle" onClick="saveToExcel('이유식식단')" style="cursor:pointer"></td>
				</tr>
			</table>			
		</td>
	</tr>
	<tr>
		<td style="padding:5px 0px 0px 5px">- <strong>초기이유식</strong>은 10배 죽 형태로,<br>
			- <strong>중기이유식</strong>은 밥알 잘게 으깬 5-6배 죽으로, <br>
			- <strong>후기이유식</strong>은 죽보다 씹을 수 있는 진밥으로 제공됩니다.</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>
			<!---유기농산물--->
			<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td><img src="../../images/sub03/box1_top.gif"></td>
				</tr>
				<tr>
					<td background="../../images/member/box3_bg.gif" style="padding:0px 31px 0px 31px">
						<!---회원가입, 아이디/비밀번호찾기--->
						<!---회원가입, 아이디/비밀번호찾기(e)--->
					</td>
				</tr>
				<tr>
					<td background="../../images/sub03/box1_bg.gif" style="padding:0px 31px 0px 31px">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="20%"><img src="../../images/sub03/img_02.gif"></td>
								<td width="80%" class="text11_gray3"> 
								*우리 농산물과 유기농 식자재를 사용하며 제철음식을 제공합니다.<br>
								* 쇠고기(국내산: 한우), 돼지고기, 닭고기, 쌀, 김치 등 식재료는 국내산만을 사용합니다.  <br>
								* 식단은 사정에 따라 같은 식품군으로 변경 될 수 있습니다. <br>
								* 김치는 유기농배추로 어린이집에서 직접 담궈 제공합니다.</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td><img src="../../images/sub03/box1_bottom.gif"></td>
				</tr>
			</table>
			<!---유기농산물(e)--->
		</td>
	</tr>	
	<? }else{ ?>
	<tr>
		<td align="right" style="padding:5 0 0 0">
			<table width="100%" cellspacing="0" cellpadding="0" border="0">			
				<tr>
					<td width="50%" align="left"><img src="/images/btn/btn_excel.gif" align="absmiddle" onClick="saveToExcel('code')" style="cursor:pointer"></td>
					<td width="50%" align="right"><font color="#FF0000">※ 식단 작성시 <b>날짜</b>를 클릭하십시오</font></td>
				</tr>
			</table>			
		</td>
	</tr>
	<? } ?>
</table>