<?
	if($mode == "write" && $board_idx){
		$mode = "reply";
	}

	switch($mode){

		case "reply":

			$send_value		= "reply";
			$backValue		= $view_file."&board_idx=".$board_idx;
			$returnUrl			= $list_file;
			break;

		case "modify":

			$send_value = "modify";

			$query	= "SELECT * FROM $table WHERE board_idx='".$board_idx."'";
			$result	= mysql_query($query);
			$row		= mysql_fetch_array($result);

			if($row[board_email]){
				$explode_email = explode("@",$row[board_email]);
			}

			$content			= trim($row[board_content]);
			$backValue		= $view_file."&board_idx=".$board_idx;
			$returnUrl			= $view_file;

			break;

		default :
			$send_value		= "write";
			$backValue		= $list_file;
			$returnUrl			= $list_file;
			break;
	}

	$SUMMER1 = new summernote("board_content","540","300","thisForm");
?>
<script language="javascript" src="/include/js/calendar.js"></script>
<script language="javascript">
<!--
	function input_check(f){

		boardStyle		= f.boardStyle.value;
		boardFileNum	= f.boardFileNum.value;

		if(f.pno.value == "030301" && f.board_email.value == ""){
			alert('행사일을 등록하십시오!');
			return false;
		}

		if(!f.board_subject.value){		
			alert("제목을 입력하십시오!!");
			f.board_subject.focus();
			return false;
		}
		
		<?
			if(!$_SESSION[masterSession]) {	
		?>
		if(f.pno.value == "050301" && f.board_class.value == ""){
			alert('학급명을 입력하십시오!');
			return false;
		}

		if(f.pno.value == "050301" && f.board_kid.value == ""){
			alert('자녀명을 입력하십시오!');
			return false;
		}
		<?
			}
		?>

		<?$SUMMER1->BSEND(true)?>

		if (f.board_content.value == false) {
			alert("내용을 입력하십시오!!");		
			return false;
		}

		<? if($mode != "modify"){ ?>

		if( boardStyle == 1 && boardFileNum > 0 ){
			if( !f.file1.value ){
				alert('첨부파일을 등록하세요!');
				return false;
			}
		}
		<? } ?>
		return;
	}
//-->
</script>

<table width="655" border="0" align="left" cellpadding="0" cellspacing="0">

