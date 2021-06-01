<?
	include "../../include/global/config.php"; 
	include "../common/admin_login_check.php";				// 로그인 체크

	// 웹데이터
	require_once $_SERVER["DOCUMENT_ROOT"]."/include/cheditor/cheditor.php";
	$CHEDITOR1 = new cheditorCLASS("content","100%","300","popupFrm");	

	$idx = trim($_REQUEST['idx']);

	if($idx)
	{
		$send = "modify";
		$query = "SELECT * FROM ona_popup WHERE idx='$idx'";
		$result	= mysql_query($query);
		$row		= mysql_fetch_array($result);
		$info			= explode("|",$row[sizeInfo]);
		$content	= trim($row[content]);

		// 이미지링크
		$sQuery	= "SELECT iLinkArea, iLinkTarget, iLinkUrl FROM ona_popup_info WHERE pidx='$idx' ORDER BY idx";
		$sResult	= mysql_query($sQuery);
		$iLinkCount = mysql_num_rows($sResult);
		while( $sRow = mysql_fetch_array($sResult))
		{
			$n = $n + 1;
			$iLinkArea[$n]		= $sRow[iLinkArea]?$sRow[iLinkArea]:"";
			$iLinkTarget[$n]	= $sRow[iLinkTarget]?$sRow[iLinkTarget]:"";
			$iLinkUrl[$n]		= $sRow[iLinkUrl]?$sRow[iLinkUrl]:"";
		}	

	}else{
		$send = "write";
		if(!$row[contentType]) $row[contentType] = 1;
	}

	$iLinkCount = $iLinkCount?$iLinkCount:"1";
