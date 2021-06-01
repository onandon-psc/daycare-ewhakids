<?
	include "../../include/global/config.php"; 
	include "../common/admin_login_check.php";				// 로그인 체크

	if($_SESSION['member_level'] < 9){
		echo "<script>alert('접근 권한이 없습니다.');</script>";
		exit;
	}

	function textMbStatus($v)
	{
		switch($v)
		{
			case "A": $returnValue = "<font color='#FF0000'>관리자</font>"; break;
			case "R": $returnValue = "준회원"; break;
			case "Y": $returnValue = "<font color='#0000FF'>정회원</font>"; break;
			case "C": $returnValue = "탈퇴회원"; break;
			case "Z": $returnValue = "<font color='green'>입학관리자</font>"; break;
		}
		return $returnValue;
	}

	$tableName		= "ona_member";
	$tableName2	= "ona_member_family";
	
	$id					= trim($_REQUEST['id']);
	//$mbStatus		= trim($_POST['mbStatus']);
	$choiceValue	= trim($_POST['choiceValue']);
	
	// 일괄변경
	if($choiceValue){
		$exp = explode(",",$choiceValue);
		for($i=0; $i < count($exp); $i++){
			if($i == 0) $sql .= "'".$exp[$i]."'";
			else $sql .= ",'".$exp[$i]."'";
		}	
		$query = "UPDATE $tableName SET mbStatus='$mbStatus' WHERE mbId in ( $sql )";
		mysql_query($query);
		goUrl("mb_list.php?page=".$page);
	}
	if($mbStatus) $whereAnd .= " && mbStatus='$mbStatus' ";
	if($search) $whereAnd .= " && ( $search like '%$keyword%' ) ";

	$listQuery		= "SELECT * FROM $tableName WHERE 1 and mbStatus != 'C' && mbStatus!='M' $whereAnd ORDER BY mbRegdate DESC";

	if($search == 'childName')
	{
		if($mbStatus) $whereAnd .= " && a.mbStatus='$mbStatus' ";
		$listQuery = "select a.* from ona_member a, ona_member_family b where a.mbId = b.mbId $whereAnd && b.childName like '%$keyword%' ORDER BY a.mbRegdate DESC";
	}
	$listResult		= mysql_query($listQuery);
	$list_num		= @mysql_num_rows($listResult);	

	if(!$total_count){ $total_count = 20; }

	if ($page == ""){ $page = "1"; }				
	$url				= $PHP_SELF."?search=$search&keyword=$keyword&mbStatus=$mbStatus";
	$total_page	= ceil($list_num/$total_count);
	$set_page 	= $total_count * ($page-1);
	$list_page 	= 10;
	$last 			= $page * $total_count;

	$paging		= common_paging($url,$list_num,$page,$list_page,$total_count);
	if ($last > $list_num){ $last = $list_num; }
