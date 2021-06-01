<table border="0" cellspacing="0" cellpadding="0" class="board_top">
	<tr>
		<td align="left">
			<table border="0" align="left" cellpadding="0" cellspacing="0">
				<tr>
				<?
					$no = $nums - $set_page;
					$cnt = 1;
					if ($nums){
						for ($i = $set_page; $i < $last; $i++){
						@mysql_data_seek($result,$i);
						$row= mysql_fetch_array($result);

						$strnum = "20";

						$viewImg = "";
						for ( $n = 1 ; $n <= $boardFileNum; $n++ ) {
							if($row[board_file.$n] && empty($viewImg) ){
								$viewImg = $row[board_file.$n];
							}
						}	
						
						
						$temp = explode(".",$viewImg);
						$viewImg = $temp[0].".".strtoupper($temp[1]);	
						if(!file_exists($file_url.$viewImg) == true)
						{
							$temp = explode(".",$viewImg);
							$viewImg = $temp[0].".".strtolower($temp[1]);
						}
					?>
					<td height="20">
						<table border="0" align="center" cellpadding="0" cellspacing="0">
							<tr>
								<td width="180" valign="top">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="126" height="109" align="center"><img src="<?=$file_url.urlencode($viewImg)?>"  height="100" onclick="_viewLink('<?=$row[board_idx]?>','O');" style="cursor:pointer"></td>
										</tr>
										<tr>
											<td height="8"></td>
										</tr>
										<tr>
											<td>
												<table width="137" border="0" align="center" cellpadding="0" cellspacing="0">
													<tr>
														<td width="7" valign="top" style="padding:3 0 0 0;" ><img src="../../images/common/dot_01.gif"></td>
														<td width="130" valign="top"><span onClick="_viewLink('<?=$row[board_idx]?>','O');" style="cursor:pointer"><?=trim_text($row[board_subject], $strnum)?></span></td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
					<?
							$tr = ($i+1)%4;
							if($tr == 0){
								echo "</tr>";
								if($cnt != $boardListNum){
									echo "<tr>
												 <td height='20'></td>
											  </tr>";
								}
								echo "<tr>";
							}
						$cnt++;
						}
					}
				?>
				</tr>
			</table>			
		</td>
	</tr>
</table>
