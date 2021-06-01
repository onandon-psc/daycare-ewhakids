<style type="text/css">
	.gray  { color:gray; }
	td.graph { background-image:url('/images/admin/counter_log_bg.gif'); color:gray; }
	span.pct { font-family:arial; font-size:7pt; color:#999999; }

	.filterbluea		{filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=0, StartColorStr=#D1E3EF, EndColorStr=#FFFFFF);}
	.filterblueb		{filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=0, StartColorStr=#99ccff, EndColorStr=#FFFFFF);}
	.filterbluec		{filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=0, StartColorStr=#F4E1E7, EndColorStr=#FFFFFF);}
	.filterwhitered	 	{filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=1, StartColorStr=#FFFFFF, EndColorStr=#FF0000);}
	.filterwhitegreen	{filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=1, StartColorStr=#FFFFFF, EndColorStr=#00FF00);}
	.filterwhiteblue	{filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=1, StartColorStr=#FFFFFF, EndColorStr=#0000FF);}
</style>

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
		$trs = sqlRow("SELECT SUM(DAY_TOTAL) as TOT FROM gs_counter WHERE COUNT_DATE LIKE '$cyear%'");
		$TOT = $trs[TOT];
		if (!$TOT) $TOT = 1;
		unset($trs);

		for ($i = 1; $i <= 13; $i++) {
			$ii = ($i < 10 ? "0$i" : $i);
			if ($i > 12) {
				$MTOT = $TOT;
			} else {
				$trs = sqlRow("SELECT SUM(DAY_TOTAL) as TOT FROM gs_counter WHERE COUNT_DATE LIKE '$cyear$ii%'");
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
				echo("<td class=graph><a href='$PHP_SELF?mode=day&cyear=$cyear&cmonth=$i'>");
			}
			printf("<span class='filterwhite%s' style='height:10px;width:%dpx;' title='접속수 : %s회 (%s%%)'><script></script></span>", ($i > 12 ? "blue" : "green"), $WID, number_format($MTOT), $PCT);
			echo("</a> ");
			if ($MTOT > 0) printf("%s <span class=pct>(%s%%)</span>", number_format($MTOT), $PCT);
			echo("</td></tr><tr>\n");
			echo("<td colspan=2 height=1></td></tr>\n");
		}
	?>

	<?} elseif ($mode=="day") { //========================== 일별 통계 =============================?>

		<?
		$DAY_MAX = HDate("t", mktime(0, 0, 0, $cmonth, 1, $cyear)); //===== 달의 마지막 날
		$trs = sqlRow("SELECT SUM(DAY_TOTAL) as TOT FROM gs_counter WHERE COUNT_DATE LIKE '$cyear$cmonth%'");
		$TOT = $trs[TOT];
		if (!$TOT) $TOT = 1;
		unset($trs);

		for ($i = 1; $i <= $DAY_MAX+1; $i++) {
			$ii = ($i < 10 ? "0$i" : $i);
			if ($i > $DAY_MAX) {
				$MTOT = $TOT;
			} else {
				$trs = sqlRow("SELECT DAY_TOTAL as TOT FROM gs_counter WHERE COUNT_DATE='$cyear$cmonth$ii' LIMIT 1");
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
				echo("<td class=graph><a href='$PHP_SELF?mode=hour&cyear=$cyear&cmonth=$cmonth&cday=$i'>");
			}
			printf("<span class='filterwhite%s' style='height:10px;width:%dpx;' title='접속수 : %s회 (%s%%)'><script></script></span>", ($i > $DAY_MAX ? "blue" : "green"), $WID, number_format($MTOT), $PCT);
			echo("</a> ");
			if ($MTOT > 0) printf("%s <span class=pct>(%s%%)</span>", number_format($MTOT), $PCT);
			echo("</td></tr><tr>\n");
			echo("<td colspan=2 height=1></td></tr>\n");
		}
		?>

	<?} elseif ($mode=="hour") { //========================== 시간별 통계 =============================?>

		<?
		$trs = sqlRow("SELECT * FROM gs_counter WHERE COUNT_DATE='$cyear$cmonth$cday' LIMIT 1");
		$TOT = $trs[DAY_TOTAL];
		if (!$TOT) $TOT = 1;
		for($i = 0; $i < 24+1; $i++) {
			$ii = ($i < 10 ? "0$i" : $i);
			if ($i > 23) {
				$MTOT = $trs[DAY_TOTAL];
				echo("<tr><td colspan=2 height=1 bgcolor='#cccccc'></td></tr>\n");
			} else {
				$MTOT = $trs["H_$ii"];
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
		$sql = "";
		for ($i=0; $i<24; $i++) {
			$sql .= sprintf("SUM(H_%02d) as H%d, ", $i, $i);
		}
		$sql = "SELECT $sql SUM(DAY_TOTAL) as H24 FROM gs_counter";
		//DebugStr($sql);
		$trs = sqlRow($sql);
		$TOT = $trs[H24];
		if (!$TOT) $TOT = 1;
		for ($i=0; $i <= 24; $i++) {
			$ii = ($i < 10 ? "0$i" : $i);
			$MTOT = $trs["H" . $i];
			$WID = intval($MTOT/$TOT*($GRIDWIDTH*20));
			$PCT = round(($MTOT/$TOT)*100, 2);
			if ($i > 23) echo("<tr><td colspan=2 height=1 bgcolor='#cccccc'></td></tr>\n");
			echo("<tr class=content height=16>\n");
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
		$trs = sqlArray("SELECT date_format(COUNT_DATE, '%w') as wday, SUM(DAY_TOTAL) as TOT FROM gs_counter GROUP BY date_format(COUNT_DATE, '%w')");
		$TOT = 0;
		foreach($trs as $v){
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

	<?} elseif ($mode=="os") { //========================== 운영체제별 통계 =============================?>

		<?
		$ARROS = Array("윈XP", "윈VISTA", "윈7", "윈2K", "윈ME", "윈NT", "윈98", "윈95", "LINUX", "SUN", "MAC", "ETC", "<b>TOTAL</b>");
		$trs = sqlRow("SELECT SUM(WINXP) as OS1, SUM(WINVISTA) as OS2, SUM(WIN7) as OS3, SUM(WIN2000) as OS4, SUM(WINME) as OS5, SUM(WINNT) as OS6, SUM(WIN98) as OS7, SUM(WIN95) as OS8, SUM(LINUX) as OS9, SUM(SUN) as OS10, SUM(MAC) as OS11, SUM(OSETC) as OS12, SUM(DAY_TOTAL) as OS13 FROM gs_counter");
		$TOT = $trs[OS13];
		if (!$TOT) $TOT = 1;
		for ($i=0; $i < count($ARROS); $i++) {
			$MTOT = $trs["OS" . ($i+1)];
			$WID = intval($MTOT/$TOT*($GRIDWIDTH*20));
			$PCT = round(($MTOT/$TOT)*100, 2);
			if ($i==10) echo("<tr><td colspan=2 height=1 bgcolor='#cccccc'></td></tr>\n");
			echo("<tr class=content height=28>\n");
			echo("<td align=center><span class=gray>$ARROS[$i]</span></td>\n");
			echo("<td class=graph nowrap>");
			printf("<span class='filterwhite%s' style='height:10px;width:%dpx;' title='접속수 : %s회 (%s%%)'><script></script></span>", ($i==10 ? "blue" : "green"), $WID, number_format($MTOT), $PCT);
			echo(" ");
			if ($MTOT > 0) printf("%s <span class=pct>(%s%%)</span>", number_format($MTOT), $PCT);
			echo("</td></tr><tr>\n");
			echo("<td colspan=2 height=1></td></tr>\n");
		}
		unset($trs);
		?>

	<?} elseif ($mode=="agent") { //========================== 브라우저별 통계 =============================?>

		<?
		$ARRBR = Array("IE 4.0", "IE 5.0", "IE 5.5", "IE 6.0", "IE 7.0", "IE 8.0", "OPERA", "NETSCAPE", "FIREFOX", "ETC", "<b>TOTAL</b>");
		$trs = sqlRow("SELECT SUM(IE40) as BR1, SUM(IE50) as BR2, SUM(IE55) as BR3, SUM(IE60) as BR4, SUM(IE70) as BR5, SUM(IE80) as BR6, SUM(OPERA) as BR7, SUM(NETSCAPE) as BR8, SUM(FIREFOX) as BR9, SUM(BRETC) as BR10, SUM(DAY_TOTAL) as BR11 FROM gs_counter");
		$TOT = $trs[BR11];
		if (!$TOT) $TOT = 1;
		for ($i=0; $i < count($ARRBR); $i++) {
			$MTOT = $trs["BR" . ($i+1)];
			$WID = intval($MTOT/$TOT*($GRIDWIDTH*20));
			$PCT = round(($MTOT/$TOT)*100, 2);
			if ($i==7) echo("<tr><td colspan=2 height=1 bgcolor='#cccccc'></td></tr>\n");
			echo("<tr class=content height=28>\n");
			echo("<td align=center><span class=gray>$ARRBR[$i]</span></td>\n");
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