?>
<script language="javascript" src="../../include/js/member.js"></script>
<script language="javascript" src="../../include/js/choice.js"></script>
<script language='javascript' src='/include/js/func.js'></script>
<script type="text/JavaScript">
<!--
	function MM_openBrWindow(theURL,winName,features) { //v2.0
		window.open(theURL,winName,features);
	}

	function choiceClick(){

		f = document.listForm;

		var check_value = getChecked(f);

		if(!f.mbStatus.value){
			alert('회원권한설정을 선택하세요');
			f.mbStatus.focus();
			return false;
		}

		if(check_value == ""){
			alert("변결 할 회원을 선택하세요!");
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
	function saveToExcel(){
		var form = document.searchForm;
		form.target="iframe";
		form.action="mb_list_excel.php";
		form.submit();
		form.target="";
		form.action="";
	}

//-->
</script>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr height=30>
    <td bgcolor=#ececec>&nbsp;&nbsp;<b>▣ 회원관리</b></td>
  </tr>
  <tr>
    <td height="15"></td>
  </tr>
  <? ############################## Start : 상세보기 ############################## 
	  if( $id ){

		$query	= "SELECT * FROM ona_member WHERE mbId='".$id."' and mbStatus != 'C'";
		$result	= mysql_query($query, $db);
		$row		= mysql_fetch_array($result);
		$query = "SELECT * FROM ona_member_family WHERE mbId = '".$id."'";
		$childRows = sqlArray($query);

		$exJumin	= explode("-", $row[mbJumin]);		
		$exEmail	= explode("@", $row[mbEmail]);

		$modeValue = "modify2";
  ?>
  <form name="locationFrm" method="post">
	<input type="hidden" name="pno">
	<input type="hidden" name="mbId">
	<input type="hidden" name="mbPwd">
	<input type="hidden" name="mbName">
</form>

  <form name="frm" method="post" action="/html/sub07/070202_proc2.php" onsubmit="return input_check(this);" target="iframe">
	<input type="hidden" name="ret_host" value="<?=$_SERVER['HTTP_HOST']?>">
	<input type="hidden" name="mode" value="<?=$modeValue?>">
	<input type="hidden" name="mbNickOld" value="<?=$row['mbNick']?>">
  <tr>
	<td>
	  <table width="660" border="0" cellspacing="0" cellpadding="0">
		<? include "../../html/sub07/new_inc_member.php"; ?>
	  </table>
	</td>
  </tr>
  <tr>
	<td>
	  <!--버튼(s)-->
	  <br>
	  <table width="660" border="0" cellspacing="0" cellpadding="0">
		<tr>
		  <td align="center"><input type="submit" value=" 확인 " style="cursor:pointer" style="padding:5px" onclick="submit();"> <input type="button" value=" 취소 " onClick="history.back();" style="cursor:pointer" style="padding:5px"></td>
		</tr>
	  </table>
	  <br>
	  <br>
	  <!--버튼(e)-->
	</td>
  </tr>

  </form>
  <?
	  }
  ?>

  <? ############################## End : 상세보기  ############################## ?>
  <tr>
    <td>
      <table width='100%' cellpadding='0' cellspacing='0' border='0' align='center'>
        <tr>
          <td>
            <table width='100%' cellpadding=0 cellspacing=0 border=0 align=center>
              <tr>
                <td>&nbsp;&nbsp;<b>
                  <? if($search){ echo"검색된 회원";}else{echo"전체";}?>
                  :
                  <?=number_format($list_num)?>
                  명</b></td>
                <td align="right" style="padding:0 0 5 0">
                  <!-- 검색 시작 -->
                  <table cellpadding='0' cellspacing='0' border='0'>
                    <form name="searchForm" method="post" action="<?=$PHP_SELF?>">
                      <tr>
                        <td>
                          <select name="mbStatus" class="list">
                            <option value="">+ 회원구분 선택 +</option>
                            <option value="Y" <?if($mbStatus=="Y"){echo"selected";}?>>정회원</option>
                            <option value="R" <?if($mbStatus=="R"){echo"selected";}?>>준회원</option>
                            <option value="C" <?if($mbStatus=="C"){echo"selected";}?>>탈퇴회원</option>
                            <option value="A" <?if($mbStatus=="A"){echo"selected";}?>>관리자</option>
                            <option value="Z" <?if($mbStatus=="Z"){echo"selected";}?>>입학관리자</option>
                          </select>
                          <select name="search" class="list">
                            <option value="">+ 검색구분 선택 +</option>
                            <option value="mbName" <? if($search == "mbName"){ echo"selected";}?>>이름</option>
                            <option value="mbId" <? if($search == "mbId"){ echo"selected";}?>>아이디</option>
                            <option value="mbEmail" <? if($search == "mbEmail"){ echo"selected";}?>>이메일</option>
							<option value="childName" <? if($search == "childName"){ echo"selected";}?>>자녀명</option>
                          </select>
                          <input type="text" name="keyword" value="<?=$keyword?>">
                          <input type="submit" value="검색" style="cursor:pointer; height:24px;">
                          <input type="button" value="목록" onClick="location.href = 'mb_list.php';" style="cursor:pointer; height:24px;">
                          <img src="/images/btn/btn_excel.gif" STYLE="CURSOR:POINTER;" onclick="saveToExcel()" align="absmiddle">
                        </td>
                      </tr>
                    </form>
                  </table>
                  <!-- 검색 끝 -->
                </td>
              </tr>
            </table>
            <table width='100%' cellpadding="5" cellspacing="0" border="0" align="center">
              <tr>
                <td colspan='10' height='3' bgcolor='#9DB0A1' style="padding:0;"></td>
              </tr>
              <tr height="26" bgcolor='#F2F3E8' align="center">
              <?
                 $temp = $PHP_SELF."?page=".$page;
			  ?>
              <form name="listForm" method="post" action="<?=$temp?>">              
				 <input type="hidden" name="choiceValue">

              <td width="6%">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="5">
                      <input name="select_all" type="checkbox" onClick="onSelectAll()" value="1">
                    </td>
                    <td align="center"><b>No</b></td>
                  </tr>
                </table>
              </td>
              <td width="10%"><b>회원구분</b></td>
              <td width="10%"><b>아이디</b></td>
              <td width="10%"><b>이름</b></td>
              <td width="10%"><b>닉네임</b></td>
              <td><b>이메일</b></td>               
              <td width="10%"><b>국회소속부처</b></td>
              <td width="10%"><b>등록일</b></td>
              </tr>
              
              <tr>
                <td style="height:1px;padding:0;" colspan='9' bgcolor='#EFEFEF'></td>
              </tr>
              <?	
				$no = $list_num - $set_page;
					if ($list_num){
						for ($i = $set_page; $i < $last; $i++){
							@mysql_data_seek($listResult,$i);						
							$row= mysql_fetch_array($listResult);					

							if($row[mbId] == $id){
								$tr_bgcolor = "#F5F5EA";
							}else{
								$tr_bgcolor = "#FFFFFF";
							}
              ?>
			  <input type="hidden" name="fcheck2" value="<?=$row[mbId]?>">
              <tr height="25" bgcolor="<?=$tr_bgcolor?>" onMouseOver="this.style.backgroundColor='#F5F5EA';" onMouseOut="this.style.backgroundColor='<?=$tr_bgcolor?>';"  align="center">
                <td>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="5">
                        <input type="checkbox" name="fcheck" value="<?=$row[mbId]?>">
                      </td>
                      <td align="center">
                        <?=$no?>
                      </td>
                    </tr>
                  </table>
                </td>
                <td><?=textMbStatus($row['mbStatus'])?></td>
                <td><a href='<?=$PHP_SELF?>?id=<?=$row[mbId]?>&search=<?=$search?>&keyword=<?=$keyword?>&page=<?=$page?>&mbStatus=<?=$mbStatus?>'> <b><?=$row['mbId']?></b></a> </td>
                <td><?=$row['mbName']?></td>
                <td><?=$row['mbNick']?></td>
                <td><a href="mailto:<?=$row['mbEmail']?>"><?=$row['mbEmail']?></a></td>
				<td><?=$row['mbGroup']?></td>
                <td><?=@date("Y.m.d", $row['mbRegdate']);?></td>
              </tr>
              <tr>
                <td style="height:1px;padding:0;" colspan='10' bgcolor='#EFEFEF'></td>
              </tr>
              <?						
					$no = $no-1; 
					}					
				}else{ // 게시물이 없을때
			 ?>
              <tr>
                <td align="center" height="30" colspan="9">등록된 회원이 없습니다.</td>
              </tr>
              <?		
				}
			?>
              <tr>
                <td colspan='10' height='3' bgcolor='#9DB0A1' style="padding:0;"></td>
              </tr>
            </table>
            <p style="margin-top:10px">
            <table width='100%' cellpadding=5 cellspacing=0 border=0 align=center>
              <tr>
                <td align="center">
                  <!-- start : 페이징 -->
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="90" align="center">
                        <!-- <input type="button" value=" 엑셀저장 " style="height:30; cursor:pointer" onclick="excel_save();"> -->
                        &nbsp;</td>
                      <td align="center">
                        <?if($list_num){echo"$paging[paging]";}else{echo"&nbsp;";} ?>
                      </td>
                      <td width="90" align="center">
						<table cellspacing="0" cellpadding="0">
							<tr>
								<td>
									<select name="mbStatus">
										<option value="">회원권한설정</option>
										<option value="R">준회원</option>
										<option value="Y">정회원</option>
										<? if($_SESSION['member_sAdmin'] == "M"){ ?>
										<option value="Z">입학관리자</option>
										<option value="A">관리자</option>
										<? } ?>
									</select>
								</td>
								<td>
									&nbsp;<input type="button" value="일괄변경" onClick="choiceClick();" style="cursor:pointer">
								</td>
							</tr>
						</table>
                        <!-- <input type="submit" value=" 회원삭제 " style="height:30; cursor:pointer"> --> &nbsp;
                      </td>
                    </tr>
                  </table>
                  <!-- end : 페이징 -->
                </td>
              </tr>

			  </form>

            </table>

          </td>
        </tr>
        <tr>
          <td height="100"></td>
        </tr>                
      </table>
    </td>
  </tr>
</table>

