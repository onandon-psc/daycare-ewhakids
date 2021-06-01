<?
	$regdate	= DATE("Y-m-d");

	if( $send == "delete" )	{

		$query	= "SELECT * FROM $table WHERE board_idx='$board_idx'";
		$result	= mysql_query($query);
		$row		= mysql_fetch_array($result);

		if( $row[board_id] == $_SESSION[member_id] || $_SESSION[masterSession] ) {

			//---------------------------
			// 하위 답글 존재 여부 검사.
			//---------------------------
			$query		= "SELECT board_idx FROM $table WHERE board_group='$row[board_idx]' AND board_depth > '1' ";
			$result		= mysql_query($query);
			$row_re	= mysql_fetch_array($result);
			if( $row_re ) {
				goBack("하위글이 존재하여 삭제하실 수 없습니다.");
			}

			// 삭제
			$query = "DELETE FROM $table WHERE board_idx='$board_idx'";
			mysql_query($query);

			// 댓글 삭제
			/*
			$query = "DELETE FROM $table_comment WHERE board=:V1 and writing =:V2";
			mysql_query($query);
			*/

			// 첨부파일 삭제
			if( $row[board_file1] ) @unlink("$file_url$row[board_file1]");
			if( $row[board_file2] ) @unlink("$file_url$row[board_file2]");
			if( $row[board_file3] ) @unlink("$file_url$row[board_file3]");
			if( $row[board_file4] ) @unlink("$file_url$row[board_file4]");
			if( $row[board_file5] ) @unlink("$file_url$row[board_file5]");

			goUrl($list_file);

		} else {
			goBack("삭제 권한이 없습니다.");
		}

	}

	### Start : 조회수 ###

	$query = "DELETE FROM $boardHit_table WHERE regdate!='".$regdate."'";
	//echo $query;
	@mysql_query($query);

	$query	= "SELECT board_idx FROM $boardHit_table WHERE board='".$table."' && board_idx='".$board_idx."' && userIp='".$REMOTE_ADDR."'";
	//echo $query;
	$result	= mysql_query($query);
	$row		= @mysql_num_rows($result);

	if(!$row){
		$query = "UPDATE $table SET board_hit=board_hit+1 WHERE board_idx='".$board_idx."'";
		mysql_query($query);
		$query = "INSERT INTO $boardHit_table (board, board_idx, userIp, regdate) VALUES ('$table','$board_idx','$REMOTE_ADDR','$regdate')";
		mysql_query($query);
	}

	### End : 조회수 ###

	$query	= "SELECT * FROM $table WHERE board_idx='".$board_idx."'";
	$result	= mysql_query($query);
	$row		= mysql_fetch_array($result);
	
	//보기 권한 체크
	if($_SESSION['masterSession']=="master" || $_SESSION['member_level']=="A"){
	}else{
		if($pno!="030101" && $row[board_secret] == "Y" && ($_SESSION[member_id] != $row[board_id])){
			echo "<script>alert('잘못된 접근입니다.');history.back();</script>";
			exit;
		}
	}

	$content	= stripslashes($row[board_content]);
	$content	= str_replace("<P>","",$content);
	$content	= str_replace("</P>","<br>",$content);

	$file_icon =  " <img src='../../images/common/icon_data.gif' align='absmiddle'>";
	if(!$row[board_state]) $row[board_state] = 2;

	if($row_page[BD_WRITE]!=9 && $row[board_name]) $colspan = "9";
	else $colspan = "6";
