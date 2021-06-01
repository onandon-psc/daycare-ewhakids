<? $strnum = "40"; ?>
<script language='javascript'>
<!--	
	function tab01(no){
		f = document.hidForm;
		switch (no){
			case "1":
				document.getElementById("display1").style.display="";
				document.getElementById("display2").style.display="none";
				document.getElementById("display4").style.display="none";
				document.getElementById("display3").style.display="none";
				MM_swapImage('tab1','','/images/main/tab01_on.gif',1);
				MM_swapImage('tab2','','/images/main/tab02.gif',1);
				MM_swapImage('tab4','','/images/main/tab04.gif',1);
				MM_swapImage('tab3','','/images/main/tab03.gif',1);
				f.pno.value = "060101";
				break;	
			case "2":
				document.getElementById("display1").style.display="none";
				document.getElementById("display2").style.display="";
				document.getElementById("display4").style.display="none";
				document.getElementById("display3").style.display="none";
				MM_swapImage('tab1','','/images/main/tab01.gif',1);
				MM_swapImage('tab2','','/images/main/tab02_on.gif',1);
				MM_swapImage('tab4','','/images/main/tab04.gif',1);
				MM_swapImage('tab3','','/images/main/tab03.gif',1);
				f.pno.value = "060102";
				break;	
			case "4":
				document.getElementById("display1").style.display="none";
				document.getElementById("display2").style.display="none";
				document.getElementById("display4").style.display="";
				document.getElementById("display3").style.display="none";
				MM_swapImage('tab1','','/images/main/tab01.gif',1);
				MM_swapImage('tab2','','/images/main/tab02.gif',1);
				MM_swapImage('tab4','','/images/main/tab04_on.gif',1);
				MM_swapImage('tab3','','/images/main/tab03.gif',1);
				f.pno.value = "050101";
				break;	
			case "3":
				document.getElementById("display1").style.display="none";
				document.getElementById("display2").style.display="none";
				document.getElementById("display4").style.display="none";
				document.getElementById("display3").style.display="";
				MM_swapImage('tab1','','/images/main/tab01.gif',1);
				MM_swapImage('tab2','','/images/main/tab02.gif',1);
				MM_swapImage('tab4','','/images/main/tab04.gif',1);
				MM_swapImage('tab3','','/images/main/tab03_on.gif',1);
				f.pno.value = "060401";
				break;
		}
	}

	function btnMore(){
		document.hidForm.submit();
	}
//-->
</script>

<form name="hidForm" method="post" action="../../html/sub/index.php">
	<input type="hidden" name="pno" value="060101">
