<?
	include "../../ewhaMaster/common/admin_login_check2.php";

	if($search && $keyword){

		if ( $search == "board_nmct" ){
			$whereAnd = " && (board_subject like '%$keyword%' || board_content like '%$keyword%' )";
		}else{
			$whereAnd = " && ($search like '%$keyword%')";
		}

	}

	if($board_kind) $whereAnd .= " && board_kind='$board_kind'";

	// 비밀글게시판
	if($row_page[BD_SECU]=="Y" && !$_SESSION[masterSession]) $whereAnd .= " && board_depth='1' ";

	$query	= "SELECT * FROM $table WHERE board_notice!='Y' $whereAnd ORDER BY board_group DESC, board_order, board_idx DESC";
	//echo $query;
	$result	= mysql_query($query);
	$nums	= @mysql_num_rows($result);

	if(!$total_count){ $total_count = $boardListNum; }

	if ($page == ""){ $page = "1"; }
	$url				= $PHP_SELF."?pno=$pno&search=$search&keyword=$keyword&board_kind=$board_kind";
	$total_page	= ceil($nums/$total_count);
	$set_page 	= $total_count * ($page-1);
	$list_page 	= 10;
	$last 			= $page * $total_count;

	$paging		= common_paging($url,$nums,$page,$list_page,$total_count);
	if ($last > $nums){ $last = $nums; }

	$file_icon =  "<img src='../../images/common/icon_file.gif' align='absmiddle' style='margin:0 0 3 0;'>";

	if($_SERVER['REMOTE_ADDR']=='112.218.172.42')
	{
		//echo $table;
	}
?>

<script language="javascript" type="text/javascript">
<!--
	function _viewLink(v,kind){
		event.cancelBubble = true;
		f = document.viewForm;

		if( kind !="O" && kind == "N" ){
			alert('글 보기 권한이 없습니다.');
			return;
		}

		f.board_idx.value = v;
		f.submit();
	}
//-->
</script>

<form name="viewForm" method="post" action="<?=$view_file?>" style="display:none">
	<input type="hidden" name="mode" value="view">
	<input type="hidden" name="board_idx">
	<input type="hidden" name="page" value="<?=$page?>">
	<input type="hidden" name="search" value="<?=$search?>">
	<input type="hidden" name="keyword" value="<?=$keyword?>">
</form>
<!---body 내역(s)--->
<table width="655" border="0" align="left" cellpadding="0" cellspacing="0">
	<tr>
		<td>
			<?
			if($pno == "030301"){
				include "../../html/sub03/inc_calendar_030301.php";					// 이달의 행사
			}
			?>
			<!--검색(s)-->
			<table width="100%" height="36" border="0" cellpadding="0" cellspacing="0" background="../../images/skin/search_bg.gif" class='noprint'>
			<form name="searchForm" method="get" action="<?=$PHP_SELF ?>">
				<input type="hidden" name='pno' value='<?=$pno?>'>
				<input type="hidden" name='board_kind' value='<?=$board_kind?>'>
				<tr>
					<td height="35" align="center" background="../../images/common/search_bg.gif">
						<select name="search" class="list">
							<option value="board_subject" <?if($search == "board_subject"){echo"selected";}?>>제목</option>
							<option value="board_content" <?if($search == "board_content"){echo"selected";}?>>내용</option>
							<option value="board_nmct" <?if($search == "board_nmct"){echo"selected";}?>>제목+내용</option>
						</select>
						<input name="keyword" type="text" class="input" id="textfield" style="width:180px;" value="<?=$keyword?>">
						<input type="image" src="../../images/btn/btn_search.gif" alt="검색" align="absmiddle" style="cursor:pointer">
					</td>
				</tr>
				<tr>
					<td height="14"></td>
				</tr>
			</form>
			</table>
			<!--검색(e)-->

			<!--list(s)-->
			<?	

			if($pno == "030301"){
				@include "inc_list_030301.php";				// 이달의 행사
			}
			else if($pno=="050103" || $pno=="050301" || (substr($pno,0,2)=="04" && substr($pno,4,2)=="03"))
	        {
				include "inc_list_normal2.php";
			}
			else{
				switch ($boardStyle){
					case 0:		
						include "inc_list_normal.php";// 일반게시판						
						break;
					case 1:
						include "inc_list_photo.php";				// 포토게시판
						break;
				}
			}
			?>				
			<!--list(e)-->

			<!--page&button(s)-->
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class='noprint'>
				<tr>
					<td align="center" style="padding:14 0 0 0;">				
						<?if($nums){echo"$paging[paging]";}else{echo"&nbsp;";} ?>
					</td>
				</tr>
				<tr>
					<td align="right">
						<? if($boardWriteBtn){ ?><a href="<?=$write_file?>" onfocus="this.blur();"><img src="../../images/btn/btn_write.gif" alt="글쓰기"></a><?}?>
					</td>
				</tr>
			</table>
			<!--page&button(e)-->
		</td>
	</tr>
</table>
<!---body 내역(e)--->