?>
<script language="javascript" src="/include/js/popup.js"></script>
<script language="javascript" src="/include/js/calendar.js"></script>
<script language='javascript'>
<!--
	function preViewer(thisObj, preViewer)
	{
		 if(!/(\.gif|\.jpg|\.jpeg|\.png)$/i.test(thisObj.value)) {
			alert("이미지 형식의 파일을 선택하십시오");
			return;
		}

		preViewer = (typeof(preViewer) == "object") ? preViewer : document.getElementById('previewPhoto');
		var ua = window.navigator.userAgent;

		if (ua.indexOf("MSIE") > -1) 
		{

			var img_path = "";
			if (thisObj.value.indexOf("\\fakepath\\") < 0) 
			{
				img_path = thisObj.value;
			} else {
				thisObj.select();
				var selectionRange = document.selection.createRange();
				img_path = selectionRange.text.toString();
				thisObj.blur();
			}

			document.getElementById('previewPhoto').style.display	= "block";
			document.getElementById('coordinate').style.display		= "block";
			preViewer.style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='fi" + "le://" + img_path + "', sizingMethod='image')";
			document.getElementById('previewPhoto').style.width = preViewer.offsetWidth;
			document.getElementById('previewPhoto').style.width = preViewer.offsetHeight;

		} else {

			preViewer.innerHTML = "";
			var W = preViewer.offsetWidth;
			var H = preViewer.offsetHeight;
			var tmpImage = document.createElement("img");
			preViewer.appendChild(tmpImage);

			tmpImage.onerror = function () 
			{
				return preViewer.innerHTML = "";
			}

			tmpImage.onload = function () 
			{
				if (this.width > W) 
				{
					this.height = this.height / (this.width / W);
					this.width = W;
				}
				if (this.height > H) 
				{
					this.width = this.width / (this.height / H);
					this.height = H;
				}
			}
			if (ua.indexOf("Firefox/3") > -1) 
			{
				var picData = thisObj.files.item(0).getAsDataURL();
				tmpImage.src = picData;
			} else {
				tmpImage.src = "file://" + thisObj.value;
			}
		}
	}
	
	function mpfunc(){
		document.getElementById('mpspan').innerText='x:'+event.offsetX+', y:'+event.offsetY;
	}

	function contype(obj)
	{
		for(var i=1; i<=4; i++)
		{
			if(i==obj) result = "block";
			else result = "none";
			document.getElementById("disType"+i).style.display = result;
		}		

		if( obj == 4 )
		{
			<?if(!$idx){?>skinChoice(1);<?}?>
			document.getElementById("disType3").style.display = "block";
		}

		if( obj == 1 || obj == 2) result = "block";
		else result = "none";
		document.getElementById("disTypeFile").style.display = result;
	}

	function stack(obj)
	{
		frm = document.popupFrm;
		var cols = frm.iLinkCount.value;
		if( obj == "P")
		{	
			if( cols == 5 ) 
			{
				alert("이미지링크는 최대 5개 까지만 가능합니다.");
				return ;
			}
			cols++;
			document.getElementById("iLink"+cols).style.display="";
		}else{
			if( cols == 1) 
			{
				alert("이미지링크는 최소 1개 이상 있어야 합니다.");
				return ;
			}
			document.getElementById("iLink"+cols).style.display="none";
			cols--;				
		}
		frm.iLinkCount.value = cols;
	}

	function onlyNumber(obj)
	{
		if(obj.value.match(/[^0-9]/))
		{ 
			alert('숫자만 넣어주세요'); 
			obj.value = ""; 
			obj.focus();
			return false;
		}
	}

	function valueChk(obj, msg)
	{
		if(!obj.value)
		{
			alert(msg+" 입력해 주십시오");
			obj.focus();
			return false;
		}
		return true;
	}
	
	function input_check(frm)
	{
		try{
			if(!valueChk(frm.subject,'제목을')) return;
			
			if(frm.visionType.checked == true && (!frm.sdate.value && !frm.edate.value))
			{
				alert('게시일을 등록하십시오');
				return;
			}
			
			if(!valueChk(frm.pWidth,'팝업크기 WIDTH를')) return;
			if(!valueChk(frm.pHeight,'팝업크기 HEIGHT를')) return;
			if(!valueChk(frm.pTop,'팝업크기 TOP을')) return;
			if(!valueChk(frm.pLeft,'팝업크기 LEFT를')) return;

			if(frm.pWidth.value < 250)
			{
				alert('팝업이미지 가로 사이즈가 250 이상이여야 합니다.');
				return false;
			}

			if( !frm.file.value && !frm.idx.value  && ( frm.contentType[0].checked==true || frm.contentType[1].checked==true ))
			{
				alert('파일을 등록하십시오');
				return false;
			}

			if( (frm.sdate.value || frm.edate.value) && frm.visionType.checked==false )
			{
				if(confirm('게시일을 적용하시겠습니까?')) frm.visionType.checked = true;
			}

			if( frm.openType[1].checked==true && frm.pScroll.value == "no")
			{
				alert('브라우져 내 팝업시 스크롤바를 사용이여야 합니다.');
				frm.pScroll.focus();
				return false;
			}
			
			frm.send.value = "<?=$send?>";

			content = cheditor_content.outputBodyHTML();
			if(confirm('등록하시겠습니까?')) frm.submit();
		}catch(e){
			alert(e.message);
		}
	}

	function preViewerAct(frm)
	{
		if(frm.pWidth.value < 250)
		{
			alert('파업이미지 가로 사이즈가 250 이상이여야 합니다.');
			return false;
		}
		content = cheditor_content.outputBodyHTML();
		frm.send.value = "preView";
		frm.submit();		
	}

	function preViewerPopup(val)
	{
		frm =  document.popupFrm;
		url = "/html/popup/popup_preView.html";
		visionDay = frm.visionDay.value;
		wname = "";
		// left
		x	= frm.pLeft.value;
		// top
		y	= frm.pTop.value;
		// width
		if(frm.pScroll.value=="no") w = frm.pWidth.value;
		else w = eval(frm.pWidth.value) + eval(17);
		// height	
		h  = eval(frm.pHeight.value) + eval(24);
		// scroll
		s  = frm.pScroll.value;

		content = cheditor_content.outputBodyHTML();

		if(frm.openType[0].checked == true) 
		{
			open_popup(url,visionDay,wname,w,h,y,x,s,'preView','preView');
		}else{
			wname = "wnd_"+val;
			open_popup_div(url,visionDay,wname,w,h,y,x,s,'preView','preView');
		}
	}

	function delAct()
	{
		if(confirm('삭제하시겠습니까?'))
		{
			frm =  document.popupFrm;
			frm.send.value = "delete";
			frm.submit();
		}
	}

	function skinChoice(obj)
	{
		frm = document.popupFrm;
		if(obj < 4 || obj == 7 || obj == 8)
		{
			frm.pWidth.value  = 360; 
			frm.pHeight.value = 420;
		}
		else
		{
			frm.pWidth.value  = 400; 
			frm.pHeight.value = 360;
		}
	}
