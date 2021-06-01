<? $colspan = $row_page[BD_WRITE] != "9"?"5":"4"; ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td height="2" colspan="6" class="bline1"></td>
				</tr>
				<tr>
					<td width="31" align="center" class="btitle1">번호</td>
					<td width="390" align="center" class="btitle1">제목</td>
					<? if($row_page[BD_WRITE] != "9"){ ?>
					<td width="56" align="center" class="btitle1">작성자</td>
					<td width="114" align="center" class="btitle1">자녀명</td>
					<? } ?>
					<td width="70" align="center" class="btitle1">등록일</td>
					<td width="61" align="center" class="btitle1">조회</td>
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

					// 비밀글 아이콘
					if( $topRow[board_secret] == "Y" ){
						$secret_img = "&nbsp;<img src='../../images/common/icon_key.gif' align='absmiddle'>";
						if( $topRow[board_id] == $_SESSION[member_id]  || $_SESSION[masterSession] ){
							$secretValue = "Y";
						}else{
							$secretValue = "N";
						}

					}else{
						$secret_img = "";
						$secretValue = "O";
					}

					$vision = "Y";
					if($pno == "030101" && $topRow[board_secret]=="Y" && $_SESSION['member_level']=='R'){ // 공지사항 별도로 비밀 공지글 게시판
						$vision = "N";
					}

					if($vision == "Y"){
			?>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="51" align="center" class="bcontent"><img src="../../images/common/icon_gongji.gif"></td>
					<td width="454" class="bcontent"><span onclick="_viewLink('<?=$topRow[board_idx]?>','<?=$secretValue?>');" style="cursor:pointer"><?if($topRow[board_depth] != "1"){ for($x=1;$x<$topRow[board_depth];$x++){ echo"&nbsp;";} echo"$re_img"; }?><?=trim_text($topRow[board_subject], $strnum)?><?=$new_img?><?=$secret_img?></a></td>
					<? if($row_page[BD_WRITE] != "9"){ ?>
					<td width="82" align="center" class="bcontent"><?=$topRow[board_name]?></td>
					<? } ?>
					<td width="84" align="center" class="bcontent"><?=date("Y.m.d", $topRow[board_regdate]);?></td>
					<td width="51" align="center" class="bcontent"><?=number_format($topRow[board_hit])?></td>
				</tr>
				<tr>
					<td height="1" colspan="<?=$colspan?>" class="bline3"></td>
				</tr>
			</table>
			<?		}
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
						if($pno == "030101" && ereg("Y|A",$_SESSION[member_level]))
						{
							$secretValue = "Y";							
						}else{
							if( $row[board_id] == $_SESSION[member_id]  || $_SESSION[masterSession] ){
								$secretValue = "Y";
							}else{
								$secretValue = "N";
							}
						}
					}else{
						$secret_img = "";
						$secretValue = "O";
					}
			
				 if($row_page[BD_SECU]=="Y" && $pno != "030101"){
			?>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="31" align="center" class="bcontent"><?=$no?></td>
					<td width="390" class="bcontent"><span onclick="_viewLink('<?=$row[board_idx]?>','<?=$secretValue?>');" style="cursor:pointer"><?if($row[board_depth] != "1"){ for($x=1;$x<$row[board_depth];$x++){ echo"&nbsp;";} echo"$re_img"; }?><?=trim_text($row[board_subject], $strnum)?><?=$new_img?><?=$secret_img?></a></td>
					<? if($row_page[BD_WRITE] != "9"){ 
					   $temp_class = "";
					   if($row[board_kind] != "")
					   {
						   $temp_class = "[".$row[board_kind]."]";
					   }
					?>
					<td width="56" align="center" class="bcontent"><?=$row[board_name]?></td>
					<td width="114" align="center" class="bcontent"><?=$temp_class?><?=$row[board_pwd]?></td>
					<? } ?>
					<td width="70" align="center" class="bcontent"><?=date("Y.m.d", $row[board_regdate]);?></td>
					<td width="31" align="center" class="bcontent"><img src="../../images/common/icon_0<?=$row[board_state]!="2"?"1":"2"?>.gif" width="43" height="13"></td>
				</tr>
				<tr>
					<td height="1" colspan="5" class="bline3"></td>
				</tr>
			</table>
			<? }else{ ?>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="31" align="center" class="bcontent"><?=$no?></td>
					<td width="390" class="bcontent"><span onclick="_viewLink('<?=$row[board_idx]?>','<?=$secretValue?>');" style="cursor:pointer"><?if($row[board_depth] != "1"){ for($x=1;$x<$row[board_depth];$x++){ echo"&nbsp;";} echo"$re_img"; }?><?=trim_text($row[board_subject], $strnum)?><?=$new_img?><?=$secret_img?></a></td>
					<? if($row_page[BD_WRITE] != "9"){ 
					   $temp_class = "";
					   if($row[board_kind] != "")
					   {
						   $temp_class = "[".$row[board_kind]."]";
					   }

					   $tmp_name = "";

					   $tmp_name = str_replace(" ","<br>",$row[board_name]);
					?>
					<td width="56" align="center" class="bcontent"><?=$tmp_name?></td>
					<td width="114" align="center" class="bcontent"><?=$temp_class?><?=$row[board_pwd]?></td>
					<? } ?>
					<td width="70" align="center" class="bcontent"><?=date("Y.m.d", $row[board_regdate]);?></td>
					<td width="61" align="center" class="bcontent"><?=number_format($row[board_hit])?></td>
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