<form name="thisForm" method="post" action="../../include/board/board_common_proc.php" enctype="multipart/form-data" onsubmit="return input_check(this);" target="iframe">
	<input type="hidden" name="pno" value="<?=$pno?>">
	<input type="hidden" name="boardName" value="<?=$table?>">
	<input type="hidden" name="send" value="<?=$send_value?>">
	<input type="hidden" name="mode" value="<?=$send_value?>">
	<input type="hidden" name="board_idx" value="<?=$board_idx?>">
	<input type="hidden" name="board_group" value="<?=$board_group?>">
	<input type="hidden" name="returnUrl" value="<?=$returnUrl?>">
	<input type="hidden" name="board_id" value="<?=$_SESSION['member_id']?>">
	<input type="hidden" name="file_url" value="<?=$file_url?>">

	<input type="hidden" name="boardStyle" value="<?=$boardStyle?>">
	<input type="hidden" name="boardFileNum" value="<?=$boardFileNum?>">
	
	<? if( $row_page[BD_WRITE] != "9" ){ ?>
		<input type="hidden" name="board_name" value="<?=$_SESSION['member_name']?>">
	<? } ?>

	<tr>
		<td>
			<!---내용쓰기--->
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td height="2" colspan="2" class="bline1"></td>
				</tr>
				<?
				if( $pno == "030101" ){ // 공지사항 별도로 비밀글 게시판
				?>
				<tr>
					<td align="center" class="btitle1">글유형</td>
					<td class="bcontent1">
						<input type="radio" name="board_notice" value="Y" <? if( $row[board_notice] == "Y" ){ echo"checked";} ?>> 공지
						<input type="radio" name="board_notice" value="N" <? if(!$row[board_notice] || $row[board_notice] == "N" ){ echo"checked";} ?>> 일반
					</td>
				</tr>
				<tr>
					<td height="1" colspan="2" class="bline4"></td>
				</tr>
				<?
				}				
				if( $boardStyle == "0" ){
					if(empty($boardSecu)){
						if( $row_page[BD_WRITE] == "9" && $pno!="030303" && $pno!="030601" && $pno!="04020101" && $pno!="04020105" && $pno!="050203" ){
				?>
				<tr>
					<td align="center" class="btitle1">글유형</td>
					<td class="bcontent1">
						<input type="radio" name="board_notice" value="Y" <? if( $row[board_notice] == "Y" ){ echo"checked";} ?>> 공지
						<input type="radio" name="board_notice" value="N" <? if(!$row[board_notice] || $row[board_notice] == "N" ){ echo"checked";} ?>> 일반
					</td>
				</tr>
				<tr>
					<td height="1" colspan="2" class="bline4"></td>
				</tr>
				<?
						}
					}else{
				?>
				<tr>
					<td align="center" class="btitle1">공개설정</td>
					<td class="bcontent1">
						<input type="radio" name="board_secret" value="N" <? if(!$row[board_secret] || $row[board_secret] == "N" ){ echo"checked";} ?>> 공개
						<input type="radio" name="board_secret" value="Y" <? if( $row[board_secret] == "Y" || $board_secret == "Y" ){ echo"checked";} ?>> 비공개
					</td>
				</tr>
				<tr>
					<td height="1" colspan="2" class="bline4"></td>
				</tr>
				<?}
				}			
					if( $pno == "030301" ){ 
						include "../../include/board/030301_val.php";
				?>
				<tr>
					<td width="114" align="center" class="btitle1">행사일</td>
					<td width="541" class="bcontent1">
						<input name="board_email" readonly value="<?=$row["board_email"]?>" class="input" style="width:80;text-align:center;" onfocus='calendar(event,this)' onChange="autoDate();"> <img src="../../images/common/icon_calendar.gif" align="absmiddle" style="cursor:pointer;" onclick='calendar(event,document.thisForm.board_email)'>	
					</td>
				</tr>
				<tr>
					<td height="1" colspan="2" class="bline4"></td>
				</tr>
				<tr>
					<td width="114" align="center" class="btitle1">분류</td>
					<td width="541" class="bcontent1">
						<select name="event_kind">
							<option value="01" <?if($row[board_pwd]== "01") echo "selected"?>>영아반</option>
							<option value="02" <?if($row[board_pwd]== "02") echo "selected"?>>유아반</option>
							<option value="03" <?if($row[board_pwd]== "03") echo "selected"?>>교사행사</option>
							<option value="04" <?if($row[board_pwd]== "04") echo "selected"?>>부모행사</option>
							<option value="all" <?if($row[board_pwd]== "all") echo "selected"?>>전체</option>
						</select>
					</td>
				</tr>
				<tr>
					<td height="1" colspan="2" class="bline4"></td>
				</tr>
				<tr>
					<td width="114" align="center" class="btitle1">반</td>
					<td width="541" class="bcontent1">
						<select name="board_kind">
							<?
							$tmp = explode(",", $row[board_kind]);
							foreach($arrClass As $k => $val){ ?>
							<option value="<?=$k?>" <?if( $k == $tmp[0]) echo "selected"?>><?=$val?></option>
							<? } ?>
						</select>
						<select name="board_kind2">
							<? foreach($arrClass As $k => $val){ ?>
							<option value="<?=$k?>" <?if( $k == $tmp[1]) echo "selected"?>><?=$val?></option>
							<? } ?>
						</select>
					</td>
				</tr>
				<tr>
					<td height="1" colspan="2" class="bline4"></td>
				</tr>
				<? } ?>
				<tr>
					<td width="114" align="center" class="btitle1">제목</td>
					<td width="541" class="bcontent1">
						<input name="board_subject" type="text" value="<?=$row[board_subject]?>" class="input" style="width:540px;">
					</td>
				</tr>
				<tr>
					<td height="1" colspan="2" class="bline4"></td>
				</tr>	
				<? if($pno=="050103" || $pno=="050301" || (substr($pno,0,2)=="04" && substr($pno,4,2)=="03")) { 
				      if(!$_SESSION[masterSession]) {			
				?>
				<tr>
					<td width="114" align="center" class="btitle1">학급명</td>
					<td width="541" class="bcontent1">
						<input name="board_class" type="text" value="<?=$row[board_kind]?>" class="input" style="width:100px;">
					</td>
				</tr>
				<tr>
					<td height="1" colspan="2" class="bline4"></td>
				</tr>
				<tr>
					<td width="114" align="center" class="btitle1">자녀명</td>
					<td width="541" class="bcontent1">
						<input name="board_kid" type="text" value="<?=$row[board_pwd]?>" class="input" style="width:100px;">
					</td>
				</tr>
				<tr>
					<td height="1" colspan="2" class="bline4"></td>
				</tr>
				<? } else { ?> 
				<tr>
					<td width="114" align="center" class="btitle1">교사명</td>
					<td width="541" class="bcontent1">
						<input name="board_teacher" type="text" value="<?=$row[board_name]?>" class="input" style="width:100px;">
					</td>
				</tr>
				<tr>
					<td height="1" colspan="2" class="bline4"></td>
				</tr>
				<? } }?>
				<tr>
					<td width="114" align="center" class="btitle1">내용</td>
					<td valign="top" class="bcontent1">
						<?$SUMMER1->SHOW($content)?>
					</td>
				</tr>
				<tr>
					<td height="1" colspan="2" class="bline4"></td>
				</tr>
				<? if($boardFileNum > 0){ ?>
				<tr>
					<td width="114" align="center" class="btitle1"><?=$boardStyle!="1"?"첨부파일":"이미지등록";?></td>
					<td class="bcontent1">
						<?
							for ( $i = 1 ; $i <= $boardFileNum; $i++ ) {
								if( $i > 1 ) echo("<br>");
						?>
								<? if($row[board_file.$i]){ ?><input type="checkbox" name="fileDel<?=$i?>" value="Y"> <b><?=$row[board_file.$i]?></b> 파일 삭제시 체크하세요<br><?}?>
								<? if($boardStyle!="1"){ ?><img src="../../images/common/icon_data.gif" width="13" height="12" align="absmiddle"><?}?>
								<input type='file' class='input' name='file<?=$i?>' style="width:520px;height:20px;">
						<?
							}
						?>	
					</td>
				</tr>
				<tr>
					<td height="1" colspan="2" class="bline2"></td>
				</tr>
				<? } ?>
				<? 
					if($row_page[BD_SECU]=="Y"){
						if($_SESSION[masterSession]){
				?>
				<!-- <tr>
					<td class='board_tit4'>상태</td>
					<td class='board_item5'>								
						<input type="radio" name="board_state" value="2" checked> <img src="/images/sub06/icon_02.gif" align="absmiddle">
						<input type="radio" name="board_state" value="3" <?if($row[board_state]=="3") echo "checked"; ?>> <img src="/images/sub06/icon_03.gif" align="absmiddle">
						<input type="radio" name="board_state" value="1" <?if($row[board_state]=="1") echo "checked"; ?>> <img src="/images/sub06/icon_01.gif" align="absmiddle">
					</td>
				</tr> -->
				<tr>
					<td width="114" align="center" class="btitle1">상태</td>
					<td valign="top" class="bcontent1">
						<input type="radio" name="board_state" value="1" checked> <img src="/images/common/icon_01.gif" align="absmiddle">
						<input type="radio" name="board_state" value="2" <?if($row[board_state]=="2") echo "checked"; ?>> <img src="/images/common/icon_02.gif" align="absmiddle">
					</td>
				</tr>
				<tr>
					<td height="1" colspan="2" class="bline4"></td>
				</tr>
				<?
						}else{
							echo "<input type='hidden' name='board_state' value='".$row[board_state]."'>";
						}
					}
				?>
			</table>
			<!---내용쓰기(e)--->
			<!--button-->
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td align="right"  style="padding:15 0 0 0;">
						<input type="image" src="../../images/btn/btn_confirm.gif" alt="확인">
						<img src="../../images/btn/btn_cancel.gif" alt="취소" onclick="location.href='<?=$backValue?>';" style="cursor:pointer">
					</td>
				</tr>
			</table>
			<!--button(e)-->
		</td>
	</tr>
</form>
</table>