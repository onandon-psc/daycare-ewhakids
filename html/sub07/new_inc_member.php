<tr>
	<td>
		<!---정보입력--->
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableA">
			<tr>
				<td width="152" class="input_tit">아이디</td>
				<td width="503" class="input_item">
				<? if( ( $pno == "080101" && $row['mbId']) || $_SESSION['member_level']=="9"){ ?>
					<input type="hidden" name="mbId" value="<?=$row['mbId']?>"><?=$row[mbId]?>
				<? }else{ ?>
					<input name="mbId" type="text" class="input" id="textfield2" style="width:150px;IME-MODE:inactive" />
					<img src="../../images/member/btn_iddouble.gif" align="absmiddle" onclick="popId2();" style="cursor:pointer">
				<? } ?>
				</td>
			</tr>
			<tr>
				<td class="input_tit">부모이름</td>
				<td class="input_item">
				<? 
					if( ( $pno == "080101" && $row['mbId']) || $_SESSION['member_level']=="9"){ 

						if($row[mbStatus]=='A')
						{
				?>
					<input name="mbName" type="text" value="<?=$row['mbName']?>" class="input" id="textfield23" style="width:150px;IME-MODE:active" />
				<?		}
						else
						{
				?>
					<input type="hidden" name="mbName" value="<?=$row['mbName']?>"><?=$row[mbName]?>
				<?
						}
					}
					else
					{ 
				?>
					<input name="mbName" type="text" value="<?=$row['mbName']?>" class="input" id="textfield23" style="width:150px;IME-MODE:active" />
				<? } ?>						
				</td>
			</tr>
			<tr>
				<td class="input_tit">생년월일 및 성별 </td>
				<td class="input_item">
				<? if( ( $pno == "080101" && $row['mbId']) || $_SESSION['member_level']=="9"){ 
					$tmp_sex = "";
					$tmp_birth = substr($exJumin[0],0,2)."-".substr($exJumin[0],2,2)."-".substr($exJumin[0],4,2);

					if(substr($exJumin[1],0,1)=='1' || substr($exJumin[1],0,1)=='3'){ $tmp_sex = '남'; } else { $tmp_sex = '여'; }
					if(substr($exJumin[1],0,1) > 2) { $tmp_birth = "20".$tmp_birth; } else { $tmp_birth = "19".$tmp_birth; }
					echo $tmp_birth." (".$tmp_sex.")";
				?>
				<? }else{ ?>					
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
				<? } ?>
				</td>
			</tr>
			<tr>
				<td class="input_tit"><?=$modeValue=="modify2"?"기존":""?> 비밀번호 </td>
				<td class="input_item">
					<input name="mbPwd" type="password" class="input" id="textfield" style="width:150px" />
					<span class="text11_or">(비밀번호는 6~16자리의 영문과 숫자 조합)</span> </td>
			</tr>
			<tr>
				<td class="input_tit"><?=$modeValue=="modify2"?"비밀번호 변경":"비밀번호확인"?> </td>
				<td class="input_item">
					<input name="mbPwd2" type="password" class="input" id="textfield7" style="width:150px" />
					<span class="text11_or"><?=$modeValue=="modify2"?"(비밀번호 변경시 입력하세요.)":"(비밀번호를 한번 더 입력해주세요.)"?></span></td>
			</tr>
			<tr>
				<td class="input_tit">이메일주소</td>
				<td class="input_item">
					<input name="mbEmail1" type="text" class="input" style="width:100;IME-MODE:disabled;"  value="<?=$exEmail[0]?>"/>
					@
					<input name="mbEmail2" type="text" class="input" style="width:100;IME-MODE:disabled;"  value="<?=$exEmail[1]?>"/>
					<select class="list" onChange="if(this.value=='NONE'){this.form.mbEmail2.select();this.form.mbEmail2.focus();}else{this.form.mbEmail2.value=this.value;}">
						<option selected="selected" value="">선택하세요</option>
						<option value="hanmail.net">hanmail.net</option>
						<option value="naver.com">naver.com</option>
						<option value="nate.com">nate.com</option>
						<option value="hotmail.com">hotmail.com</option>							
						<option value="yahoo.co.kr">yahoo.co.kr</option>
						<option value="empal.com">empal.com</option>							
						<option value="paran.com">paran.com</option>
						<option value="lycos.co.kr">lycos.co.kr</option>							
						<option value=NONE>직접입력</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="input_tit">국회소속부처</td>
				<td class="input_item">
					<input name="mbGroup" type="text" value="<?=$row['mbGroup']?>" class="input" id="textfield34" style="width:150px" />
				</td>
			</tr>
			<!--
			<tr>
				<td class="input_tit" style="border-bottom:none;">닉네임</td>
				<td class="input_item" style="border-bottom:none;">
					<input name="mbNick" type="text" value="<?=$row['mbNick']?>" class="input" id="textfield35" style="width:150px" />
				</td>
			</tr>
			-->
		</table>
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td class="tit_lv1"><img src="../../images/member/stitle_11.gif" /></td>
</tr>
<tr>
	<td>
		<table id="childTable" width="100%" border="0" cellspacing="0" cellpadding="0" class="tableA">
			<tr>
				<td width="48" class="input_tit1">&nbsp;</td>
				<td width="179" align="center" class="input_tit1">자녀성명</td>
				<td width="270" align="center" class="input_tit1">자녀 생년월일  <span style="font size:10px">ex) <?=date("Y-m-d")?></span></td>
				<td width="158" class="input_tit1">&nbsp;</td>
			</tr>				
			<?
			if($childRows){
				$n = 0;
				foreach($childRows as $k => $childrow){
					$n+=1;
			?>
			<tr>
				<td align="center" class="input_item2"><?if($n==1){echo"-";}else{?><img src="../../images/member/btn_del.gif" style="cursor:pointer" onclick="_f_del(this)"><?}?></td>
				<td align="center" class="input_item2"><input name="childName[<?=$n?>]" type="text" value="<?=$childrow["childName"]?>" class="input" id="textfield62" maxlength="50" style="width:150px;IME-MODE:active" /></td>
				<td align="center" class="input_item2"><input name="childBirth[<?=$n?>]" type="text" value="<?=$childrow["childBirth"]?>" class="input" id="textfield62" maxlength="10" style="width:150px;" /></td>				
				<?if($k==0){?>
				<td rowspan="2" class="input_item center" style="border-bottom:none;"><img src="../../images/member/btn_ki.gif" style="cursor:pointer" onclick="_f_add()"></td>
				<?}?>
			</tr>
			<?
				}
			}else{
			?>		
			<tr>
				<td align="center" class="input_item2">-</td>
				<td align="center" class="input_item2">
					<input name="childName[1]" type="text" class="input" id="textfield62" maxlength="50" style="width:150px;IME-MODE:active" />
				</td>
				<td align="center" class="input_item2"><span class="input_item" style="border-bottom:none;">
					<input name="childBirth[1]" type="text" class="input" id="textfield62" maxlength="10" style="width:150px;" />
				</td>
				<td rowspan="2" class="input_item center" style="border-bottom:none;"><img src="../../images/member/btn_ki.gif" alt="자녀추가" border="0" align="absmiddle" style="cursor:pointer" onclick="_f_add()"></td>
			</tr>		
			<? } ?>
		</table>
	</td>
</tr>

<table id="hiddenChildTable" style="display:none">
	<tr class="input_item2">
		<td align="center" class="input_item2"><img src="../../images/member/btn_del.gif" style="cursor:pointer" onclick="_f_del(this)"></td>
		<td align="center" class="input_item2">
			<input name="childName[0]" type="text" class="input" id="textfield62" maxlength="50" style="width:150px;IME-MODE:active" />
		</td>
		<td align="center" class="input_item">
			<input name="childBirth[0]" type="text" class="input" maxlength="10" style="width:150px;"/>
		</td>		
	</tr>
</table>