//-->
</script>
<body <?if($row[contentType]) echo"onLoad='contype(".$row[contentType].")'";?>>
<table width="100%" align="left" cellspacing="0" cellpadding="0" border="0">
	<tr>
		<td height="30" bgColor="#EFEFEF" style="padding:0 0 0 10"><b>▣ 팝업관리</b></td>
	</tr>
	<tr>
		<td style="padding:10 5 5 5">
			<table width="700" align="left" cellspacing="1" cellpadding="0" border="0" bgcolor="#E7E7E7">
			<form name="popupFrm" method="post" enctype="multipart/form-data" action="popup_proc.php" target="iframe">
				<input type="hidden" name="send">
				<input type="hidden" name="idx" value="<?=$idx?>">
				<input type="hidden" name="iLinkCount" value="<?=$iLinkCount?>">
				<tr>
					<td width="100" align="center" bgcolor="#EFEFEF"><b>팝업사용</b></td>
					<td width="600" style="padding:3px" bgcolor="#FFFFFF">
						<input type="radio" name="status" value="Y" <?if(!$row[status] || $row[status]=="Y") echo "checked";?>> 사용
						<input type="radio" name="status" value="N" <?if($row[status]=="N") echo "checked";?>> 사용안함
					</td>
				</tr>
				<tr>
					<td align="center" bgcolor="#EFEFEF"><b>팝업형태</b></td>
					<td style="padding:3px" bgcolor="#FFFFFF">
						<input type="radio" name="openType" value="P" <?if(!$row[openType] || $row[openType]=="P") echo "checked";?>> 새창으로 (팝업창)
						<input type="radio" name="openType" value="D" <?if($row[openType]=="D") echo "checked";?>> 브라우져 내 (DIV팝업)
					</td>
				</tr>
				<tr>
					<td align="center" bgcolor="#EFEFEF"><b>제&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;목</b></td>
					<td style="padding:3px" bgcolor="#FFFFFF">
						<input type="text" name="subject" value="<?=$row[subject]?>" style="width:100%;ime-mode:active">
					</td>
				</tr>
				<tr>
					<td align="center" bgcolor="#EFEFEF"><b>게&nbsp;시&nbsp;일</b></td>
					<td style="padding:3px" bgcolor="#FFFFFF">						
						<input name="sdate" value="<?=$row["sdate"]?date("Y-m-d",$row["sdate"]):""?>" style="width:80;text-align:center;" onfocus='calendar(event,this)' onChange="autoDate();" readonly>
						<img src="/images/common/icon_calendar.gif" align="absmiddle" style="cursor:pointer;" onclick='calendar(event,document.popupFrm.sdate)'>
						~
						<input name="edate" value="<?=$row["edate"]?date("Y-m-d",$row["edate"]):""?>" style="width:80;text-align:center;" onfocus='calendar(event,this)' onChange="autoDate();" readonly>
						<img src="/images/common/icon_calendar.gif" align="absmiddle" style="cursor:pointer;" onclick='calendar(event,document.popupFrm.edate)'>
						&nbsp;&nbsp;<input type="checkbox" name="visionType" value="Y" <?if($row["sdate"]||$row["edate"]){ echo "checked"; }?>> <font color="#FF0000">☜ 적용시 체크하십시오</font>
					</td>
				</tr>
				<tr>
					<td align="center" bgcolor="#EFEFEF"><b>팝업크기</b></td>
					<td style="padding:3px" bgcolor="#FFFFFF">						
						<table align="left" cellspacing="0"	cellpadding="0" border="0">
							<tr>
								<td style="padding:0 3 0 3">
									WIDTH : <input type="text" name="pWidth" size="4" maxlength="4" value="<?=$info[0]?>" onKeyUp='onlyNumber(this)' style="text-align:center">
								</td>
								<td style="padding:0 3 0 3">
									HEIGHT : <input type="text" name="pHeight" size="4" maxlength="4" value="<?=$info[1]?>" onKeyUp='onlyNumber(this)' style="text-align:center">
								</td>
								<td style="padding:0 3 0 3">
									TOP : <input type="text" name="pTop" size="4" maxlength="4" value="<?=$info[2]?>" onKeyUp='onlyNumber(this)' style="text-align:center">
								</td>
								<td style="padding:0 3 0 3">
									LEFT : <input type="text" name="pLeft" size="4" maxlength="4" value="<?=$info[3]?>" onKeyUp='onlyNumber(this)' style="text-align:center">
								</td>
								<td style="padding:0 3 0 3">스크롤바 : 
									<select name="pScroll">
										<option value="no">사용안함</option>
										<option value="yes" <?=$info[4]=="yes"?"selected":""?>>사용</option>
									</select>
								</td>
							</tr>
						</table>
					</td>	
				</tr>
				<tr>
					<td align="center" bgcolor="#EFEFEF"><b>그만보기</b></td>
					<td style="padding:3px" bgcolor="#FFFFFF">
						<input type="text" name="visionDay" value="<?=$row[visionDay]?$row[visionDay]:1?>" size="2" onKeyUp='onlyNumber(this)' style="text-align:center"> 일
					</td>
				</tr>
				<tr>
					<td align="center" bgcolor="#EFEFEF"><b>내용구분</b></td>
					<td style="padding:3px" bgcolor="#FFFFFF">
						<input type="radio" name="contentType" value="1" onclick="contype(this.value)" <?=$row[contentType]=="1"?"checked":""?>>부분적 이미지 링크
						<input type="radio" name="contentType" value="2" onclick="contype(this.value)" <?=$row[contentType]=="2"?"checked":""?>>전체 이미지 링크
						<input type="radio" name="contentType" value="3" onclick="contype(this.value)" <?=$row[contentType]=="3"?"checked":""?>>에디터
						<input type="radio" name="contentType" value="4" onclick="contype(this.value)" <?=$row[contentType]=="4"?"checked":""?>>스킨
					</td>
				</tr>
				<!-- 팝업이미지 -->
				<tr id="disTypeFile">
					<td align="center" bgcolor="#EFEFEF"><b>팝업이미지</b></td>
					<td style="padding:3px" bgcolor="#FFFFFF">
						<input type="file" name="file" onChange="preViewer(this,'previewPhoto')" style="width:100%">
						<div id='previewPhoto' style="display:none;" onmousemove="mpfunc()"></div>
						<div id="coordinate" style="display:none;"><font color="#FF0000">※ <b>마우스 좌표</b>&nbsp;(&nbsp;<span id="mpspan"></span>&nbsp;)</font></div>
					</td>
				</tr>
				<!-- 부분적 이미지 링크 -->
				<tr id="disType1" style="display:block">
					<td align="center" bgcolor="#EFEFEF"><b>이미지링크</b></td>
					<td style="padding:3px" bgcolor="#FFFFFF">						
						<table width='100%' border='0' cellpadding='0' cellspacing='0'>
							<tr>
								<td colspan="5">
									<table width="100%" cellspacing='0' cellpadding='0' border='0'>
										<tr>
											<td width="85%" align="left">※ 아래 이미지를 참조하여 링크영역에 <font color="#FF0000">A,B,C,D</font> 값 입력하십시오</td>
											<td width="15%" align="right">
												<input type="button" value="추가" onClick="stack('P')" style="cursor:pointer">
												<input type="button" value="삭제" onClick="stack('M')" style="cursor:pointer">
											</td>
										</tr>
									</table>
								</td>								
							</tr>
							<tr>
								<td>
									<? 
										for($n=1; $n<=5; $n++){
											$iLinkDisp = $iLinkCount >= $n?"block":"none";		
									?>
									<table id='iLink<?=$n?>' width='100%' border='0' cellpadding='0' cellspacing='0' style="display:<?=$iLinkDisp?>">
										<tr>
											<td width="1%" align="right"><b><?=$n?></b>.&nbsp;</td>
											<td width="11%" align="center">링크영역</td>
											<td width="18%"><input type="text" name="iLinkArea<?=$n?>" id="iLinkArea<?=$n?>" style="width:105" value='<?=$iLinkArea[$n]?>'></td>
											<td width="12%" align="right" style="padding:0 5 0 0">링크URL</td>	
											<td width="10%" align="right" style="padding:0 5 0 0">
												<select name="iLinkTarget<?=$n?>">
													<option value="P">부모창에</option>
													<option value="N" <?=$iLinkTarget[$n]=="N"?"selected":""?>>새창으로</option>
												</select>
											</td>	
											<td width="48%"><input type="text" name="iLinkUrl<?=$n?>" id="iLinkUrl<?=$n?>"  style="width:280" value='<?=$iLinkUrl[$n]?>'></td>
										</tr>
									</table>
									<? } ?>
								</td>
							</tr>
						</table>						
					</td>
				</tr>
				<!-- 전체 이미지 링크 -->
				<tr id="disType2" style="display:none">
					<td align="center" bgcolor="#EFEFEF"><b>링크URL</b></td>
					<td style="padding:3px" bgcolor="#FFFFFF">						
						<table width='100%' border='0' cellpadding='0' cellspacing='0'>
							<tr>
								<td width="13	 %">
									<select name="iLinkTarget">
										<option value="P">부모창에</option>
										<option value="N" <?=$iLinkTarget[1]=="N"?"selected":""?>>새창으로</option>
									</select>
								</td>
								<td width="87%"><input type="text" name="iLinkUrl" id="iLinkUrl1" style="width:100%" value="<?=$iLinkUrl[1]?>"></td>
							</tr>
						</table>						
					</td>
				</tr>
				<!-- 에디터 -->
				<tr id="disType3" style="display:none">
					<td align="center" bgcolor="#EFEFEF"><b>내용</b></td>
					<td style="padding:3px" bgcolor="#FFFFFF">						
						<table width='100%' border='0' cellpadding='0' cellspacing='0'>
							<tr>
								<td><?$CHEDITOR1->SHOW($content)?></td>
							</tr>
						</table>						
					</td>
				</tr>
				<!-- 스킨 -->
				<tr id="disType4" style="display:none">
					<td align="center" bgcolor="#EFEFEF"><b>스킨</b></td>
					<td style="padding:3px" bgcolor="#FFFFFF">						
						<table border='0' cellpadding='0' cellspacing='0'>
							<tr>
								<?
									$row[skin] = $row[skin] ? $row[skin] : "1";
									for($i=1; $i<=6; $i++){
								?>
								<td style="padding:5px" valign="top">
									<table align="center" border='0' cellpadding='0' cellspacing='0'>
										<tr>
											<td valign="top"><img src="/images/popup/sample_skin<?=$i?>.gif" align="absmiddle" width="90" height="85"></td>
										</tr>
										<tr>
											<td align="center"><input type="radio" name="skin" value="<?=$i?>" onClick="skinChoice(this.value);" <?=$row[skin]==$i?"checked":""?>>스킨<?=$i?></td>
										</tr>
									</table>
								</td>
								<? 
									//if($i==3) echo "</tr><tr>";
									} 
								?>
							</tr>
							<tr>
								<?
									$row[skin] = $row[skin] ? $row[skin] : "1";
									for($i=7; $i<=9; $i++){
								?>
								<td style="padding:5px" valign="top">
									<table align="center" border='0' cellpadding='0' cellspacing='0'>
										<tr>
											<td valign="top"><img src="/images/popup/sample_skin<?=$i?>.gif" align="absmiddle" width="90" height="85"></td>
										</tr>
										<tr>
											<td align="center"><input type="radio" name="skin" value="<?=$i?>" onClick="skinChoice(this.value);" <?=$row[skin]==$i?"checked":""?>>스킨<?=$i?></td>
										</tr>
									</table>
								</td>
								<? 
									//if($i==3) echo "</tr><tr>";
									} 
								?>
							</tr>
						</table>
					</td>
				</tr>		
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table width="700" cellspacing=0 cellpadding=0 border=0>
				<tr>
					<td width="50%" align="left" style="padding:0 0 0 5"><input type="button" value="미리보기" onClick="preViewerAct(this.form)" style="cursor:pointer;padding:5px"></td>
					<td width="50%" align="right">
						<input type="button" value="<?=!$idx?'등록':'수정'?>" onClick="input_check(this.form);" style="cursor:pointer;padding:5px">
						<?if($idx){?><input type="button" value="삭제" onClick="delAct()"; style="cursor:pointer;padding:5px"><?}?>
						<input type="button" value="취소" onClick="location.href('popup_list.php')"; style="cursor:pointer;padding:5px">
					</td>
				</tr>				
			</table>
		</td>
	</tr>
	<tr>
		<td style="padding:50 0 50 7"><img src="/images/admin/popup_sample.gif"></td>
	</tr>
	</form>
</table>
<? 
	// 수정시 이미지 로드
	if($idx){
?>
<script language="javascript">
<!--
	document.getElementById('previewPhoto').style.display	= "block";
	document.getElementById('coordinate').style.display		= "block";
	document.getElementById('previewPhoto').style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='http://<?=$_SERVER[HTTP_HOST]?>/upload/popup/<?=urlencode($row[file])?>', sizingMethod='image')";
	document.getElementById('previewPhoto').style.width = document.getElementById('previewPhoto').offsetWidth;
	document.getElementById('previewPhoto').style.width = document.getElementById('previewPhoto').offsetHeight;
//-->
</script>
<? } ?>