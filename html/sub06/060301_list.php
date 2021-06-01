<?
	include "../../ewhaMaster/common/admin_login_check2.php";

	if($search && $keyword) $whereAnd .= " && ($search like '%$keyword%')";

	$whereAnd2 = "";

	if(!$childAge) $childAge = "Z";
	 
	if($childAge)
	{
		switch($childAge)
		{
			case "C":
				$year = date('Y') - 1; 
				//$whereAnd .= " && childBirth like ('$year%') && '".date('Y-m-d')."' < childBirth ";
				$whereAnd .= " && left(childBirth,4)='".$year."' ";
				$whereAnd2 = " && left(childBirth,4)='".$year."' ";
				break;

			case "A":
				$year = date('Y') - $childAge; 
				//$whereAnd .= " && childBirth like ('$year%') && '".date('Y-m-d')."' < childBirth ";
				$whereAnd .= " && ('".date('Y-m-d')."' < childBirth or left(childBirth,4)='".$year."') ";
				$whereAnd2 = " && ('".date('Y-m-d')."' < childBirth or left(childBirth,4)='".$year."') ";
				break;
			
			case "Z":
				$year = date('Y'); 
				//$whereAnd .= " && childBirth like ('$year%') && '".date('Y-m-d')."' < childBirth ";
				$whereAnd .= " && (('".$year."-09-01' > childBirth and left(childBirth,4)='".$year."') or ('".substr($year,2,3)."0831' > left(childJumin,6) and left(childJumin,2)='".substr($year,2,3)."'))";
				$whereAnd2 = " && (('".$year."-09-01' > childBirth and left(childBirth,4)='".$year."') or ('".substr($year,2,3)."0831' > left(childJumin,6) and left(childJumin,2)='".substr($year,2,3)."'))";
				break;

			default:
				$year = date('Y') - ($childAge); 
				$whereAnd .= " && (left(childBirth,4)='".$year."' or left(childJumin,2)='".substr($year,2,3)."')";
				$whereAnd2 = " && (left(childBirth,4)='".$year."' or left(childJumin,2)='".substr($year,2,3)."')";
				break;
		}
	}

	$query	= "select *,
					(select count(*) from ona_application a where 1 $whereAnd2 
					&& (class3 < ona_application.class3)
					) sortno1
					,
					(select count(*) from ona_application b where 1 $whereAnd2 
					&& (class3 = ona_application.class3) && (class4 < ona_application.class4) 
					) sortno2
					,
					(select count(*) from ona_application b where 1 $whereAnd2 
					&& (class3 = ona_application.class3) && (class4 = ona_application.class4) && (regdate < ona_application.regdate) 
					) sortno3
					,
					(select count(*) from ona_application b where 1 $whereAnd2
					&& (class3 = ona_application.class3) && (class4 = ona_application.class4) && (regdate = ona_application.regdate) && (idx < ona_application.idx) 
					) sortno4
					FROM ona_application WHERE 1 $whereAnd
					ORDER BY class3 desc, class4 desc, regdate desc, idx desc";
	
	//$query	= "SELECT *,(select count(*) from ona_application a where left(childBirth,4)=left(ona_application.childBirth,4) and regdate < ona_application.regdate)+1 sortno FROM ona_application WHERE 1 $whereAnd ORDER BY class3 desc, class4 desc, regdate desc";
	
	//echo $query;
	$result	= mysql_query($query);
	$nums	= @mysql_num_rows($result);

	if(!$total_count) $total_count = 10;

	if ($page == "") $page = "1";
	$url				= $PHP_SELF."?pno=$pno&search=$search&keyword=$keyword&childAge=$childAge";
	$total_page	= ceil($nums/$total_count);
	$set_page 	= $total_count * ($page-1);
	$list_page 	= 10;
	$last 			= $page * $total_count;

	$paging		= common_paging($url,$nums,$page,$list_page,$total_count);
	if ($last > $nums) $last = $nums;
