<?
$name="ȸ�� ���";
$today = date("Y").date("m").date("d");
$filename = "[$today]$name.xls";
$speed = 250; // kb/s ������ �ٿ�ε带 �޴´�.
$isLimit = 0;
$disposition = "1";   // 1 �̸� �ٿ�, 0 �̸� �������� �ν��ϸ� ȭ�鿡 ��� 
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
include "../common/admin_login_check.php";				// �α��� üũ

if($_SESSION['member_level'] < 9){
	exit;
}

function textMbStatus($v){
	switch($v){
		case "A": $returnValue = "<font color='#FF0000'>������</font>"; break;
		case "R": $returnValue = "��ȸ��"; break;
		case "Y": $returnValue = "<font color='#0000FF'>��ȸ��</font>"; break;
		case "C": $returnValue = "Ż��ȸ��"; break;
		case "Z": $returnValue = "<font color='green'>���а�����</font>"; break;
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
<table id="contentTable" border='0' cellspacing='0' cellpadding='3' bordercolorlight='#007236' bordercolordark='#FFFFFF' style='font-size:11px; line-height:150%;' face='����ü'>
                            <TR height="26">
                                <TD bgcolor="#DDFFDD" width="40" align="center"><B>No</B></TD>
								<td bgcolor="#DDFFDD" width="60"><b>ȸ������</b></td>
								<td bgcolor="#DDFFDD" width="100"><b>���̵�</b></td>
								<td bgcolor="#DDFFDD" width="100"><b>�̸�</b></td>
								<td bgcolor="#DDFFDD"><b>�̸���</b></td>
								<td bgcolor="#DDFFDD" width="200"><b>��ȸ�ҼӺ�ó</b></td>
								<td bgcolor="#DDFFDD" width="200"><b>�ڳ��</b></td>
								<td bgcolor="#DDFFDD" width="80"><b>�����</b></td>
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
								<td align="center" height="30" colspan="9">��ϵ� ȸ���� �����ϴ�.</td>
							</tr>
<?}?>
            </table>
