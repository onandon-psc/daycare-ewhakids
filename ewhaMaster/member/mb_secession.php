<?
	include "../../include/global/config.php"; 
	include "../common/admin_login_check.php";				// 로그인 체크

	if($search) $whereAnd .= " && ($search like '%$keyword%') ";

	$listQuery		= "SELECT * FROM gs_mb_secession WHERE 1=1 $whereAnd ORDER BY idx DESC";
	$listResult		= mysql_query($listQuery);
	$list_num		= @mysql_num_rows($listResult);	

	if(!$total_count){ $total_count = 10; }

	if ($page == ""){ $page = "1"; }				
	$url				= $PHP_SELF."?search=$search&keyword=$keyword";
	$total_page	= ceil($list_num/$total_count);
	$set_page 	= $total_count * ($page-1);
	$list_page 	= 10;
	$last 			= $page * $total_count;

	$paging		= common_paging($url,$list_num,$page,$list_page,$total_count);
	if ($last > $list_num){ $last = $list_num; }
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr height=30>
    <td bgcolor=#ececec>&nbsp;&nbsp;<b>▣ 회원탈퇴내역</b></td>
  </tr>
  <tr>
    <td height="15"></td>
  </tr>
  <tr>
    <td>
      <table width='100%' cellpadding='0' cellspacing='0' border='0' align='center'>
        <tr>
          <td>
            <table width='100%' cellpadding=0 cellspacing=0 border=0 align=center>
              <tr>
                <td>&nbsp;&nbsp;<b>
                  <? if($search){ echo"검색";}else{echo"전체";}?>
                  :
                  <?=number_format($list_num)?>
                  </b></td>
                <td align="right" style="padding:0 0 5 0">
                  <!-- 검색 시작 -->
                  <table cellpadding='0' cellspacing='0' border='0'>
                    <form name="searchForm" method="post" action="<?=$PHP_SELF?>">
                      <tr>
                        <td>
                          <select name="search" class="list">
                            <option value="">+ 검색구분 선택 +</option>
                            <option value="name" <? if($search == "name"){ echo"selected";}?>>이름</option>
                            <option value="userid" <? if($search == "userid"){ echo"selected";}?>>아이디</option>
                            <option value="mobile" <? if($search == "mobile"){ echo"selected";}?>>전화번호</option>
                          </select>
                          <input type="text" name="keyword" value="<?=$keyword?>">
                          <input type="submit" value="검색" style="cursor:pointer; height:24px;">
                          <input type="button" value="목록" onClick="location.href='mb_secession.php';" style="cursor:pointer; height:24px;">
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
				  <td colspan='6' height='3' bgcolor='#9DB0A1' style="padding:0;"></td>
              </tr>
              <tr height="26" bgcolor='#F2F3E8' align="center">
				  <td width="5%"><b>No</b></td>
				  <td width="10%"><b>탈퇴일</b></td>
				  <td width="8%"><b>아이디</b></td>
				  <td width="8%"><b>이름</b></td>
				  <td width="10%"><b>전화</b></td>
				  <td width=""><b>탈퇴사유</b></td>
              </tr>              
              <tr>
	              <td colspan='6' bgcolor='#EFEFEF' style="padding:0;"></td>
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
              <tr height="25" bgcolor="<?=$tr_bgcolor?>" onMouseOver=this.style.backgroundColor='#F5F5EA' onMouseOut=this.style.backgroundColor='<?=$tr_bgcolor?>'  align="center">
                <td><?=$no?></td>
                <td><?=date("Y.m.d H:i",$row['regdate'])?></td>
                <td><b><?=$row['userid']?></b></td>
                <td><?=$row['name']?></td>
                <td><?=$row['mobile']?></td>
                <td align="left"><?=nl2br($row['content'])?></td>
              </tr>
              <tr>
                <td  colspan='6' bgcolor='#EFEFEF' style="padding:0;"></td>
              </tr>
              <?						
					$no = $no-1; 
					}
					
				}else{ // 게시물이 없을때
			 ?>
              <tr>
                <td align="center" height="30" colspan="6">내역이 없습니다.</td>
              </tr>
              <?		
				}
			?>
              <tr>
                <td colspan='6' height='3' bgcolor='#9DB0A1' style="padding:0;"></td>
              </tr>
            </table>
            <p style="margin-top:10px">
            <table width='100%' cellpadding=5 cellspacing=0 border=0 align=center>
              <tr>
                <td align="center">
                  <!-- start : 페이징 -->
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="center">
                        <?if($list_num){echo"$paging[paging]";}else{echo"&nbsp;";} ?>
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
