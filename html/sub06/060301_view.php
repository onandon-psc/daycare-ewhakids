<?
	include "../../ewhaMaster/common/admin_login_check2.php";

	$idx	 =	 trim($_POST[idx]);

	$query	= "SELECT * FROM ona_application WHERE idx='".$idx."' ORDER BY idx DESC";
	//echo $query;
	$result	= mysql_query($query);
	$row	 	= mysql_fetch_array($result);

	if(!$_SESSION[masterSession]) {
		if($_SESSION[member_id] != $row[mbId])
		{
			echo "<script>alert('회원정보가 일치하지 않습니다!!!');location.href='/html/sub/index.php?pno=060301'</script>";
			exit;
		}
	}

?>

<script>
function delete_check(){
	if(confirm('삭제하시겠습니까?')){
		document.getElementsByName('delete_form')[0].submit();
	}
}
function modify(idx){
	document.modify_form.modify_idx.value = idx;
	document.modify_form.submit();
}
</script>
<? if($_SESSION[masterSession]) { ?>
<form name="modify_form" method="get" action='http://ewhakids.or.kr/ewhaMaster/sub/index.php'>
<input type="hidden" name="msChk" value="master">
<input type="hidden" name="pno" value="060201">
<input type="hidden" name="modify_idx" value="">
<input type="hidden" name="childAge" value="<?=$childAge?>">
<input type="hidden" name="page" value="<?=$page?>">
</form>
<? } else { ?>
<form name="modify_form" method="get" action='http://ewhakids.or.kr/html/sub/index.php'>
<input type="hidden" name="msChk" value="">
<input type="hidden" name="pno" value="060201">
<input type="hidden" name="modify_idx" value="">
<input type="hidden" name="childAge" value="<?=$childAge?>">
<input type="hidden" name="page" value="<?=$page?>">
</form>
<? } ?>

<form name=delete_form method=post action='/html/sub06/060201_proc.php' target="iframe">
<input type=hidden name=idx value='<?=$idx;?>' >
<input type=hidden name=send value='delete' >
<input type="hidden" name="childAge" value="<?=$childAge?>">
<input type="hidden" name="page" value="<?=$page?>">
</form>

