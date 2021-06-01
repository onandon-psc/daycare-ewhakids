<?
	if($send == "write"){	
		$query	= "INSERT INTO ona_menulist (
							code, mdate, 
							m011, m012, m013, 
							m021, m022, m023, m024, m025,  
							m031, m032, m033,
							m041, m042, m043, m044, m045
						) VALUES ( 
							'$code', '$mdate', 
							'$m011', '$m012', '$m013',
							'$m021', '$m022', '$m023', '$m024', '$m025',  
							'$m031', '$m032', '$m033',
							'$m041', '$m042', '$m043', '$m044', '$m045'
						)";		
		mysql_query($query);	
		echo "<script>alert('등록 되었습니다.')</script>";
		echo("<script>location.href = '$PHP_SELF?pno=$pno&type=$type&yy=$yy&mm=$mm&code=$code';</script>");
	}

	if($send == "modify"){	
		$query	= "UPDATE ona_menulist SET 
							m011='$m011', m012='$m012', m013='$m013', 
							m021='$m021', m022='$m022', m023='$m023', m024='$m024', m025='$m025',
							m031='$m031', m032='$m032', m033='$m033',		
							m041='$m041', m042='$m042', m043='$m043', m044='$m044', m045='$m045'
						WHERE idx='$idx'";
		echo "<script>alert('수정 되었습니다.')</script>";
		mysql_query($query);
		echo("<script>location.href = '$PHP_SELF?pno=$pno&type=$type&yy=$yy&mm=$mm&code=$code';</script>");
	}

	$query	= "SELECT * FROM ona_menulist WHERE mdate='$mdate' and code='$code'";
	$result	= mysql_query($query);
	$row		= @mysql_fetch_array($result);

	$ex_mdate = explode("-",$mdate);
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0"> 
  <tr>
	<td style="padding:0 0 30 0">

		<table border='0' cellpadding='0' cellspacing='0' width='780'>
			<tr>
				<td width='1' height='1' bgcolor='white'></td>
				<td width='678' bgcolor='#9DB0A1'></td>
				<td width='1' height='1' bgcolor='white'></td>
			</tr>

			<form name="writeForm" method="post" enctype="multipart/form-data" action="<?=$PHP_SELF?>">
				
				<input type="hidden" name="pno" value="<?=$pno?>">
				<input type="hidden" name="type" value="<?=$type?>">
				<input type="hidden" name="mode" value="write">
				
				<input type="hidden" name="pageFile" value="reg">
				<input type="hidden" name="check_board" value="board_write">
				<input type="hidden" name="yy" value="<?=$ex_mdate[0]?>">
				<input type="hidden" name="mm" value="<?=$ex_mdate[1]?>">		
					
				<input TYPE="hidden" NAME="code" value="<?=$code?>">
				<? if(!$row[idx]){ ?>
					<input type="hidden" name="send" value="write">
					<input type="hidden" name="mdate" value="<?=$mdate?>">
				<? }else{ ?>
					<input type="hidden" name="send" value="modify">
					<input type="hidden" name="idx" value="<?=$row[idx]?>">
				<? } ?>									

			<tr bgcolor='#9DB0A1'>
				<td colspan='3' align='center' style='padding:1 0 1 0'>
					<table border='0' cellpadding='0' cellspacing='0' width='776'>
						<tr height='30'>
							<td width='80' align='center'style='color:;' bgcolor='#F2F3E8'><B>날짜</B></td>
							<td width='550' style='padding:0 0 0 8' bgcolor='white'><?=$mdate?></td>
						</tr>
						
						<!-- 이유식 -->
						<? if( $pno == "030201" ){ ?>
						<tr>
							<td colspan='2' height='1' bgcolor='#9DB0A1'></td>
						</tr>	
						<tr height='30'>
							<td width='80' align='center'style='color:;' bgcolor='#F2F3E8'><B>이유식</B></td>
							<td width='550' style='padding:0 0 0 8' bgcolor='white'>
								<? 
								echo "<table>
											<tr>";
									for($i=1; $i <= 2; $i++){ 												
										echo"<td>
													<input type=text class='input' name='m01$i' style='width:70;' value='".$row[m01.$i]."' >
												 </td>";
									}
								echo "	</tr>
										  </table>";
								?>
							</td>
						</tr>
						<tr>
							<td colspan='2' height='1' bgcolor='#9DB0A1'></td>
						</tr>
						<? }else{ ?>
						<tr>
							<td colspan='2' height='1' bgcolor='#9DB0A1'></td>
						</tr>	
						<tr height='30'>
							<td width='80' align='center'style='color:;' bgcolor='#F2F3E8'><B>오전간식</B></td>
							<td width='550' style='padding:0 0 0 8' bgcolor='white'>
								<? 
								echo "<table>
											<tr>";
									for($i=1; $i <= 3; $i++){ 												
										echo"<td>
													<input type=text class='input' name='m01$i' style='width:70;' value='".$row[m01.$i]."' >
												 </td>";
									}
								echo "	</tr>
										  </table>";
								?>
							</td>
						</tr>
						<tr>
							<td colspan='2' height='1' bgcolor='#9DB0A1'></td>
						</tr>
						<tr height='30'>
							<td width='80' align='center'style='color:;' bgcolor='#F2F3E8'><B>점심</B></td>
							<td width='550' style='padding:0 0 0 8' bgcolor='white'>
								<? 
								echo "<table>
											<tr>";
									for($i=1; $i <= 5; $i++){ 												
										echo"<td>
													<input type=text class='input' name='m02$i' style='width:70;' value='".$row[m02.$i]."' >
												 </td>";
									}
								echo "	</tr>
										  </table>";
								?>
							</td>
						</tr>					
						<tr>
							<td colspan='2' height='1' bgcolor='#9DB0A1'></td>
						</tr>
						<tr height='30'>
							<td width='80' align='center'style='color:;' bgcolor='#F2F3E8'><B>오후간식</B></td>
							<td width='550' style='padding:0 0 0 8' bgcolor='white'>
								<? 
								echo "<table>
											<tr>";
									for($i=1; $i <= 3; $i++){ 												
										echo"<td>
													<input type=text class='input' name='m03$i' style='width:70;' value='".$row[m03.$i]."' >
												 </td>";
									}
								echo "	</tr>
										  </table>";
								?>
							</td>
						</tr>		
						<tr>
							<td colspan='2' height='1' bgcolor='#9DB0A1'></td>
						</tr>
						<tr height='30'>
							<td width='80' align='center'style='color:;' bgcolor='#F2F3E8'><B>저녁</B></td>
							<td width='550' style='padding:0 0 0 8' bgcolor='white'>
								<? 
								echo "<table>
											<tr>";
									for($i=1; $i <= 5; $i++){ 												
										echo"<td>
													<input type=text class='input' name='m04$i' style='width:70;' value='".$row[m04.$i]."' >
												 </td>";
									}
								echo "	</tr>
										  </table>";
								?>
							</td>
						</tr>		
						<? } ?>
					</table>
				</td>
			</tr>
			<tr>
				<td width='1' height='1' bgcolor='white'></td>
				<td width='643' bgcolor='#9DB0A1'></td>
				<td width='1' height='1' bgcolor='white'></td>
			</tr>
			<tr>
				<td colspan='3' height='5'></td>
			</tr>
			<tr>
				<td colspan='3'  align='right' style='padding:10 0 0 0'><input type="image" src="/images/btn/btn_write.gif" align="absmiddle">&nbsp;<img src="/images/btn/btn_list.gif" onclick="location='/html/sub/index.php?pno=<?=$pno?>&yy=<?=$ex_mdate[0]?>&mm=<?=$ex_mdate[1]?>';" align="absmiddle" style="cursor:pointer"></td>
			</tr>
			<tr>
				<td colspan='3' height='10'></td>
			</tr>
			</form>
		</table>	
	</td>
  </tr>
	</td>
  </tr>
</table>
