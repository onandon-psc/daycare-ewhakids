<?
	include "../../include/global/config.php"; 
	include "../common/admin_login_check.php";				// 로그인 체크

	if($_SESSION['member_level'] < 9){
		echo "<script>alert('접근 권한이 없습니다.');</script>";
		exit;
	}

	$tableName		= "ona_member";
	$tableName2	= "ona_member_family";
	
	$id					= trim($_REQUEST['id']);
	$delValue			= trim($_POST['delValue']);
	$delValue2		= trim($_POST['delValue2']);
	
	// 삭제
	if($delValue){

		$ex	 = explode(",",$delValue);
		$ex2	 = explode(",",$delValue2);

		for($i=0; $i < count($ex); $i++){

			if($i == 0){
				$sql .= "'".$ex[$i]."'";
				$sql2 .= "'".$ex2[$i]."'";
			}else{
				$sql .= ",'".$ex[$i]."'";
				$sql2 .= "'".$ex2[$i]."'";
			}

		}	

		// 가입자 삭제
		$query = "DELETE FROM $tableName WHERE idx in ( $sql )";
		mysql_query($query);		

		// 자녀 삭제
		$query = "DELETE FROM $tableName2 WHERE userid in ( $sql2 )";
		mysql_query($query);

		goUrl('mb_list.php');

	}

	if( $memtype1 ) $whereAnd .= " && memtype1='$memtype1' ";
	if($search) $whereAnd .= " && ($search like '%$keyword%') ";
	if($status2) $whereAnd .= " && status2='1' ";

	$listQuery		= "SELECT * FROM $tableName WHERE idx!='' and status1!='2' $whereAnd ORDER BY idx DESC";
	$listResult		= mysql_query($listQuery);
	$list_num		= @mysql_num_rows($listResult);	

	if(!$total_count){ $total_count = 20; }

	if ($page == ""){ $page = "1"; }				
	$url				= $PHP_SELF."?memtype1=$memtype1&search=$search&keyword=$keyword";
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
<link rel="stylesheet" href="../include/css/style.css" type="text/css">
<script type="text/JavaScript">
function MM_openBrWindow(theURL,winName,features) { //v2.0
	window.open(theURL,winName,features);
}
function sms_check(f){
	if( f.smsType[0].checked == false && f.smsType[1].checked == false && f.smsType[2].checked == false ){
		alert("SMS를 보낼 회원분류를 선택하십시오!");
		return false;
	}		
	if(f.smsType[1].checked == true){
		var check_value = getChecked();
		if(check_value == ""){
			alert("SMS를 보낼 회원을 선택하세요!");
			return false;
		}else{
			f.delValue.value = check_value;
		}		
	}
	f.submit();
}
</script>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr height=30>
    <td bgcolor=#ececec>&nbsp;&nbsp;<b>▣ 회원 SMS발송</b></td>
  </tr>
  <tr>
    <td height="15"></td>
  </tr>
  <? ############################## Start : 상세보기 ############################## 
	  if( $id ){

		$query	= "SELECT * FROM ona_member WHERE userid='".$id."' and status1!='2'";
		$result	= mysql_query($query, $db);
		$row		= mysql_fetch_array($result);
		$query = "select * from ona_member_family where userid = '".$id."' and relation != '본인' and status1!='2'";
		$childRows = sqlArray($query);

		$exEmail	= explode("@", $row[email]);		
		$exHp		= explode("-", $row[mobile]);
		$exPost	= explode("-", $row[homezipcode]);
		$exCpTel	= explode("-", $row[cpTel]);

		if ( $row[telType] == "H" ) {
			$exTel	= explode("-", $row[homephone]);
		}else{
			$exTel	= explode("-", $row[workphone]);
		}

		$modeValue = "modify";
  ?>
  <form name="locationFrm" method="post">
	<input type="hidden" name="pno">
	<input type="hidden" name="userid">
	<input type="hidden" name="passwd">
  </form>

  <form name="frm" method="post" action="/gsMaster/member/sms_proc.php" onsubmit="return input_check(this);" target="iframe">
	<input type="hidden" name="mode" value="<?=$modeValue?>">
	<input type="hidden" name="memtype1" value="<?=$row[memtype1]?>">

  <tr>	
	<td>
		<br>
		<!--기본정보입력(s)-->
		<? include "../../html/member/member2_0.php"; ?>
		<!--기본정보입력(e)-->
		<br>									
<?if($row[memtype1]=="부모"){?>
		<!-- 부모 -->
		<div id="member_style1"><? include "../../html/member/member2_1.php"; ?></div>
<?}?>
<?if($row[memtype1]=="일반"){?>
		<!-- 일반 -->
		<div id="member_style2"><? include "../../html/member/member2_2.php"; ?></div>
<?}?>
<?if($row[memtype1]=="시설"){?>
		<!-- 시설 -->
		<div id="member_style3"><? include "../../html/member/member2_3.php"; ?></div>
<?}?>
<?if($row[memtype1]=="종사자"){?>
		<!-- 종사자 -->
		<div id="member_style4"><? include "../../html/member/member2_4.php"; ?></div>
<?}?>
<?if($row[memtype1]!="일반"){?>
		<!--자녀정보입력(s)-->
		<div id="toyEntryDisplay"><? include "../../html/member/member_toy.php"; ?></div>
<?}?>
	</td>
  </tr>
  <tr>
	<td  style="padding:10 0 50 0">		
	  <!--버튼(s)-->
	  <table width="660" border="0" cellspacing="0" cellpadding="0">
		<tr>
		  <td align="center"><input type="image" src="../../images/btn/btn_mok.gif" alt="확인" border="0" onfocus="this.blur();"><img src="../../images/btn/btn_mfalse.gif" alt="취소" onclick="history.back();" onfocus="this.blur();"></td>
		</tr>
	  </table>
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
						  <input type="checkbox" name="status2" value="1" <?if($status2=="1"){echo"checked";}?>> 실명인증&nbsp;&nbsp;&nbsp;
                          <select name="memtype1" class="list">
                            <option value="">+ 회원구분 선택 +</option>
                            <option value="부모" <?if($memtype1=="부모"){echo"selected";}?>>부모</option>
                            <option value="일반" <?if($memtype1=="일반"){echo"selected";}?>>일반</option>
                            <option value="시설" <?if($memtype1=="시설"){echo"selected";}?>>시설</option>
                            <option value="종사자" <?if($memtype1=="종사자"){echo"selected";}?>>종사자</option>
                          </select>
                          <select name="search" class="list">
                            <option value="">+ 검색구분 선택 +</option>
                            <option value="name" <? if($search == "name"){ echo"selected";}?>>이름</option>
                            <option value="userid" <? if($search == "userid"){ echo"selected";}?>>아이디</option>
                            <option value="email" <? if($search == "email"){ echo"selected";}?>>이메일</option>
                          </select>
                          <input type="text" name="keyword" value="<?=$keyword?>">
                          <input type="submit" value="검색" style="cursor:pointer; height:24px;">
                          <input type="button" value="목록" onClick="location.href='mb_list.php';" style="cursor:pointer; height:24px;">
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
              
              <form name="listForm" method="post" action="<?=$PHP_SELF?>" onSubmit="return delClick()">              
				 <input type="hidden" name="delValue">
				 <input type="hidden" name="delValue2">

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
              <td width="10%"><b>전화</b></td>
              <td width="10%"><b>휴대폰</b></td>
              <td><b>이메일</b></td>
			  <td width="6%"><b>실명인증</b></td>
              <td width="10%"><b>등록일</b></td>
              </tr>
              
              <tr>
                <td  colspan='8' bgcolor='#EFEFEF' style="padding:0;"></td>
              </tr>
              <?	
				$no = $list_num - $set_page;
					if ($list_num){
						for ($i = $set_page; $i < $last; $i++){
							@mysql_data_seek($listResult,$i);						
							$row= mysql_fetch_array($listResult);					

							if($row[userid] == $id){
								$tr_bgcolor = "#F5F5EA";
							}else{
								$tr_bgcolor = "#FFFFFF";
							}
              ?>
			  <input type="hidden" name="fcheck2" value="<?=$row[userid]?>">
              <tr height="25" bgcolor="<?=$tr_bgcolor?>" onMouseOver=this.style.backgroundColor='#F5F5EA' onMouseOut=this.style.backgroundColor='<?=$tr_bgcolor?>'  align="center">
                <td>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="5">
                        <input type="checkbox" name="fcheck" value="<?=$row[idx]?>">
                      </td>
                      <td align="center">
                        <?=$no?>
                      </td>
                    </tr>
                  </table>
                </td>
                <td>
                  <?=$row['memtype1']?>
                </td>
                <td><a href='mb_list.php?id=<?=$row[userid]?>&search=<?=$search?>&keyword=<?=$keyword?>&page=<?=$page?>'> <b>
                  <?=$row['userid']?>
                  </b></a> </td>
                <td>
                  <?=$row['name']?>
                </td>
                <td>
                  <?
					 if ( $row['telType'] == "H" ){ 
						echo $row['homephone'];
					 }else{
						echo $row['workphone'];
					 }
				  ?>
                </td>
                <td>
                  <?=$row['mobile']?>
                </td>
                <td><a href="mailto:<?=$row['email']?>">
                  <?=$row['email']?>
                  </a></td>
				 <td>
                  <?=$row[status2]=="1"?"<b>O</b>":"&nbsp;"?>
                </td>
                <td>
                  <?=date("Y.m.d", $row['regdate']);?>
                </td>
              </tr>
              <tr>
                <td  colspan='10' bgcolor='#EFEFEF' style="padding:0;"></td>
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
                        <!-- <input type="submit" value=" 회원삭제 " style="height:30; cursor:pointer"> --> &nbsp;
                      </td>
                    </tr>
                  </table>
                  <!-- end : 페이징 -->
                </td>
              </tr>
			</form>
            </table>

			<!-- SMS 발송 -->
			<table width='100%' cellpadding="3" cellspacing="0" border="0">
			<form name="smsFrm" method="post" action="sms_proc.php" onsubmit="return sms_check(this);" target="iframe">
				<input type="hidden" name="memtype1" value="<?=$memtype1?>">
				<input type="hidden" name="search" value="<?=$search?>">
				<input type="hidden" name="keyword" value="<?=$keyword?>">
				<input type="hidden" name="delValue">
				<tr> 
				  <td width="100%" align="center">
						<input type="radio" name="smsType" value="S"> 검색된 회원&nbsp;&nbsp;
						<input type="radio" name="smsType" value="C"> 선택된 회원&nbsp;&nbsp;
						<input type="radio" name="smsType" value="A"> 전체 회원
						에게
						<input type="submit" value="SMS전송">
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