</form>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="padding-top:18px;">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="main_tab_bg">
				<tr>
					<td width="65"><a href="../sub/index.php?pno=060101"><img src="/images/main/tab01_on.gif" alt="공지사항" name="tab1" border="0" align="absmiddle" id="tab1" onMouseOver="tab01('1');"></a></td>
					<td width="65"><a href="../sub/index.php?pno=060102"><img src="/images/main/tab02.gif" alt="보육뉴스" border="0" align="absmiddle" id="tab2" onMouseOver="tab01('2');"></a></td>
					<td width="65"><a href="../sub/index.php?pno=050101"><img src="/images/main/tab04.gif" alt="교육 및 행사" border="0" align="absmiddle" id="tab4" onMouseOver="tab01('4');"></a></td>
					<td><a href="../sub/index.php?pno=060401"><img src="/images/main/tab03.gif" alt="구인구직" border="0" align="absmiddle" id="tab3" onMouseOver="tab01('3');"></a></td>
					<td width="40" class="top"><img src="/images/main/btn_more.gif" alt="자세히보기" border="0" align="absmiddle" onclick="btnMore();" style="cursor:pointer"></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td style="padding:9px 0px 11px 0px;">
			<!-- 공지사항 -->
			<table id='display1' width="100%" border="0" cellpadding="0" cellspacing="0">				
				<?
					$n = 0;
					$query	= "SELECT board_idx, board_subject, board_regdate FROM gs_board_notice WHERE board_notice='Y' ORDER BY board_idx DESC limit 2";
					$result	= mysql_query($query);
					while ( $row = mysql_fetch_array($result) ){

						$today	= mktime();
						$dbday	= $row[board_regdate];
						$totday	= $today - $dbday; 				
					
						if($totday <= 86400){
							$new_img = "&nbsp;<img src='/images/common/icon_new.gif' border='0' align='absmiddle' style='margin:0 0 1 0;'>";
						}else{
							$new_img = "";
						}
				?>
				<tr>
					<td class="listA"><a href="../../html/sub/index.php?pno=060101&mode=view&board_idx=<?=$row[board_idx]?>"><?=trim_text($row[board_subject], $strnum)?></a> <?=$new_img?></td>
					<td width="50" class="text_gray"><?=date("y.m.d", $row[board_regdate]);?></td>
				</tr>
				<? 
					$n++;
					}
				
					$n = 5 - $n;
					$query	= "SELECT board_idx, board_subject, board_regdate FROM gs_board_notice WHERE board_notice='N' ORDER BY board_idx DESC limit $n";
					$result	= mysql_query($query);
					while ( $row = mysql_fetch_array($result) ){

						$today	= mktime();
						$dbday	= $row[board_regdate];
						$totday	= $today - $dbday; 				
					
						if($totday <= 86400){
							$new_img = "&nbsp;<img src='../../images/common/icon_new.gif' border='0' align='absmiddle' style='margin:0 0 1 0;'>";
						}else{
							$new_img = "";
						}
				?>
				<tr>
					<td class="listA"><a href="../../html/sub/index.php?pno=060101&mode=view&board_idx=<?=$row[board_idx]?>"><?=trim_text($row[board_subject], $strnum)?></a> <?=$new_img?></td>
					<td width="50" class="text_gray"><?=date("y.m.d", $row[board_regdate]);?></td>
				</tr>
				<? } ?>	
			</table>
			<!-- 보육뉴스 -->
			<table id='display2' style="display:none" width="100%" border="0" cellpadding="0" cellspacing="0">
				<?
					$n = 0;
					$query	= "SELECT board_idx, board_subject, board_regdate FROM gs_board_news WHERE board_notice='Y' ORDER BY board_idx DESC limit 2";
					$result	= mysql_query($query);
					while ( $row = mysql_fetch_array($result) ){

						$today	= mktime();
						$dbday	= $row[board_regdate];
						$totday	= $today - $dbday; 				
					
						if($totday <= 86400){
							$new_img = "&nbsp;<img src='/images/common/icon_new.gif' border='0' align='absmiddle' style='margin:0 0 1 0;'>";
						}else{
							$new_img = "";
						}
				?>
				<tr>
					<td class="listA"><a href="../../html/sub/index.php?pno=060102&mode=view&board_idx=<?=$row[board_idx]?>"><?=trim_text($row[board_subject], $strnum)?></a> <?=$new_img?></td>
					<td width="50" class="text_gray"><?=date("y.m.d", $row[board_regdate]);?></td>
				</tr>
				<? 
					$n++;
					}
				
					$n = 5 - $n;
					$query	= "SELECT board_idx, board_subject, board_regdate FROM gs_board_news WHERE board_notice='N' ORDER BY board_idx DESC limit $n";
					$result	= mysql_query($query);
					while ( $row = mysql_fetch_array($result) ){

						$today	= mktime();
						$dbday	= $row[board_regdate];
						$totday	= $today - $dbday; 				
					
						if($totday <= 86400){
							$new_img = "&nbsp;<img src='../../images/common/icon_new.gif' border='0' align='absmiddle' style='margin:0 0 1 0;'>";
						}else{
							$new_img = "";
						}
				?>
				<tr>
					<td class="listA"><a href="../../html/sub/index.php?pno=060102&mode=view&board_idx=<?=$row[board_idx]?>"><?=trim_text($row[board_subject], $strnum)?></a> <?=$new_img?></td>
					<td width="50" class="text_gray"><?=date("y.m.d", $row[board_regdate]);?></td>
				</tr>
				<? } ?>	
			</table>
			<!-- 교육 및 행사 -->
			<table id='display4' style="display:none" width="100%" border="0" cellpadding="0" cellspacing="0">
				<?
					$query	= "SELECT * FROM gs_edu_main ORDER BY edu_idx DESC limit 5";
					$result	= mysql_query($query);
					while ( $row = mysql_fetch_array($result) ){

						$today	= mktime();
						$dbday	= $row[board_regdate];
						$totday	= $today - $dbday; 				
					
						if($totday <= 86400){
							$new_img = "&nbsp;<img src='/images/common/icon_new.gif' border='0' align='absmiddle' style='margin:0 0 1 0;'>";
						}else{
							$new_img = "";
						}		
						
						switch(trim($row[edu_kind])){
							case "종사자교육":
							case "부모교육":
								if($row[edu_kind]=="종사자교육"){
									$pno2 = "05020102&mode=view";
								}else{
									$pno2 = "05020202&mode=view";
								}
								break;
							case "폴짝놀이터":
							case "반짝놀이터":
								if($row[edu_kind]=="폴짝놀이터"){
									$pno2 = "05030102";
								}else{
									$pno2 = "05030202";
								}
								break;
							case "월별행사안내":
								$pno2 = "050402&mode=view";
								break;
							case "대관신청":
								$pno2 = "050501&mode=view";
								break;
						}

						$title = "[".$row[edu_kind]."] ".$row[edu_title];
				?>
				<tr>
					<td class="listA"><a href="../../html/sub/index.php?pno=<?=$pno2?>&idx=<?=$row[edu_idx]?>"><?=trim_text($title, $strnum)?></a> <?=$new_img?></td>
				</tr>	
				<? } ?>	
			</table>
			<!-- 구인구직 -->
			<table id='display3' style="display:none" width="100%" border="0" cellpadding="0" cellspacing="0">
				<?
					$query	= "SELECT * FROM gs_board_guin ORDER BY board_idx DESC limit 5";
					$result	= mysql_query($query);
					while ( $row = mysql_fetch_array($result) ){

						$today	= mktime();
						$dbday	= $row[board_regdate];
						$totday	= $today - $dbday; 				
					
						if($totday <= 86400){
							$new_img = "&nbsp;<img src='/images/common/icon_new.gif' border='0' align='absmiddle' style='margin:0 0 1 0;'>";
						}else{
							$new_img = "";
						}				
				?>
				<tr>
					<td class="listA"><a href="../../html/sub/index.php?pno=060401&mode=view&board_idx=<?=$row[board_idx]?>"><?=trim_text($row[board_subject], $strnum)?></a> <?=$new_img?></td>
					<td width="50" class="text_gray"><?=date("y.m.d", $row[board_regdate]);?></td>
				</tr>	
				<? } ?>	
			</table>
		</td>
	</tr>
</table>