?>

<script language="javascript">
<!--
	function onClickKind(v){
		f = document.frm;
		f.childAge.value = v;
		f.page.value = 1;
		f.mode.value = "";
		f.submit();
	}

	function goView(v1){
		f = document.frm;
		f.mode.value = "view";
		f.idx.value = v1;
		f.submit();
	}
//-->
</script>

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
						<!---tab--->
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td style="padding-bottom:26px;"> </td>
							</tr>
							<tr>
								<td height="34" background="../../images/sub04/tab_bg.gif" style="padding:0px 0px 0px 22px">
									<table border="0" cellspacing="0" cellpadding="0">
									<form name="frm" method="post" action="<?=$_SERVER['PHP_SELF']?>">
										<input type="hidden" name='pno' value='<?=$pno?>'>

										<input type="hidden" name="mode">
										<input type="hidden" name="idx">

										<input type="hidden" name="childAge" value="<?=$childAge?>">
										<input type="hidden" name="page" value="<?=$page?>">
										<input type="hidden" name="search">
										<input type="hidden" name="keyword">
										<tr>
											<td style="padding:0px 5px 0px 0px"><img src="../../images/sub06/tab007<?if($childAge=='Z'||$childAge=='') echo'_on'?>.gif" id="Image1" onMouseOver="MM_swapImage('Image1','','../../images/sub06/tab007_on.gif',1)" onMouseOut="MM_swapImgRestore()" onClick="onClickKind('Z')" style="cursor:pointer"></td>
											<!-- <td style="padding:0px 5px 0px 0px"><img src="../../images/sub06/tab002<?=$childAge=='B'?'_on':''?>.gif" name="Image2" id="Image2" onMouseOver="MM_swapImage('Image2','','../../images/sub06/tab002_on.gif',1)" onMouseOut="MM_swapImgRestore()" onClick="onClickKind('B')" style="cursor:pointer"></td> -->
											<!--td style="padding:0px 5px 0px 0px"><img src="../../images/sub06/tab003<?=$childAge=='C'?'_on':''?>.gif" name="Image3" id="Image3" onMouseOver="MM_swapImage('Image3','','../../images/sub06/tab003_on.gif',1)" onMouseOut="MM_swapImgRestore()" onClick="onClickKind('C')" style="cursor:pointer"></td-->
											<td style="padding:0px 5px 0px 0px;"><img src="../../images/sub06/tab001<?=$childAge=='1'?'_on':''?>.gif" id="Image2" onMouseOver="MM_swapImage('Image2','','../../images/sub06/tab001_on.gif',1)" onMouseOut="MM_swapImgRestore()" onClick="onClickKind('1')" style="cursor:pointer"></td>
											<td style="padding:0px 5px 0px 0px;"><img src="../../images/sub06/tab002<?=$childAge=='2'?'_on':''?>.gif" id="Image3" onMouseOver="MM_swapImage('Image3','','../../images/sub06/tab002_on.gif',1)" onMouseOut="MM_swapImgRestore()" onClick="onClickKind('2')" style="cursor:pointer"></td>
											<td style="padding:0px 5px 0px 0px;"><img src="../../images/sub06/tab003<?=$childAge=='3'?'_on':''?>.gif" id="Image4" onMouseOver="MM_swapImage('Image4','','../../images/sub06/tab003_on.gif',1)" onMouseOut="MM_swapImgRestore()" onClick="onClickKind('3')" style="cursor:pointer"></td>
											<td style="padding:0px 5px 0px 0px;"><img src="../../images/sub06/tab004<?=$childAge=='4'?'_on':''?>.gif" id="Image5" onMouseOver="MM_swapImage('Image5','','../../images/sub06/tab004_on.gif',1)" onMouseOut="MM_swapImgRestore()" onClick="onClickKind('4')" style="cursor:pointer"></td>
											<td style="padding:0px 5px 0px 0px;"><img src="../../images/sub06/tab005<?=$childAge=='5'?'_on':''?>.gif" id="Image6" onMouseOver="MM_swapImage('Image6','','../../images/sub06/tab005_on.gif',1)" onMouseOut="MM_swapImgRestore()" onClick="onClickKind('5')" style="cursor:pointer"></td>
											<td style="padding:0px 5px 0px 0px;"><img src="../../images/sub06/tab006<?=$childAge=='6'?'_on':''?>.gif" id="Image7" onMouseOver="MM_swapImage('Image7','','../../images/sub06/tab006_on.gif',1)" onMouseOut="MM_swapImgRestore()" onClick="onClickKind('6')" style="cursor:pointer"></td>
										</tr>
									</form>
									</table>
								</td>
							</tr>
							<tr>
								<td style="padding:0px 0px 5px 3px">&nbsp;</td>
							</tr>
							<tr>
								<td> </td>
							</tr>
						</table>
						<!---tab(e)--->
					</td>
				</tr>
				<tr>
					<td>
						<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
							<tr>
								<td>
									<!--검색(s)-->
									<table width="100%" height="36" border="0" cellpadding="0" cellspacing="0" background="../../images/skin/search_bg.gif">
									<form name="searchForm" method="get" action="<?=$PHP_SELF ?>">
										<input type="hidden" name='pno' value='<?=$pno?>'>
										<input type="hidden" name='childAge' value='<?=$childAge?>'>
										<tr>
											<td height="35" align="center" background="../../images/common/search_bg.gif">										
												<select name="search" class="list">
													<option value="childName" <?if($search == "childName"){echo"selected";}?>>유아명</option>
													<option value="parentName" <?if($search == "parentName"){echo"selected";}?>>보호자명</option>
												</select>
												<input name="keyword" type="text" class="input" id="textfield" style="width:180px;" value="<?=$keyword?>">
												<input type="image" src="../../images/btn/btn_search1.gif" alt="검색" align="absmiddle" style="cursor:pointer">
											</td>
										</tr>
										<tr>
											<td height="14"></td>
										</tr>
									</form>
									</table>
									<!--검색(e)-->
									<!--list(s)-->
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td>
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td height="2" colspan="5" class="bline1"></td>
													</tr>
													<tr>
														<td width="63" align="center" class="btitle1">번호(순위)</td>
														<td width="166" align="center" class="btitle1">유아명</td>
														<td width="45" align="center" class="btitle1">성별</td>
														<td width="166" align="center" class="btitle1">보호자명</td>
														<td width="215" align="center" class="btitle1">신청일</td>
													</tr>
													<tr>
														<td height="1" colspan="5" class="bline2"></td>
													</tr>
												</table>
											</td>
										</tr>
										<?
											$no = $nums - $set_page;

											if ($nums){
												for ($i = $set_page; $i < $last; $i++){
												@mysql_data_seek($result,$i);
												$row= mysql_fetch_array($result);	
												
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

												$tmp_id = "";
												$tmp_id = substr($row[mbId],0,2);
												for($j = 0; $j < strlen($row[mbId])-3; $j++)
												{
													$tmp_id = $tmp_id."*";
												}
												$tmp_id = $tmp_id.substr($row[mbId],strlen($row[mbId])-1,1);

												$tmp_name = "";
												$tmp_name = "";
												$tmp_name = substr($row[parentName],0,2);
												
												if(strlen($row[parentName]) < 5)
												{
													$tmp_name = $tmp_name."*";
												}
												else
												{
													for($j = 0; $j < (strlen($row[parentName])-4)/2; $j++)
													{
														$tmp_name = $tmp_name."*";
													}
													$tmp_name = $tmp_name.substr($row[parentName],strlen($row[parentName])-2,2);
												}
										?>
										<tr>
											<td>
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td width="63" align="center" class="bcontent"><?=$no?>
															<? 
																$tmp =  $row[sortno1]+$row[sortno2]+$row[sortno3]+$row[sortno4]+1;
															?>
																(<?=$tmp?>)
														</td>
														<td width="166" align="center" class="bcontent">
														<?
															if($_SESSION[masterSession]){
																echo "<a href=\"javascript:goView('".$row[idx]."')\"><b>".$row[childName]."</b></a>";
															}else{
																echo $row[childName];
															}
														?>
														</td>
														<td width="45" align="center" class="bcontent"><?=$temp_sex?></td>
														<td width="166" align="center" class="bcontent">
														<?
															if($_SESSION[masterSession]){
																echo "<a href=\"javascript:goView('".$row[idx]."')\">".$row[parentName]."</a>";
															}else{
																if($_SESSION[member_id] == 'onandon')
																{
																	if($_SESSION[member_id] == $row[mbId])
																	{
																		echo "<a href=\"javascript:goView('".$row[idx]."')\">".$row[parentName]."(".$tmp_id.")</a>";
																	}
																	else
																	{
																		echo $row[parentName]."(".$tmp_id.")";
																	}
																}
																else
																{
																	if($_SESSION[member_id] == $row[mbId])
																	{
																		echo "<a href=\"javascript:goView('".$row[idx]."')\">".$tmp_name."(".$tmp_id.")</a>";
																	}
																	else
																	{
																		echo $tmp_name."(".$tmp_id.")";
																	}
																}
															}
														?>
														</td>
														<?
															if($_SESSION[masterSession])
															{
																$tmp_regdate = date("Y.m.d H:m:i", $row[regdate]);
															}
															else
															{
																$tmp_regdate = date("Y.m.d", $row[regdate]);
															}
														?>
														<td width="215" align="center" class="bcontent"><?=$tmp_regdate?></td>
													</tr>
													<tr>
														<td height="1" colspan="5" class="bline3"></td>
													</tr>
												</table>												
											</td>
										</tr>
										<? 
												$no = $no-1;
												}
											}else{ // 게시물이 없을때
										?>
										<tr>
											<td>
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td align="center" class="bcontent"><font color="#444444">게시물이 없습니다.</font></td>
													</tr>
													<tr>
														<td height="1" colspan="5" class="bline3"></td>
													</tr>
												</table>
											</td>
										</tr>
										<?	
											}
										?>
									</table>
									<!--list(e)-->
									<!--page&button(s)-->
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td align="center" style="padding:14 0 0 0;">
												<?if($nums){echo"$paging[paging]";}else{echo"&nbsp;";} ?>
