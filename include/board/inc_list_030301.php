<style type="text/css" media="print">
.noprint { display: none; }
</style>
<? include "../../include/board/030301_val.php"; ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class='noprint'>
	<tr>
		<td>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td height="2" colspan="6" class="bline1"></td>
				</tr>
				<tr>
					<td width="41" align="center" class="btitle1">번호</td>
					<td width="444" align="center" class="btitle1">제목</td>
					<td width="50" align="center" class="btitle1">분류</td>
					<td width="72" align="center" class="btitle1">해당반</td>
					<td width="74" align="center" class="btitle1">등록일</td>
					<td width="41" align="center" class="btitle1">조회</td>
				</tr>
				<tr>
					<td height="1" colspan="6" class="bline2"></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<?
				$topQuery	= "SELECT * FROM $table WHERE board_notice='Y' $whereAnd ORDER BY board_group DESC, board_order, board_idx DESC";
				$topResult	= mysql_query($topQuery);
				$top_nums	= @mysql_num_rows($topResult);

				while( $topRow = @mysql_fetch_array($topResult) ){

					$today	= mktime();
					$dbday	= $topRow[board_regdate];
					$totday	= $today - $dbday;

					if($totday <= 86400){
						$new_img = "<img src='../../images/common/icon_new.gif' border='0' align='absmiddle' style='margin-left:5;'>";
					}else{
						$new_img = "";
					}
					$strnum = "54";
			?>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="51" align="center" class="bcontent"><img src="../../images/common/icon_gongji.gif"></td>
					<td width="454" class="bcontent"><span onclick="_viewLink('<?=$topRow[board_idx]?>','<?=$secretValue?>');" style="cursor:pointer"><?if($topRow[board_depth] != "1"){ for($x=1;$x<$topRow[board_depth];$x++){ echo"&nbsp;";} echo"$re_img"; }?><?=trim_text($topRow[board_subject], $strnum)?><?=$new_img?><?=$secret_img?></a></td>
					<? if($row_page[BD_WRITE] != "9"){ ?>
					<td width="82" align="center" class="bcontent"><img src="/images/sub03/icon_<?=$topRow[board_kind]?$topRow[board_kind]."_1":"all_1"?>.gif"></td>
					<? } ?>
					<td width="84" align="center" class="bcontent"><?=date("Y.m.d", $topRow[board_regdate]);?></td>
					<td width="51" align="center" class="bcontent"><?=number_format($topRow[board_hit])?></td>
				</tr>
				<tr>
					<td height="1" colspan="5" class="bline3"></td>
				</tr>
			</table>
			<?
				}
			
				$no = $nums - $set_page;

				if ($nums){
					for ($i = $set_page; $i < $last; $i++){
					@mysql_data_seek($result,$i);
					$row= mysql_fetch_array($result);

					$today	= mktime();
					$dbday	= $row[board_regdate];
					$totday	= $today - $dbday;

					if($totday <= 86400){
						$new_img = "<img src='../../images/common/icon_new.gif' border='0' align='absmiddle' style='margin-left:5;'>";
					}else{
						$new_img = "";
					}

					if( $row[board_depth] > 1){
						$re_img = "<img src='../../images/common/board_reply.gif' align='absmiddle' > ";
					}else{
						$re_img = "";
					}

					$subject_len = "62";

					if($row[board_depth]){
						$strno = $row[board_depth] * 4;
						$strnum	= $subject_len - $strno;
					}else{
						$strnum	= $subject_len;
					}

					// 비밀글 아이콘
					if( $row[board_secret] == "Y" ){
						$secret_img = "&nbsp;<img src='../../images/common/icon_key.gif' align='absmiddle'>";
						if( $row[board_id] == $_SESSION[member_id]  || $_SESSION[masterSession] ){
							$secretValue = "Y";
						}else{
							$secretValue = "N";
						}

					}else{
						$secret_img = "";
						$secretValue = "O";
					}
			
				 if($row_page[BD_SECU]=="Y"){
			?>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="45" align="center" class="bcontent"><?=$no?></td>
					<td width="382" class="bcontent"><span onclick="_viewLink('<?=$row[board_idx]?>','<?=$secretValue?>');" style="cursor:pointer"><?if($row[board_depth] != "1"){ for($x=1;$x<$row[board_depth];$x++){ echo"&nbsp;";} echo"$re_img"; }?><?=trim_text($row[board_subject], $strnum)?><?=$new_img?><?=$secret_img?></a></td>
					<td width="82" align="center" class="bcontent"><img src="/images/sub03/icon_<?=$row[board_kind]?$row[board_kind]."_1":"all_1"?>.gif"></td>
					<td width="80" align="center" class="bcontent"><?=date("Y.m.d", $row[board_regdate]);?></td>
					<td width="66" align="center" class="bcontent"><img src="../../images/common/icon_0<?=$row[board_state]!="2"?"1":"2"?>.gif" width="43" height="13"></td>
				</tr>
				<tr>
					<td height="1" colspan="5" class="bline3"></td>
				</tr>
			</table>
			<? 
					}else{ 
								$tmp = explode(",", $row[board_kind]);

								$tmpClass1 = $arrClass["$tmp[0]"];
								$tmpClass2 = "";
								if($tmp[1]) { $tmpClass1 = $tmpClass1.", ".$arrClass["$tmp[1]"]; }

								if($tmp[0]!="")
								{
									$tmpClass2 = "<".str_replace("반","",$tmpClass1).">";
								}
			?>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="41" align="center" class="bcontent"><?=$no?></td>
					<td width="444" class="bcontent"><span onclick="_viewLink('<?=$row[board_idx]?>','<?=$secretValue?>');" style="cursor:pointer"><?if($row[board_depth] != "1"){ for($x=1;$x<$row[board_depth];$x++){ echo"&nbsp;";} echo"$re_img"; }?><?=trim_text($row[board_subject].$tmpClass2, $strnum)?><?=$new_img?><?=$secret_img?></a></td>
					<? if($row_page[BD_WRITE] != "9"){ 
					   $temp_icon = "";
					   if(trim($row[board_pwd]) == "")
					   {
						   $temp_icon = "all";
					   }
					   else
					   {
						   $temp_icon = $row[board_pwd];
					   }
					
					?>
					<td width="50" align="center" class="bcontent"><img src="/images/sub03/icon_<?=$temp_icon?>.gif"></td>
					<td width="72" align="center" class="bcontent"><?=$tmpClass1?></td>
					<? } ?>
					<td width="74" align="center" class="bcontent"><?=date("Y.m.d", $row[board_regdate]);?></td>
					<td width="41" align="center" class="bcontent"><?=number_format($row[board_hit])?></td>
				</tr>
				<tr>
					<td height="1" colspan="6" class="bline3"></td>
				</tr>
			</table>
			<? }
					$no = $no-1;
					}
				}else{ // 게시물이 없을때
					if($top_nums < "1"){
			?>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td align="center" class="bcontent"><font color="#444444">게시물이 없습니다.</font></td>
				</tr>
				<tr>
					<td height="1" colspan="4" class="bline3"></td>
				</tr>
			</table>
			<?	  }
				}
			?>
		</td>
	</tr>
</table> 