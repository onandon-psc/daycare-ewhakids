<?
	include "../../include/global/config.php"; 
	include "../common/admin_login_check.php";				// 로그인 체크

	$query	= "SELECT * FROM ona_popup ORDER BY idx DESC";
	//echo $query;
	$result	= mysql_query($query);
	$nums	= @mysql_num_rows($result);

	if(!$total_count){ $total_count = 20; }

	if ($page == ""){ $page = "1"; }
	$url				= $PHP_SELF."?";
	$total_page	= ceil($nums/$total_count);
	$set_page 	= $total_count * ($page-1);
	$list_page 	= 10;
	$last 			= $page * $total_count;

	$paging		= common_paging($url,$nums,$page,$list_page,$total_count);
	if ($last > $nums){ $last = $nums; }
?>
<script language="javascript" src="../../include/js/choice.js"></script>
<script language='javascript'>
<!--
	function choiceClick(){

		f = document.listForm;

		var check_value = getChecked(f);

		if(!f.status.value){
			alert('일괄처리를 선택하세요');
			f.status.focus();
			return false;
		}

		if(check_value == ""){
			alert("변경 할 데이터를 선택하세요!");
			return false;
		}else{
			if(confirm('정말 변경하시겠습니까?')){
				f.choiceValue.value	= check_value;
				f.submit();
				return;
			}else{
				return false;	
			}
		}		
	}
//-->
</script>
<table width="100%" align="left" cellspacing="0" cellpadding="0" border="0">
	<tr>
		<td height="30" bgColor="#EFEFEF" style="padding:0 0 0 10"><b>▣ 팝업관리</b></td>
	</tr>
	<tr>
		<td style="padding:10 5 5 5">
			<table width='100%' border="0" cellpadding="0" cellspacing="1">

			<form name="listForm" method="post" action="popup_proc.php" target="iframe">
				 <input type="hidden" name="send" value="choice">
				 <input type="hidden" name="choiceValue">

				<tr bgcolor='#E7E7E7' align="center">
					<td width="5%" height="24">					
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="5"><input name="select_all" type="checkbox" onClick="onSelectAll()" value="1"></td>
								<td align="center"><b>번호</b></td>
							</tr>
						</table>
					</td>
					<td><b>팝업제목</b></td>
					<td width="14%"><b>게시일</b></td>
					<td width="10%"><b>팝업크기</b></td>
					<td width="7%"><b>그만보기</b></td>
					<td width="7%"><b>팝업형태</b></td>
					<td width="7%"><b>게시상태</b></td>
					<td width="7%"><b>등록일</b></td>
				</tr>
				<?  
				$no = $nums - $set_page;
				if ($nums)
				{
					for ($i = $set_page; $i < $last; $i++)
					{
						@mysql_data_seek($result,$i);
						$row= mysql_fetch_array($result);

						$expSize = explode("|",$row[sizeInfo]);
				?>
				<tr bgcolor=white align="center">
					<td height="24">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="5"><input type="checkbox" name="fcheck" value="<?=$row[idx]?>"></td>
								<td align="center"><?=$no?></td>
							</tr>
						</table>
					</td>	
					<td align="left" style="padding:0 0 0 5"><?="<a href='popup_write.php?idx=$row[idx]'><b>$row[subject]</b></a>";?></td>
					<td><? if($row[sdate] && $row[edate]) echo date("Y.m.d",$row[sdate])." ~ ".date("Y.m.d",$row[edate])?></td>
					<td><?="($expSize[0],$expSize[1],$expSize[2],$expSize[3])";?></td>
					<td><?="$row[visionDay]일";?></td>
					<td><?=$row[openType]=="P"?"팝업창":"<font color='green'>브라우져내</font>"?></td>
					<td>
					<?
						if( $row[status] == "Y" ) 
						{
							echo("<font color=blue>게시중</font>");
						} else {
							echo("<font color=red>중지중</font>");
						}
					?>
					</td>
					<td><?=date("Y.m.d",$row[regdate]);?></td>
				</tr>
				<tr>
					<td height="1" colspan="8" bgColor="#DBDBDB"></td>
				</tr>
			<?
					$no = $no-1;
					}
				}else{ // 게시물이 없을때
			?>
				<tr>
					<td height="24" colspan="8" align="center"><font color="#444444">게시물이 없습니다.</font></td>
				</tr>
				<tr>
					<td height="1" colspan="8" bgColor="#DBDBDB"></td>
				</tr>
			<?	
				}
			?>
			</table>
			<table width='100%' border="0" cellspacing="0" cellpadding="0">
				<?if($nums){ ?>
				<tr>
					<td align="center" style="padding:14 0 0 0;">				
						<?if($nums){echo"$paging[paging]";}else{echo"&nbsp;";} ?>
					</td>
				</tr>
				<? } ?>
				<tr>
					<td align="right" style="padding:10 0 0 0">
						<table width="100%" cellspacing="0" cellpadding="0" border="0">
							<tr>
								<td width="50%" align="left">
									<select name="status">
										<option value="">+ 선택 +</option>
										<option value="Y">팝업게시</option>
										<option value="N">팝업중지</option>
										<option value="D">삭제</option>
									</select>
									<input type="button" value="일괄처리" onclick="choiceClick()" style="padding:0 5 0 5;cursor:pointer">
								</td>
								<td width="50%" align="right"><input type=button value="신규팝업생성" onclick="location.href='popup_write.php';" style="padding:5px;cursor:pointer"></td>
							</tr>
						</table>						
					</td>
				</tr>
			</form>
			</table>
		</td>
	</tr>
</table>