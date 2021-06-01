<?
	include "../../include/global/config.php"; 
	include "../common/admin_login_check.php";				// 로그인 체크

	if($_SESSION['member_level'] < 9){
		echo "<script>alert('접근 권한이 없습니다.');</script>";
		exit;
	}

	$tableName		= "gs_act";
	$_ACT_ARR = sqlArray("select idx, name from gs_act_list order by idx asc");
	
	$mode = trim($_POST['mode']);
	$memberno = trim($_POST['memberno']);
	$act = $_POST['act'];
	
	if($mode=="insert"){
		$tmp = sqlRowOne("select count(*) from ona_member_family where memberno = '$memberno'");
		if(!$tmp){
			echo "<script>alert('등록된 회원카드가 아닙니다.');</script>";
			exit;
		}
		foreach($act as $v){
			if($v){
				$query = "insert into $tableName set memberno = '$memberno', intime = now(), act = '$v'";
				mysql_query($query);
			}
		}
		echo "<script>parent.location.reload();</script>";
		exit;
	}

?>

<style type="text/css">
.gray  { color:gray; }
td.graph { background-image:url(/images/admin/counter_log_bg.gif); color:gray; }
span.pct { font-family:arial; font-size:7pt; color:#999999; }
input.norm { width:60px; height:20px; border:1px outset #cccccc; background-color:#ffffff; cursor:pointer; }
input.sel  { width:60px; height:20px; border:1px outset #cccccc; background-color:#F1E650; cursor:pointer; }
.line_lt 		{ background-color:#CCCCCC; } /* Light Line */
.list_hd 		{ background-color:#EEEEEE; color:#8080C0; } /* List Header 1 */
.content 		{ background-color:#FFFFFF; } /* Content */
a, a:visited			{ color:#8080FF; text-decoration:none; }
a:hover, a:active	{ color:#000075; text-decoration:underline; }
.searchbar	{ background-color:#efefef; } /* Search Bar */
* { font-family:돋움; font-size:12px; line-height:150%; }
</style>

<script language='javascript' src='/include/js/func.js'></script>
<script>
function checkActForm(form){
	var tmpChked = false;
	for(i=0;i<form.elements.length;i++){
		if(form[i].name.indexOf("act")>=0){
			if(form[i].checked) tmpChked = true;
		}
	}
	if(!tmpChked){alert("이용시설을 선택해 주세요.");return false;}
	if(!form.memberno.value){alert("회원카드를 찍어 주세요.");form.memberno.focus();return false;}
	return true;
}
</script>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr height=30>
    <td bgcolor=#ececec>&nbsp;&nbsp;<b>▣ 회원시설이용</b></td>
  </tr>
  <tr>
    <td height="15"></td>
  </tr>
</table>

<table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td>
<table align=left border=0 cellpadding=0 cellspacing=0 style="padding-right:10">
<form name="actForm" target="iframe" method="post" onsubmit="return checkActForm(this)">
<input type="hidden" name="mode" value="insert">
	<tr height=30>
		<td><input type="button" value="시설관리" onclick="location='mb_act_list.php';" class="norm"></td>
		<td>
			<input type="checkbox" onClick="check_all(this)" name="act">전체선택
			<?if($_ACT_ARR) foreach($_ACT_ARR as $k => $v){?>
			<input type="checkbox" name="act[]" value="<?=$v[idx]?>"><?=$v[name]?>
			<?}?>
		</td>
		<td>회원번호</td>
		<td><input type="text" name="memberno" class="input" onkeydown="onlyId()" onkeypress="onlyId()" onpaste="return false;" style="IME-MODE:DISABLED;"></td>
		<td><input type="submit" value="확인" class="norm"></td>
	</tr>
</form>
</table>
</td></tr></table>

<?
$arrLog[TOTAL] = sqlRowOne("select count(*) from gs_act");
$arrLog[TODAY] = sqlRowOne("select count(*) from gs_act where date(intime) = curdate()");
$GRIDWIDTH = 36; //===== 통계 그리드 크기
$TOTWIDTH  = $GRIDWIDTH * (20+3) + 80;
$mode = $_GET[mode]?$_GET[mode]:"day";
$act = $_GET[act]?$_GET[act]:"";
$actquery = $act?" and act = '$act' ":"";
$cyear = $cyear?$cyear:date("Y");
$cmonth = $cmonth?$cmonth:date("m");
$cday = $cday?$cday:date("d");
$cmonth = ($cmonth < 10 ? "0" . intval($cmonth) : $cmonth);
$cday   = ($cday < 10 ? "0" . intval($cday) : $cday);
?>
<script language=javascript>
function ViewLogMode(mode) {
	window.location.href = "<?=$PHP_SELF?>?reftype=<?=$reftype?>&cyear=<?=$cyear?>&cmonth=<?=$cmonth?>&cday=<?=$cday?>&act=<?=$act?>&mode=" + mode;
}
</script>

<table width="100%" border=0 cellspacing=1 cellpadding=2 class=line_lt>
	<tr><td align=center class=searchbar height=28>
		<b><?=HDate("n월 d일(K)")?></b> 현재 시설이용통계 &nbsp;
		<b>전체</b> : <span style="color:#EE3200;"><?=$arrLog[TOTAL]?>회</span>,
		<b>오늘</b> : <span style="color:#0076EE;"><?=$arrLog[TODAY]?>회</span>,
	</td></tr>
</table>

<form action="<?=$PHP_SELF?>">
<input type=hidden name=mode value="<?=$mode?>">
<table height=28 border=0 cellspacing=1 cellpadding=2 align=center>
<tr><td align=center nowrap>
			<select name="act" class="input" onchange='this.form.submit();'>
			<option value="">전체
			<?if($_ACT_ARR) foreach($_ACT_ARR as $k => $v){?>
			<option value="<?=$v[idx]?>" <?=$act==$v[idx]?"selected":""?>><?=$v[name]?>
			<?}?>
			</select>
	<?
	echo("<select name=cyear style='width:67;' onchange='this.form.submit();'>");
	if (eregi("netstat|hourall|week|os|agent|referer", $mode)) {
		echo("<option value='' selected style='background:#E3E3E3;'>------</option>");
	} else {
		for ($i = 2004; $i <= date("Y")+1; $i++) printf("<option value=%d %s>%d년", $i, ($cyear==$i ? "selected" : ""), $i);
	}
	echo("</select>\n");

	echo("<select name=cmonth style='width:55;' onchange='this.form.submit();'>");
	if (eregi("netstat|hourall|month|week|os|agent|referer", $mode)) {
		echo("<option value='' selected style='background:#E3E3E3;'>----</option>");
	} else {
		for($i = 1; $i <= 12; $i++) printf("<option value=%d %s>%02d월", $i, ($cmonth==$i ? "selected" : ""), $i);
	}
	echo("</select>\n");

	echo("<select name=cday style='width:55;' onchange='this.form.submit();'>");
	if ($mode!="hour") {
		echo("<option value='' selected style='background:#E3E3E3;'>----</option>");
	} else {
		for($i = 1; $i <= 31; $i++) printf("<option value=%d %s>%02d일", $i, ($cday==$i ? "selected" : ""), $i);
	}
	echo("</select>\n");

	?>
	<input type=button class=<?=($mode=="month" ?   "sel" : "norm")?> value=" 월별 " onclick="javascript:ViewLogMode('month');">
	<input type=button class=<?=($mode=="day" ?     "sel" : "norm")?> value=" 날짜별 " onclick="javascript:ViewLogMode('day');">
	<input type=button class=<?=($mode=="hour" ?    "sel" : "norm")?> value=" 시간별 " onclick="javascript:ViewLogMode('hour');">
	<input type=button class=<?=($mode=="hourall" ? "sel" : "norm")?> value="전체시간" onclick="javascript:ViewLogMode('hourall');">
	<input type=button class=<?=($mode=="week" ?    "sel" : "norm")?> value=" 요일별 " onclick="javascript:ViewLogMode('week');">
</td></tr>
</table>
</form>


<table border=0 cellspacing=1 cellpadding=0 class=line_lt align=center>
<tr><td bgcolor="#ffffff">

	<!------------------------ 그래프 타이틀 ------------------------->
	<table width="<?=$TOTWIDTH-4?>" border=0 cellspacing=0 cellpadding=0 style="table-layout:fixed">
	<col width=80></col><col width=></col>
	<tr class=list_hd>
		<td height=22 nowrap>&nbsp;</td>
		<td>
			<table border=0 cellspacing=0 cellpadding=0>
				<tr>
					<td>
						<table border=0 width=<?=$GRIDWIDTH*20?> cellspacing=0 cellpadding=0 align=left>
							<tr valign=bottom>
								<td width="20%" class=list_hd> 0%</td>
								<td width="20%" class=list_hd>20%</td>
								<td width="20%" class=list_hd>40%</td>
								<td width="20%" class=list_hd>60%</td>
								<td width="20%" class=list_hd>80%</td>
							</tr>
						</table>
					</td>
					<td width=<?=$GRIDWIDTH?> class=list_hd>100%</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr><td colspan=2 height=1 class=line_lt></td></tr>
	<?if ($mode=="month") { //========================== 월별 통계 =============================?>
		<?
		$trs = sqlRow("SELECT count(*) as TOT FROM gs_act WHERE year(intime) = '$cyear' $actquery");
		$TOT = $trs[TOT];
		if (!$TOT) $TOT = 1;
		unset($trs);

		for ($i = 1; $i <= 13; $i++) {
			$ii = ($i < 10 ? "0$i" : $i);
			if ($i > 12) {
				$MTOT = $TOT;
			} else {
				$trs = sqlRow("SELECT count(*) as TOT FROM gs_act WHERE year(intime) = '$cyear' and month(intime) = '$ii' $actquery");
				$MTOT = $trs[TOT];
				unset($trs);
			}
			$WID = intval($MTOT/$TOT*($GRIDWIDTH*20));
			$PCT = round(($MTOT/$TOT)*100, 2);
			if ($i > 12) {
				echo("<tr><td colspan=2 height=1 bgcolor='#cccccc'></td></tr>\n");
				echo("<tr class=content height=24>\n<td align=center><b>TOTAL</b></td><td class=graph nowrap>");
			} else {
				echo("<tr class=content height=24>\n");
				echo("<td align=center><a href='$PHP_SELF?mode=day&cyear=$cyear&cmonth=$i'>$ii 월</a></td>\n");
				echo("<td class=graph>");
			}
			printf("<span class='filterwhite%s' style='height:10px;width:%dpx;' title='접속수 : %s회 (%s%%)'><script></script></span>", ($i > 12 ? "blue" : "green"), $WID, number_format($MTOT), $PCT);
			if ($MTOT > 0) printf("%s <span class=pct>(%s%%)</span>", number_format($MTOT), $PCT);
			echo("</td></tr><tr>\n");
			echo("<td colspan=2 height=1></td></tr>\n");
		}
	?>

	<?} elseif ($mode=="day") { //========================== 일별 통계 =============================?>

		<?
		$DAY_MAX = HDate("t", mktime(0, 0, 0, $cmonth, 1, $cyear)); //===== 달의 마지막 날
		$trs = sqlRow("SELECT count(*) as TOT FROM gs_act WHERE year(intime) = '$cyear' and month(intime) = '$cmonth' $actquery");
		$TOT = $trs[TOT];
		if (!$TOT) $TOT = 1;
		unset($trs);

		for ($i = 1; $i <= $DAY_MAX+1; $i++) {
			$ii = ($i < 10 ? "0$i" : $i);
			if ($i > $DAY_MAX) {
				$MTOT = $TOT;
			} else {
				$trs = sqlRow("SELECT count(*) as TOT FROM gs_act WHERE date(intime)='$cyear-$cmonth-$ii' $actquery");
				$MTOT = $trs[TOT];
				unset($trs);
			}
			$WID = intval($MTOT/$TOT*($GRIDWIDTH*20));
			$PCT = round(($MTOT/$TOT)*100, 2);

			if ($i > $DAY_MAX) {
				echo("<tr><td colspan=2 height=1 bgcolor='#cccccc'></td></tr>\n");
				$WKSTR = "<b>TOTAL</b>";
			} else {
				$WKSTR = HDate("K", mktime(0, 0, 0, $cmonth, $ii, $cyear));
				if ($WKSTR=="일") $WKSTR = "<span style='color:#ff0000'>($WKSTR)</span>";
				elseif ($WKSTR=="토") $WKSTR = "<span style='color:#0000ff'>($WKSTR)</span>";
				else $WKSTR = "<span class=gray>($WKSTR)</span>";
				$WKSTR = "$ii $WKSTR";
			}
			echo("<tr class=content height=16>\n");
			if ($i > $DAY_MAX) {
				echo("<td align=center valign=bottom>$WKSTR</td>\n<td class=graph nowrap>");
			} else {
				echo("<td align=center valign=bottom><a href='$PHP_SELF?mode=hour&cyear=$cyear&cmonth=$cmonth&cday=$i'>$WKSTR</a></td>\n");
				echo("<td class=graph>");
			}
			printf("<span class='filterwhite%s' style='height:10px;width:%dpx;' title='접속수 : %s회 (%s%%)'><script></script></span>", ($i > $DAY_MAX ? "blue" : "green"), $WID, number_format($MTOT), $PCT);
			if ($MTOT > 0) printf("%s <span class=pct>(%s%%)</span>", number_format($MTOT), $PCT);
			echo("</td></tr><tr>\n");
			echo("<td colspan=2 height=1></td></tr>\n");
		}
		?>
	<?} elseif ($mode=="hour") { //========================== 시간별 통계 =============================?>

		<?
		$tmptrs = sqlArray("SELECT hour(intime) HOUR,count(*) CNT FROM gs_act WHERE date(intime)='$cyear-$cmonth-$cday' $actquery group by hour(intime)");
		$TOT = 0;
		if($tmptrs) foreach($tmptrs as $k => $v){
			$trs['H_'.$v['HOUR']]=$v['CNT'];
			$TOT +=$v['CNT'];
		}
		if (!$TOT) $TOT = 1;
		for($i = 0; $i < 24+1; $i++) {
			$ii = ($i < 10 ? "0$i" : $i);
			if ($i > 23) {
				$MTOT = $TOT;
				echo("<tr><td colspan=2 height=1 bgcolor='#cccccc'></td></tr>\n");
			} else {
				$MTOT = $trs["H_$i"];
			}
			$WID = intval($MTOT/$TOT*($GRIDWIDTH*20));
			$PCT = round(($MTOT/$TOT)*100, 2);

			echo("<tr class=content height=16 onclick='window.history.go(-1);' style='cursor:pointer;' title='클릭하시면 이전화면으로 돌아갑니다.'>\n");
			if ($i > 23) {
				echo("<td align=center valign=bottom><b>TOTAL</b></td>\n<td class=graph nowrap>");
			} else {
				echo("<td align=center>$ii 시</td>\n");
				echo("<td class=graph nowrap>");
			}
			printf("<span class='filterwhite%s' style='height:10px;width:%dpx;' title='접속수 : %s회 (%s%%)'><script></script></span>", ($i > 23 ? "blue" : "green"), $WID, number_format($MTOT), $PCT);
			echo(" ");
			if ($MTOT > 0) printf("%s <span class=pct>(%s%%)</span>", number_format($MTOT), $PCT);
			echo("</td></tr><tr>\n");
			echo("<td colspan=2 height=1></td></tr>\n");
		}
		unset($trs);
		?>

	<?} elseif ($mode=="hourall") { //========================== 전체 시간별 통계 =============================?>

		<?
		$tmptrs = sqlArray("SELECT hour(intime) HOUR,count(*) CNT FROM gs_act WHERE 1=1 $actquery group by hour(intime)");
		$TOT = 0;
		if($tmptrs) foreach($tmptrs as $k => $v){
			$trs['H_'.$v['HOUR']]=$v['CNT'];
			$TOT +=$v['CNT'];
		}
		if (!$TOT) $TOT = 1;
		for($i = 0; $i < 24+1; $i++) {
			$ii = ($i < 10 ? "0$i" : $i);
			if ($i > 23) {
				$MTOT = $TOT;
				echo("<tr><td colspan=2 height=1 bgcolor='#cccccc'></td></tr>\n");
			} else {
				$MTOT = $trs["H_$i"];
			}
			$WID = intval($MTOT/$TOT*($GRIDWIDTH*20));
			$PCT = round(($MTOT/$TOT)*100, 2);

			echo("<tr class=content height=16 onclick='window.history.go(-1);' style='cursor:pointer;' title='클릭하시면 이전화면으로 돌아갑니다.'>\n");
			if ($i > 23) {
				echo("<td align=center valign=bottom><b>TOTAL</b></td>\n<td class=graph nowrap>");
			} else {
				echo("<td align=center>$ii 시</td>\n");
				echo("<td class=graph nowrap>");
			}
			printf("<span class='filterwhite%s' style='height:10px;width:%dpx;' title='접속수 : %s회 (%s%%)'><script></script></span>", ($i > 23 ? "blue" : "green"), $WID, number_format($MTOT), $PCT);
			echo(" ");
			if ($MTOT > 0) printf("%s <span class=pct>(%s%%)</span>", number_format($MTOT), $PCT);
			echo("</td></tr><tr>\n");
			echo("<td colspan=2 height=1></td></tr>\n");
		}
		unset($trs);
		?>

	<?} elseif ($mode=="week") { //========================== 요일별 통계 =============================?>

		<?
		$ARRWEEK = Array("<span style='color:#ff0000'>일요일</span>", "월요일", "화요일", "수요일", "목요일", "금요일", "<span style='color:#0000ff'>토요일</span>", "<b>TOTAL</b>");
		$trs = sqlArray("SELECT date_format(intime, '%w') as wday, count(intime) as TOT FROM gs_act WHERE 1=1 $actquery GROUP BY date_format(intime, '%w')");
		$TOT = 0;
		if($trs) foreach($trs as $v){
			$WS[$v['wday']] = $v['TOT'];
			$TOT += $v['TOT'];
		}
		$WS[7] = $TOT;

		if (!$TOT) $TOT = 1;
		for ($i=0; $i < count($ARRWEEK); $i++) {
			$MTOT = $WS[$i];
			$WID = intval($MTOT/$TOT*($GRIDWIDTH*20));
			$PCT = round(($MTOT/$TOT)*100, 2);
			if ($i==7) echo("<tr><td colspan=2 height=1 bgcolor='#cccccc'></td></tr>\n");
			echo("<tr class=content height=28>\n");
			echo("<td align=center><span class=gray>$ARRWEEK[$i]</span></td>\n");
			echo("<td class=graph nowrap>");
			printf("<span class='filterwhite%s' style='height:10px;width:%dpx;' title='접속수 : %s회 (%s%%)'><script></script></span>", ($i==7 ? "blue" : "green"), $WID, number_format($MTOT), $PCT);
			echo(" ");
			if ($MTOT > 0) printf("%s <span class=pct>(%s%%)</span>", number_format($MTOT), $PCT);
			echo("</td></tr><tr>\n");
			echo("<td colspan=2 height=1></td></tr>\n");
		}
		unset($trs);
		?>

	<?}?>
	</table>

</td></tr>
</table>
