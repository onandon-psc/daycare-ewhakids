<?
	include "../../include/global/config.php"; 
	include "../common/admin_login_check.php";				// �α��� üũ
	if($_SESSION['member_level'] < 9){
		echo "<script>alert('���� ������ �����ϴ�.');</script>";
		exit;
	}
$FramePageTitle = "�������";

$GRIDWIDTH = 36; //===== ��� �׸��� ũ��
$TOTWIDTH  = $GRIDWIDTH * (20+3) + 80;
if (!$mode) {
	$cyear = date("Y");
	$cmonth = date("m");
	$cday = date("d");
	$mode = "day";
}

$cmonth = ($cmonth < 10 ? "0" . intval($cmonth) : $cmonth);
$cday   = ($cday < 10 ? "0" . intval($cday) : $cday);

if ($mode=="netstat") {
	$refresh = 30;
} else {
	$refresh = 30;
}
?>

<?
//======================================================== ���� ��Ȳ
$arrLog = GetTodayCounter();
$todHit = $arrLog[TODAY];
?>

<style type="text/css">
input.norm { width:60px; height:20px; border:1px outset #cccccc; background-color:#ffffff; cursor:pointer; }
input.sel  { width:60px; height:20px; border:1px outset #cccccc; background-color:#F1E650; cursor:pointer; }
.line_lt 		{ background-color:#CCCCCC; } /* Light Line */
.list_hd 		{ background-color:#EEEEEE; color:#8080C0; } /* List Header 1 */
.content 		{ background-color:#FFFFFF; } /* Content */
a, a:visited			{ color:#8080FF; text-decoration:none; }
a:hover, a:active	{ color:#000075; text-decoration:underline; }
.searchbar	{ background-color:#efefef; } /* Search Bar */
* { font-family:����; font-size:12px; line-height:150%; }
</style>

<!------------------------ �˻� �� ��� ------------------------->
<script language=javascript>
function ViewLogMode(mode) {
	window.location.href = "<?=$PHP_SELF?>?reftype=<?=$reftype?>&cyear=<?=$cyear?>&cmonth=<?=$cmonth?>&cday=<?=$cday?>&mode=" + mode;
}
</script>


<table width="100%" border=0 cellspacing=1 cellpadding=2 class=line_lt>
	<tr><td align=center class=searchbar height=28>
		<b><?=HDate("n�� d��(K)")?></b> ���� ������� &nbsp;
		<b>��ü</b> : <span style="color:#EE3200;"><?=$arrLog[TOTAL]?>ȸ</span>,
		<b>����</b> : <span style="color:#0076EE;"><?=$todHit?>ȸ</span>,
		<b>����</b> : <?WriteUpDownLog($todHit, $arrLog[YESTER]);?>,
		<b>���</b> : <?WriteUpDownLog($todHit, $arrLog[AVERAGE]);?>,
		<b>�ִ�</b> : <?WriteUpDownLog($todHit, $arrLog[MAX]);?>,
		<b>�ּ�</b> : <?WriteUpDownLog($todHit, $arrLog[MIN]);?>
	</td></tr>
</table>


<form action="<?=$PHP_SELF?>"><input type=hidden name=mode value="<?=$mode?>">
<table height=28 border=0 cellspacing=1 cellpadding=2 align=center>
<tr><td align=center nowrap>
	<?
	echo("<select name=cyear style='width:67;' onchange='this.form.submit();'>");
	if (eregi("netstat|hourall|week|os|agent|referer", $mode)) {
		echo("<option value='' selected style='background:#E3E3E3;'>------</option>");
	} else {
		for ($i = 2004; $i <= date("Y")+1; $i++) printf("<option value=%d %s>%d��", $i, ($cyear==$i ? "selected" : ""), $i);
	}
	echo("</select>\n");

	echo("<select name=cmonth style='width:55;' onchange='this.form.submit();'>");
	if (eregi("netstat|hourall|month|week|os|agent|referer", $mode)) {
		echo("<option value='' selected style='background:#E3E3E3;'>----</option>");
	} else {
		for($i = 1; $i <= 12; $i++) printf("<option value=%d %s>%02d��", $i, ($cmonth==$i ? "selected" : ""), $i);
	}
	echo("</select>\n");

	echo("<select name=cday style='width:55;' onchange='this.form.submit();'>");
	if ($mode!="hour") {
		echo("<option value='' selected style='background:#E3E3E3;'>----</option>");
	} else {
		for($i = 1; $i <= 31; $i++) printf("<option value=%d %s>%02d��", $i, ($cday==$i ? "selected" : ""), $i);
	}
	echo("</select>\n");
	?>
	<input type=button class=<?=($mode=="month" ?   "sel" : "norm")?> value=" ���� " onclick="javascript:ViewLogMode('month');">
	<input type=button class=<?=($mode=="day" ?     "sel" : "norm")?> value=" ��¥�� " onclick="javascript:ViewLogMode('day');">
	<input type=button class=<?=($mode=="hour" ?    "sel" : "norm")?> value=" �ð��� " onclick="javascript:ViewLogMode('hour');">
	<input type=button class=<?=($mode=="hourall" ? "sel" : "norm")?> value="��ü�ð�" onclick="javascript:ViewLogMode('hourall');">
	<input type=button class=<?=($mode=="week" ?    "sel" : "norm")?> value=" ���Ϻ� " onclick="javascript:ViewLogMode('week');">
	<input type=button class=<?=($mode=="os" ?      "sel" : "norm")?> value="�ü��" onclick="javascript:ViewLogMode('os');">
	<input type=button class=<?=($mode=="agent" ?   "sel" : "norm")?> value="������" onclick="javascript:ViewLogMode('agent');">
	<input type=button class=<?=($mode=="referer" ? "sel" : "norm")?> value="���ӷ�Ʈ" onclick="javascript:ViewLogMode('referer');">
</td></tr>
</table>
</form>

<?
if (ereg("month|day|hour|hourall|week|os|agent", $mode)) {
	include_once("mb_counter_time.php");
} elseif (ereg("referer|netstat", $mode)) {
	include_once("mb_counter_ref.php");
}

$incstr = "log";
?>