<table width="655" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td style="padding-bottom:26px;"> </td>
	</tr>
	<tr>
		<td align="center"> </td>
	</tr>
	<tr>
		<td align="center">
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td style="padding-bottom:26px;"> </td>
				</tr>
				<tr>
					<td>
						<!---정보입력--->
						<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableA">
							<tr>
							<?
								$waittype = '';
								if(strpos($row[waittype],'14')===false){
								}
								else
								{
									$waittype .= '2014년 충원시';
								}

								if(strpos($row[waittype],'15')===false){
								}
								else
								{
									if($waittype != '')
									{
										$waittype .= ', 2015년 신입학';
									}
									else
									{
										$waittype .= '2015년 신입학';
									}
								}
							?>
								<td width="143" class="input_tit">입소희망년</td>
								<td width="513" class="input_item"><?=$waittype?>&nbsp;</td>
							</tr>
							<tr>
								<td width="143" class="input_tit">자녀명</td>
								<td width="513" class="input_item"><?=$row[childName]?>&nbsp;</td>
							</tr>
							<? if($row[childBirth] != '') { ?>

							<tr>
								<td class="input_tit">생년월일</td>
								<td class="input_item"><?=$row[childBirth]?>&nbsp;</td>
							</tr>
							<? } else { ?>
							<tr>
								<td class="input_tit">생년월일</td>
								<td class="input_item"><?=substr($row[childJumin],0,6)?>&nbsp;</td>
							</tr>
							<? } ?>
							<?
							  $temp_sex = '';
							  if($row[sex] == '1')
							  {
								  $temp_sex = '남';
							  }
							  else if($row[sex] == '2')
							  {
								  $temp_sex = '여';
							  }
							  else
							  {
								  $temp_sex = '미입력';
							  }
							?>
							<tr>
								<td class="input_tit">성별</td>
								<td class="input_item"><?=$temp_sex?>&nbsp;</td>
							</tr>
							<tr>
								<td class="input_tit">부모명</td>
								<td class="input_item"><?=$row[parentName]?>&nbsp;</td>
							</tr>
							<?
								$tmp_app = '';

								if($row[class3] == '1')
								{
									$tmp_app = '국회 공무원';
								}
								else if($row[class3] == '3')
								{
									$tmp_app = '무기계약 근로자 및 직영후생시설 종사자';
								}
								else if($row[class3] == '5')
								{
									$tmp_app = '의원실 인턴 및 국회내 기간제 근로자 및 국회내 상주 정당관계자 및 6개월 이상 상시출입기자';
								}
								else if($row[class3] == '7')
								{
									$tmp_app = '국회내 상주업체 종사자';
								}
								else if($row[class3] == '9')
								{
									$tmp_app = '국회 보조금 지원받는 법인 및 단체 종사자';
								}
							?>
							<tr>
								<td class="input_tit">입소대상 </td>
								<td class="input_item"><?=$tmp_app?>&nbsp;</td>
							</tr>
							<tr>
								<td class="input_tit">소속부처1 </td>
								<td class="input_item"><?=$row[class1]?>&nbsp;</td>
							</tr>
							<tr>
								<td class="input_tit">소속부처2</td>
								<td class="input_item"><?=$row[class2]?>&nbsp;</td>
							</tr>
							<tr>
								<td class="input_tit">직급</td>
								<td class="input_item"><?=$row[position1]?>&nbsp;</td>
							</tr>
							<tr>
								<td class="input_tit">직위</td>
								<td class="input_item"><?=$row[position2]?>&nbsp;</td>
							</tr>
							<?
								$tmp_ht = explode(",",$row[homeType]);
								foreach( $tmp_ht as $v)
								{
									switch($v){
										case "0세" :
											$tmp_hometype[] = "출생예정";
											break;
										case 'a' :
											$tmp_hometype[] = "한부모";
											break;
										case 'b' :
											$tmp_hometype[] = "저소득";
											break;
										case 'c' :
											$tmp_hometype[] = "부모장애";
											break;
										case 'd' :
											$tmp_hometype[] = "자녀의 형제장애";
											break;
										case 'e' :
											$tmp_hometype[] = "다문화 가정";
											break;
										case 'f' :
											$tmp_hometype[] = "조손가정";
											break;
										case 'g' :
											$tmp_hometype[] = "맞벌이";
											break;
										case 'h' :
											$tmp_hometype[] = "두자녀 및 세자녀";
											break;
										case 'i' :
											$tmp_hometype[] = "기타저소득(3,4층)";
											break;
										case 'j' :
											$tmp_hometype[] = "입양유아";
											break;
										case 'k' :
											$tmp_hometype[] = "재원형제";
											break;
										case 'l' :
											$tmp_hometype[] = "해당없음";
											break;
									}
								}
								$tmp_hometype = implode(", ",$tmp_hometype);
							?>
							<tr>
								<td class="input_tit">가정분류</td>
								<td class="input_item"><?=$tmp_hometype?>&nbsp;</td>
							</tr>
							<tr>
								<td class="input_tit">대기날짜</td>
								<td class="input_item"><?=date("Y-m-d",$row[regdate])?>&nbsp;</td>
							</tr>
							<tr>
								<td class="input_tit">구내번호</td>
								<td class="input_item"><?=$row[telephone]?>&nbsp;</td>
							</tr>
							<tr>
								<td class="input_tit">핸드폰 번호 </td>
								<td class="input_item"><?=$row[mobile]?>&nbsp;</td>
							</tr>
							<tr>
								<td class="input_tit">이메일</td>
								<td class="input_item"><?=$row[email]?>&nbsp;</td>
							</tr>
							<tr>
								<td class="input_tit" style="border-bottom:none;">재원중인 형제아의<br>
									이름/생년월일 </td>
								<td class="input_item" style="border-bottom:none;">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td style="padding:0px 0px 5px 0px">- 이름 : <?=$row[recordName]?><br>- 생년월일 : <?=$row[recordBirth]?>&nbsp;</td>
										</tr>										
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<form method="post" action="<?=$_SERVER['PHP_SELF']?>">
					<input type="hidden" name="pno" value="<?=$pno?>">
					<input type="hidden" name="childAge" value="<?=$childAge?>">
					<input type="hidden" name="page" value="<?=$page?>">
					<input type="hidden" name="search" value="<?=$search?>">
					<input type="hidden" name="keyword" value="<?=$keyword?>">
				<tr>
					<td class="button">
					<? if($_SESSION[masterSession]) { ?>
						<input type="image" src="../../images/sub06/btn_ok.gif" align="absmiddle" alt="취소" hspace="5" style="cursor:pointer" />
						&nbsp;&nbsp;
						<span style='border:1px solid #aaaaaa; padding:3 7 2 7'><a href="javascript:modify('<?=$idx;?>');">수정</a></span>
						&nbsp;&nbsp;
						<span style='border:1px solid #aaaaaa; padding:3 7 2 7'><a href='javascript:delete_check();'>삭제</a></span>
					<? } else { ?>
						<input type="image" src="../../images/sub06/btn_ok.gif" align="absmiddle" alt="취소" hspace="5" style="cursor:pointer" />
						&nbsp;&nbsp;
						<span style='border:1px solid #aaaaaa; padding:3 7 2 7'><a href="javascript:modify('<?=$idx;?>');">수정</a></span>
						&nbsp;&nbsp;
						<span style='border:1px solid #aaaaaa; padding:3 7 2 7'><a href='javascript:delete_check();'>삭제</a></span>
					<? } ?>
					</td>
				</tr>
				</form>
			</table>
		</td>
	</tr>
</table>