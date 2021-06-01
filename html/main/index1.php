<!--- include Top(S) --->
<?
    include "../../include/global/config.php";
	include "../../include/html/top.php"; 

	$strnum = "40";
?>

<script language="javascript" src="../../include/js/popup.js"></script>
<script language="javascript" src="../../include/js/popup_open.js"></script>
<script language='javascript'>
<!--
    // 팝업
    function init_page(){
        init_popup();
    }
//-->
</script>

<script language="javascript">
<!--
	function locationChk(f){
		if(!f.pno.value){
			alert('반선택을 하십시오'); 
			return false;
		}											
	}

	function site_goto_select(sel, targetstr) {
		var index = sel.selectedIndex;
		if (sel.options[index].value != '') {
		if (targetstr == 'blank') {
			window.open(sel.options[index].value, 'win1');
		} else {
			var frameobj;
			if (targetstr == '') targetstr = 'self';
			if ((frameobj = eval(targetstr)) != null)
				frameobj.location = sel.options[index].value;
			}
		}
	}
//-->
</script>

<body topmargin="0" leftmargin="0" onLoad="init_page();">
<table width="980" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td>
			<script language="javascript">flash('980','392',"../../flash/visual_main.swf")</script>
		</td>
	</tr>
</table>
<!--- include Top(E) --->
<!--- Content(S) --->
<table width="980" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="19">&nbsp;</td>
		<td width="862" valign="top">
			<table width="862" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="207" valign="top">
						<table width="207" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td>
									<table width="207" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td><a href="#"><img src="../../images/main/img_01.gif" alt="입소신청" border="0" /></a></td>
										</tr>
										<tr>
											<td height="109" valign="top" background="../../images/main/img_bg.gif"style="padding:75px 0px 0px 108px"><a href="#"><img src="../../images/main/link_01.gif" alt="입소신청서 작성" border="0" /></a></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td height="12"></td>
							</tr>
							<tr>
								<td>
									<table width="207" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td><a href="/html/sub/index.php?pno=010101"><img src="../../images/main/link_02_1.gif" alt="시설소개" border="0" /></a></td>
										</tr>
										<tr>
											<td><a href="/html/sub/index.php?pno=010201"><img src="../../images/main/link_02_2.gif" alt="원장인사말" border="0" /></a></td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
					<td width="12" valign="top">&nbsp;</td>
					<td width="643" valign="top">
						<table width="643" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="424" height="156" valign="top" background="../../images/main/img_bg1.gif">
									<!---공지사항--->
									<table width="424" height="140" border="0" cellpadding="0" cellspacing="0">
										<tr>
											<td height="33" style="padding:24px 0px 0px 364px"><a href="../../html/sub/index.php?pno=030101"><img src="../../images/main/more.gif" /></a></td>
										</tr>
										<tr>
											<td style="padding:8px 33px 0px 36px" valign="top">
												<!---공지사항 리스트--->
												<table width="100%" border="0" cellpadding="0" cellspacing="0">
													<?
														$n = 0;
														$query	= "SELECT board_idx, board_subject, board_regdate FROM ona_board_030101 WHERE board_notice='Y' ORDER BY board_idx DESC limit 2";
														$result	= mysql_query($query);
														while ( $row = mysql_fetch_array($result) ){

															$today	= mktime();
															$dbday	= $row[board_regdate];
															$totday	= $today - $dbday; 				
														
															if($totday <= 86400){
																$new_img = "&nbsp;<img src='/images/common/icon_new.gif' border='0' align='absmiddle' style='margin:0 0 1 0;'>";
															}else{
																$new_img = "";
															}
													?>
													<tr>
														<td width="10"><img src="../../images/main/dot_01.gif" /></td>
														<td width="298" class="text_gray"><a href="../../html/sub/index.php?pno=030101&mode=view&board_idx=<?=$row[board_idx]?>"><?=trim_text($row[board_subject], $strnum)?></a> <?=$new_img?></td>
														<td width="50" class="text_gray"><?=date("y.m.d", $row[board_regdate]);?></td>
													</tr>
													<? 
														$n++;
														}
													
														$n = 5 - $n;
														$query	= "SELECT board_idx, board_subject, board_regdate FROM ona_board_030101 WHERE board_notice='N' ORDER BY board_idx DESC limit $n";
														$result	= mysql_query($query);
														while ( $row = mysql_fetch_array($result) ){

															$today	= mktime();
															$dbday	= $row[board_regdate];
															$totday	= $today - $dbday; 				
														
															if($totday <= 86400){
																$new_img = "&nbsp;<img src='../../images/common/icon_new.gif' border='0' align='absmiddle' style='margin:0 0 1 0;'>";
															}else{
																$new_img = "";
															}
													?>
													<tr>
														<td width="10"><img src="../../images/main/dot_01.gif" /></td>
														<td width="298" class="text_gray"><a href="../../html/sub/index.php?pno=030101&mode=view&board_idx=<?=$row[board_idx]?>"><?=trim_text($row[board_subject], $strnum)?></a> <?=$new_img?></td>
														<td width="50" class="text_gray"><?=date("y.m.d", $row[board_regdate]);?></td>
													</tr>
													<? } ?>
												</table>
												<!---공지사항 리스트(e)--->
											</td>
										</tr>
									</table>
									<!---공지사항(e)--->
								</td>
								<td width="12" valign="top"><img src="../../images/main/img_02.gif" /></td>
								<td width="207" valign="top" background="../../images/main/img_bg3.gif">
									<table width="207" border="0" cellspacing="0" cellpadding="0">
									<form action="../sub/index.php" onSubmit="return locationChk(this);">
										<tr>
											<!---유아마당 반선택--->
											<td height="95" valign="top" style="padding:59px 0px 0px 57px">
												<select name="pno" id="select3" style="width:95px;">
													<option value="">++ 반선택 ++</option>
													<option value="040101">해반 </option>
													<option value="040201">달반 </option>
													<option value="040301">별반 </option>
													<option value="040401">산반</option>
													<option value="040501">들반 </option>
													<option value="040601">강반 </option>
													<option value="040701">꽃반 </option>
													<option value="040801">나무반 </option>
													<option value="040901">샘물반 </option>
													<option value="041001">호수반 </option>
													<option value="041101">바다반 </option>
													<option value="041201">하늘반 </option>
												</select>
												<input type="image" src="../../images/main/btn_01.gif" alt="확인" border="0" align="absmiddle">
											</td>
											<!---유아마당 반선택(e)--->
										</tr>
										<tr>
											<td height="61" valign="top" style="padding:0px 17px 0px 17px"><a href="/html/sub/index.php?pno=010401"><img src="../../images/main/link_03.gif" alt="자세히보기" border="0" /></a></td>
										</tr>
									</form>
									</table>
								</td>
							</tr>
							<tr>
								<td height="12" colspan="3"></td>
							</tr>
						</table>
						<table width="643" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="424" valign="top">
									<!---오늘의 식단--->
									<table width="424" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td height="33" align="right" valign="top" background="../../images/main/img_bg2.gif" style="padding:17px 29px 0px 0px"><a href="/html/sub/index.php?pno=030201"><img src="../../images/main/more.gif" alt="자세히보기" border="0" /></a></td>
										</tr>
										<tr>
											<td>
												<!---식단 리스트--->
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td height="1" colspan="4" align="center" class="main_line"></td>
													</tr>
													<tr>
														<td width="90" align="center" class="cell_01">오전간식</td>
														<td width="134" class="cell_03">&nbsp;</td>
														<td width="63" align="center" class="cell_02">이유식</td>
														<td width="137" class="cell_03">&nbsp;</td>
													</tr>
													<tr>
														<td height="1" colspan="4" align="center" class="main_line"></td>
													</tr>
													<tr>
														<td align="center" class="cell_01">점심</td>
														<td colspan="3" class="cell_03">&nbsp;</td>
													</tr>
													<tr>
														<td height="1" colspan="4" align="center" class="main_line"></td>
													</tr>
													<tr>
														<td align="center" class="cell_01">오후간식</td>
														<td colspan="3" class="cell_03">&nbsp;</td>
													</tr>
													<tr>
														<td height="1" colspan="4" align="center" class="main_line"></td>
													</tr>
													<tr>
														<td align="center" class="cell_01">저녁</td>
														<td colspan="3" class="cell_03">&nbsp;</td>
													</tr>
													<tr>
														<td height="1" colspan="4" align="center" class="main_line"></td>
													</tr>
												</table>
												<!---식단 리스트(e)--->
											</td>
										</tr>
									</table>
									<!---오늘의 식단(e)--->
								</td>
								<td width="12">&nbsp;</td>
								<td width="207" valign="top">
									<table width="207" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<!---위탁운영기관--->
											<td height="79" valign="top" background="../../images/main/img_bg4.gif" style="padding:43px 0px 0px 21px">
												<select name="select" id="select" style="width:129px;" OnChange="site_goto_select(this, 'blank')">
													<option>++ 선택 ++</option>
													<option value="http://home.ewha.ac.kr/~educare/">이화 어린이 연구원 </option>
													<option value="http://www.ewha-kids.com/">이화여대 부속 유치원 </option>
													<option value="http://www.mcic.or.kr/">마포보육정보센터 </option>
												</select>
												<a href="#"><img src="../../images/main/btn_01.gif" alt="확인" border="0" align="absmiddle" /></a>
											</td>
											<!---위탁운영기관(e)--->
										</tr>										
										<tr>
											<td><img src="../../images/main/img_03.gif" /></td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
		<td width="99">&nbsp;</td>
	</tr>
</table>
<!--- Content(E) --->
<!--- Footer(S) --->
<? include "../../include/html/footer.php"; ?>
<!--- Footer(E) --->