<? if($_SESSION[masterSession]){ ?>
												<span style='float:right;border:1px solid #aaaaaa; padding:2 6 2 6'><a href=/ewhaMaster/sub/index.php?msChk=master&pno=060201>입소신청</a></span>
<?}?>
											</td>
										</tr>
									</table>
									<!--page&button(e)-->
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<? 
	if($_SESSION[masterSession]){ 
	$arrSelect = array(
							  "" => "전체"
							, "Z" => "0세 미만"
							, "1" => "0세"
							, "2" => "1세"
							, "3" => "2세"
							, "4" => "3세"
							, "5" => "4세"
							, "6" => "5세"
						);
?>
<table width="655" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center" style="padding:20 0 0 0">
			<table cellspacing="1" cellpadding="0" border="0" bgColor="#98D952">
				<tr>
					<td style="padding:1px">
						<table bgColor="#F2F7EF">
						<form method="post" action="/html/sub06/060301_excel.php">
							<tr>
								<td style="padding:0 3 0 3"><b>Excel Download : </b></td>
								<td>
									<select name="childAge">
										<? foreach( $arrSelect As $k => $v){?>
											<option value="<?=$k?>"><?=$v?></option>
										<?}?>
									</select>
								</td>
								<td>&nbsp;<input type="submit" value="다운로드"></td>
							</tr>
						</form>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<? } ?>