?>
<table width="655" border="0" align="left" cellpadding="0" cellspacing="0">
	<tr>
		<td>
			<!---글 보기 타이틀--->
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td height="2" colspan="<?=$colspan?>" class="bline1"></td>
				</tr>
				<tr>
					<td width="78" align="center" class="btitle1">제목</td>
					<td bgcolor="f2f5f1"><img src="../../images/common/board_line.gif"></td>
					<td colspan="7" class="btitle1"><?=$row[board_subject]?></td>
				</tr>
				<tr>
					<td height="1" colspan="<?=$colspan?>" class="bline4"></td>
				</tr>
				<tr>
					<? if($row_page[BD_WRITE]!=9 && $row[board_name]){?>
					<td align="center" class="btitle4">작성자</td>
					<td width="1" ><img src="../../images/common/board_line.gif"></td>					
					<td width="236" class="bcontent1"><?=$row[board_name]?></td>
					<td width="61" align="center"  class="btitle4">등록일</td>
					<td width="1"><img src="../../images/common/board_line.gif"></td>
					<td width="153"  class="bcontent1"><?=date("Y.m.d", $row[board_regdate])?></td>
					<td width="47" align="right"  class="btitle4">조회</td>
					<td width="1" ><img src="../../images/common/board_line.gif"></td>
					<td width="62"  class="bcontent1"><?=$row[board_hit]?></td>
					<? }else{ ?>
					<td width="61" align="center" class="btitle4">등록일</td>
					<td width="1"><img src="../../images/common/board_line.gif"></td>
					<td width="389"  class="bcontent1"><?=date("Y.m.d", $row[board_regdate])?></td>
					<td width="47" align="right"  class="btitle4">조회</td>
					<td width="1" ><img src="../../images/common/board_line.gif"></td>
					<td width="62"  class="bcontent1"><?=$row[board_hit]?></td>
					<? } ?>
				</tr>
				<tr>
					<td height="1" colspan="<?=$colspan?>" class="bline4"></td>
				</tr>
			</table>
			<!---글 보기 타이틀(e)--->
			<!---글 내용--->
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td style="padding:28 20 28 20;" >
					<?
						if( $boardStyle == "1" || ereg("030101",$pno) ){ 
							for( $n=1; $n<=5; $n++ ){
								if($row[board_file.$n]){

									$viewFile	= htmlspecialchars($row[board_file.$n]);
									$img_size	= @GetImageSize("$fileUrl$viewFile");
									$fileWidth	= $img_size[0]; 
									$fileHeight	= $img_size[1];

									if ( $fileWidth > 530 ) $fileWidth = 530;

									if( ereg(".gif",$row[board_file.$n]) || ereg(".jpg",$row[board_file.$n]) || ereg(".jpeg",$row[board_file.$n]) ){
					?>
	
								<table width="530" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td align="center"><img src="<?=$file_url.urlencode($row[board_file.$n])?>" width="<?=$fileWidth?>" align="absmiddle"></td>
									</tr>
								</table>
								<br>
					<?		 
								}
							 }
						  }
					   }
					if($row_page[BD_SECU]=="Y" && $pno != "030101" ) echo "<img src='../../images/sub04/text_01.gif'><br><br>";
					echo $content;		

					if($row_page[BD_SECU]=="Y"){
						$rQuery	= "SELECT board_content, board_regdate FROM $table WHERE board_group='".$board_idx."' && board_depth > 1 ORDER BY board_order DESC";
						$rResult	= mysql_query($rQuery);
						while ($row2 = mysql_fetch_array($rResult)){
							$content	= stripslashes($row2[board_content]);
							$content	= str_replace("<P>","",$content);
							$content	= str_replace("</P>","<br>",$content);
							if($pno != "030101" ){
							echo "<br><br><br><br><img src='../../images/sub04/text_02.gif'><br><br>";
							}
							echo $content;
						}
					}
					?>
					</td>
				</tr>
			</table>
			<!---글 내용(e)--->
			<!---첨부파일--->
			<? if( $boardStyle != "1" && ($row[board_file1]||$row[board_file2]||$row[board_file3]||$row[board_file4]||$row[board_file5]) ){ ?>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td height="1" colspan="3" class="bline4"></td>
				</tr>
				<tr>
					<td width="78" align="center" class="btitle4">첨부파일</td>
					<td width="1" ><img src="../../images/common/board_line.gif"></td>
					<td width="569" class="bcontent1">
					<? 
						for($n=1;$n<=5;$n++){ 
							if($row["board_file".$n]) {
								if( $pno=="050203" ){
									if(!ereg(".gif",$row[board_file.$n]) && !ereg(".jpg",$row[board_file.$n]) && !ereg(".jpeg",$row[board_file.$n])){
										if($_SESSION[member_id]){
											echo $file_icon." <a href=\"javascript:;\" onclick=\"jsDownload('".str_replace(" ","_",$row["board_file".$n])."');\">".$row["board_file".$n]."</a> "; 
										}else{
											echo $file_icon." <a href=\"javascript:;\" onclick=\"alert('로그인 후 다운 받을 수 있습니다.');\">".str_replace(" ","_",$row["board_file".$n])."</a> ";
										}
									}
								}else{
									echo $file_icon." <a href=\"javascript:;\" onclick=\"jsDownload('".str_replace(" ","_",$row["board_file".$n])."');\">".str_replace(" ","_",$row["board_file".$n])."</a> "; 
								}
							} 
						}
					?>
					</td>
				</tr>
			</table>
			<? } ?>
			<!---첨부파일(e)--->
			<!---이전,다음--->
			<? 
				if( $boardPreNext && empty($boardSecu) ){

				// 이전글
				$rev_query	 = "SELECT * FROM $table WHERE board_idx < $board_idx && board_depth='1' ORDER BY board_idx DESC LIMIT 1";
				$rev_result	 = mysql_query($rev_query);
				$rev_row	 = @mysql_fetch_array($rev_result);

				$rev_day	= $rev_row[board_regdate];
				$rev_time	= $regdate - $rev_day;

				if($rev_time <= 86400){
					$rev_new_img = "&nbsp;<img src='../../images/common/icon_new.gif' border='0' align='absmiddle' style='margin:0 0 1 0;'>";
				}else{
					$rev_new_img = "";
				}

				// 다음글
				$next_query	= "SELECT * FROM $table WHERE board_idx > $board_idx && board_depth='1' ORDER BY board_idx ASC LIMIT 1";
				$next_result	= mysql_query($next_query);
				$next_row		= @mysql_fetch_array($next_result);

				$next_day	= $next_row[board_regdate];
				$next_time	= $regdate - $next_day;

				if($next_time <= 86400){
					$next_new_img = "&nbsp;<img src='../../images/common/icon_new.gif' border='0' align='absmiddle' style='margin:0 0 1 0;'>";
				}else{
					$next_new_img = "";
				}
			?>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td height="1" colspan="8" class="bline2"></td>
				</tr>
				<tr>
					<td width="77" align="center" class="btitle1">이전</td>
					<td width="563" colspan="7" class="btitle2">
					<? if($rev_row){ ?>
						<a href="<?=$view_file?>&board_idx=<?=$rev_row[board_idx]?>&page=<?=$page?>" class="board_tt" alt='이전글'><?if($rev_row[KIND] == "y"){?><img src='../../images/in_operation/star.gif' align='absmiddle'> <?}?><?=trim_text($rev_row[board_subject], 78)?> <?=$rev_new_img?>
						<? for($n=1;$n<=5;$n++){ if($rev_row["board_file".$n]) { echo $file_icon; } } ?></a>
						<? }else{ ?>
							이전글이 없습니다.
					<? }?>
					</td>
				</tr>
				<tr>
					<td height="1" colspan="8" class="bline4"></td>
				</tr>
				<tr>
					<td align="center" class="btitle1">다음</td>
					<td colspan="7" class="btitle2">
					<? if($next_row){ ?>
						<a href="<?=$view_file?>&board_idx=<?=$next_row[board_idx]?>&page=<?=$page?>" class="board_tt" alt='다음글'><?if($next_row[KIND] == "y"){?><img src='../../images/in_operation/star.gif' align='absmiddle'> <?}?><?=trim_text($next_row[board_subject], 78)?> <?=$next_new_img?>
						<? for($n=1;$n<=5;$n++){ if($next_row["board_file".$n]) { echo $file_icon; } } ?></a>
					<? }else{ ?>
						다음글이 없습니다.
					<? }?>
					</td>
				</tr>				
			</table>
			<!---이전,다음(e)--->
			<? } ?>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td height="1" class="bline2"></td>
				</tr>
			</table>
			<!--button(s)-->
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<form name="btnForm" method="post">
				  <input type="hidden" name="mode">
				  <input type="hidden" name="board_idx" value="<?=$row[board_idx]?>">
				  <input type="hidden" name="page" value="<?=$page?>">
				<tr>
					<td align="right"  style="padding:15 0 0 0;"> 
					<!-- 답글 -->
					<? if( $boardReplyBtn ) {
							if($row_page[BD_SECU]=="Y"){
								if($_SESSION[masterSession]) $btnReply = "Y";
							}else{ 
								$btnReply = "Y";
							}
						} 
						if($btnReply == "Y"){
					?>
						<a href="<?=$write_file?>&board_idx=<?=$row[board_idx]?>&board_secret=<?=$row[board_secret]?>&page=<?=$page?>" ><img src='../../images/btn/btn_reply.gif' alt="답글" border="0" align="absmiddle" style="cursor:pointer" style="margin-left:5"></a>
					<? } ?>
					<!-- 수정 -->
					<? if( $boardModifyBtn && ( $row[board_id] == $_SESSION[member_id] || $_SESSION[masterSession] ) ) { ?>
					<a href="<?=$modify_file?>&board_idx=<?=$row[board_idx]?>&page=<?=$page?>"><img src='../../images/btn/btn_edit.gif' alt="수정" border="0" align="absmiddle" style="margin-left:5"></a>
					<? } ?>
					<!-- 삭제 -->
					<? if( $boardDeleteBtn && ( $row[board_id] == $_SESSION[member_id] || $_SESSION[masterSession] ) ) { ?>
					<a href="<?=$view_file?>&send=delete&board_idx=<?=$row[board_idx]?>&pwd=<?=$row[board_pwd]?>"onClick="javascript:return confirm('삭제하시겠습니까?');"><img src='../../images/btn/btn_delete.gif' alt="삭제" border="0" align="absmiddle" style="cursor:pointer" style="margin-left:5"></a>
					<? } ?>
					<a href="<?=$list_file?>&page=<?=$page?>"><img src="../../images/btn/btn_list.gif" alt="목록" border="0" align="absmiddle" style="cursor:pointer" style="margin-left:5"></a>
					</td>
				</tr>
				</form>
			</table>			
			<!--button(e)-->			
		</td>
	</tr>
</table>