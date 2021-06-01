<?
$name="회원 명단";
$today = date("Y").date("m").date("d");
$filename = "[$today]$name.xls";
$speed = 250; // kb/s 비율로 다운로드를 받는다.
$isLimit = 0;
$disposition = "1";   // 1 이면 다운, 0 이면 브라우져가 인식하면 화면에 출력 
$disposition = ($disposition) ? "attachment" : "inline"; 
header("Content-type: file/unknown"); 
header("Content-Disposition: $disposition; filename=$filename"); 
header("Pragma: no-cache"); 
header("Expires: 0"); 
echo "<meta http-equiv='content-type' content='text/html; charset=euc-kr'>";
echo "<style>td {font-size:12px;border:thin solid #EFEFEF;mso-number-format:'\@';}</style>";

$charType="no";
$cssType="no";
$iframeType="no";
$blurType="no";

include "../../include/global/config.php"; 
include "../common/admin_login_check.php";				// 로그인 체크

if($_SESSION['member_level'] < 9){
	exit;
}

function textMbStatus($v){
	switch($v){
		case "A": $returnValue = "<font color='#FF0000'>관리자</font>"; break;
		case "R": $returnValue = "준회원"; break;
		case "Y": $returnValue = "<font color='#0000FF'>정회원</font>"; break;
		case "C": $returnValue = "탈퇴회원"; break;
		case "Z": $returnValue = "<font color='green'>입학관리자</font>"; break;
	}
	return $returnValue;
}

$page=$page?$page:1;
$sort=$sort?$sort:"mbRegdate desc";

$where = "";
$where[] = "mbStatus not in ('C','M')";
if($mbStatus) $where[] = "mbStatus='$mbStatus'";
if($search && $keyword) $where[] = "$search like '%$keyword%'";
if($where) $where = " where ".implode(" and ",$where);
	
$total = sqlRowOne("select count(*) from ona_member $where");
$memberList = sqlArray("select * from ona_member $where order by $sort");
?>
<table id="contentTable" border='0' cellspacing='0' cellpadding='3' bordercolorlight='#007236' bordercolordark='#FFFFFF' style='font-size:11px; line-height:150%;' face='굴림체'>
                            <TR height="26">
                                <TD bgcolor="#DDFFDD" width="40" align="center"><B>No</B></TD>
								<td bgcolor="#DDFFDD" width="60"><b>회원구분</b></td>
								<td bgcolor="#DDFFDD" width="100"><b>아이디</b></td>
								<td bgcolor="#DDFFDD" width="100"><b>이름</b></td>
								<td bgcolor="#DDFFDD"><b>이메일</b></td>
								<td bgcolor="#DDFFDD" width="200"><b>국회소속부처</b></td>
								<td bgcolor="#DDFFDD" width="200"><b>자녀명</b></td>
								<td bgcolor="#DDFFDD" width="80"><b>등록일</b></td>
							</tr>
<?
if($memberList){
	$no = $total-$start;
	foreach($memberList as $k => $row){
		$row['childName'] = "";
		$tmpFamily = sqlArrayOne("select childName from ona_member_family where mbId='$row[mbId]'");
		if($tmpFamily) $row['childName'] = implode(",",$tmpFamily);
?>
                            <TR height="25">
								<td align="center"><?=$no?></td>
								<td><?=textMbStatus($row['mbStatus'])?></td>
								<td><b><?=$row['mbId']?></b></td>
								<td><?=$row['mbName']?></td>
								<td align="left"><?=$row['mbEmail']?></td>
								<td><?=$row['mbGroup']?></td>
								<td><?=$row['childName']?></td>
								<td><?=date("Y.m.d", $row['mbRegdate'])?></td>
							</tr>
<?						
		$no--;
	}
}
else{
?>
							<tr>
								<td align="center" height="30" colspan="9">등록된 회원이 없습니다.</td>
							</tr>
<?}?>
            </table>
