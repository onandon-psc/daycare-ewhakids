<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td align="left">
		<?  	
			$iframeType = "no";
			$blurType = "no";

			@include "../../include/global/config.php";
			@include "../../include/global/makesql.class.php";

			$mYear = ($toYear) ? $toYear : date("Y");
			$mMonth = ($toMonth) ? $toMonth : date("m");	
			$mToDay = ($toDay) ? $toDay : date("d");
			$today = strtotime($mYear."-".$mMonth."-".$mToDay);

			$whereAnd .= " && (from_unixtime(edu_sdate,'%Y')='$mYear' || from_unixtime(edu_rsdate,'%Y')='$mYear') && ( from_unixtime(edu_sdate,'%m')='$mMonth' || from_unixtime(edu_redate,'%m')='$mMonth' )";

			$sql = "SELECT * FROM gs_edu_main 
					   WHERE edu_kind in ('�����ڱ���','�θ���','��¦������','�������ȳ�') && ( edu_sdate<='$today' || ( edu_sdate>=$today && edu_sdate<=($today+86400-1) ) ) && edu_edate>='$today' $whereAnd 
					   ORDER BY edu_sdate asc limit 9";

			//echo $sql;
			$result = @mysql_query($sql);
			$mNum = @mysql_num_rows($result);

			//���������� ���� ���̺� height�� ���������� �����ϱ�����
			$TdHeight = 20 * $mNum;
			$eduCount = 0;

			if($mNum > 2){
				echo "<marquee id='scroller' direction=up scrollAmount=1 width=100% height='30' onMouseOver='this.stop()' onMouseOut='this.start()'>";
			}
			while($rs=@mysql_fetch_array($result)){

				$chk = "Y";
				if($rs[edu_week] && intval($rs[edu_week]) != intval(date("w",$today))) $chk = "N";

				if($chk == "Y"){
					switch(trim($rs[edu_kind])){
						case "�����ڱ���":
						case "�θ���":
							$kindValue = "����";		
							$cssValue = "text11_blue bold";
							if($rs[edu_kind]=="�����ڱ���"){
								$pno2 = "05020102&mode=view";
							}else{
								$pno2 = "05020202&mode=view";
							}
							break;
						case "��¦������":
						case "��¦������":
							$kindValue = "����";	
							$cssValue = "text11_orenge bold";
							if($rs[edu_kind]=="��¦������"){
								$pno2 = "05030102";
							}else{
								$pno2 = "05030202";
							}
							break;
						case "�������ȳ�":
							$kindValue = "���";
							$cssValue = "text11_pink bold";
							$pno2 = "050402&mode=view";
							break;
						case "�����û":
							$kindValue = "���";
							$cssValue = "text11_green bold";
							$pno2 = "050501&mode=view";
							break;
					}

					$mLink = "/html/sub/?pno=".$pno2."&idx=".$rs['edu_idx'];      
					$mTitle = StringCut($rs['edu_title'],22);
					echo "<span class='".$cssValue."'>[".$kindValue."]</span> <A href='$mLink' target='siteMain'>$mTitle</A><br>";   
					$eduCount += 1;
				}
			}

			//if($eduCount == 0) echo "<center class='font_gray1'>�������� ��簡 �����ϴ�.</center>";
		?>
		</td>
	</tr>
</table>