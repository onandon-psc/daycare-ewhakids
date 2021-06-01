<?
	include_once($_SERVER[DOCUMENT_ROOT]."/include/global/inc_download.php");
	$quickTop = strpos($SCRIPT_FILENAME,"/html/sub/index.php")==true?"326":"405";
	$flashHeight = 252;	
?>
<script language='javascript' src='/include/js/flash.js'></script>
<script language='javascript' src='/include/js/link.js'></script>
<script language='javascript' src='/include/js/func.js'></script>
<script language='javascript' src='/include/js/jquery-3.3.1.min.js'></script>
<script language='javascript' src='/include/js/ui_common.js'></script>
<script type="text/JavaScript">
<!--
	function MM_preloadImages() { //v3.0
		var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
			var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
			if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
	}
	
	function MM_swapImgRestore() { //v3.0
		var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
	}
	
	function MM_findObj(n, d) { //v4.01
		var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
			d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
		if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
		for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
		if(!x && d.getElementById) x=d.getElementById(n); return x;
	}
	
	function MM_swapImage() { //v3.0
		var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
		 if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
	}
	
	function MM_openBrWindow(theURL,winName,features) { //v2.0
		window.open(theURL,winName,features);
	}
	
	<!--이미지에 Onblur 효과(s)-->
	function autoblur() {   
		if(event.srcElement.tagName == "A") document.body.focus();   
	}   
	document.onfocusin = autoblur;
	<!--이미지에 Onblur 효과(e)-->  

	function chkCommonSearchForm(form){
		if(form.commonSearchWord.value=="검색어 입력") form.commonSearchWord.value = "";
		if(!form.commonSearchWord.value){alert("검색어를 입력해 주세요.");form.commonSearchWord.focus();return false;}
		return true;
	}

	function login_check(f){
		if(!f.mbId.value){
			alert("아이디를 입력하십시오!");
			f.mbId.focus();
			return false;
		}
		if(!f.mbPwd.value){
			alert("패스워드를 입력하십시오!");
			f.mbPwd.focus();
			return false;
		}
		return;
	}
//-->
</script>
</head>
<body>
<div style="width:100%;text-align:center">
	<div style="width:900px;margin:0 auto;position:relative;">
		<!-- logo 시작 -->
		<div id='plus' style='top:30px; position:absolute; z-index:302; visibility:none; left:expression((document.body.clientWidth/2)-452);'> <a href="/"><img src="/images/template/logo.gif"></a></div>
		<!-- logo 끝 -->

		<a name="#top"></a>
		<!---- quick link(s) -->
		<script language=javascript>
			function CheckUIElements()
			{
				 var yMenu1From, yMenu1To, yOffset, timeoutNextCheck;
				 var wndWidth = parseInt(document.body.clientWidth);

					  yMenu1From   = parseInt (D1.style.top, 10);
					  yMenu1To     = document.body.scrollTop + <?=$quickTop?>; // 위쪽 위치

				 timeoutNextCheck = 500;

				 if ( yMenu1From != yMenu1To ) {
						yOffset = Math.ceil( Math.abs( yMenu1To - yMenu1From ) / 20 );
					 if ( yMenu1To < yMenu1From )
							 yOffset = -yOffset;
				
			 D1.style.top = parseInt (D1.style.top, 10) + yOffset;

					 timeoutNextCheck = 10;
			 }

			 setTimeout ("CheckUIElements()", timeoutNextCheck);
			}

			function MovePosition(v)
			{
			  var wndWidth = parseInt(document.body.clientWidth);   
			  // 페이지 로딩시 포지션

					  D1.style.top = document.body.scrollTop + <?=$quickTop?>;

					  D1.style.visibility = "visible";

			  // initializing UI update timer
			  CheckUIElements();

			  return true;
			}

			function bannerSc(){
			 document.bannerForm.submit();	 
			}
		</script>

	<!--<div id="D1" style="visible:visible;POSITION:absolute; left:expression( (document.body.clientWidth/2)+422); top:200px; width:13px; height:86px; z-index:1;">-->
			<div id="D1" style="visible:visible;POSITION:absolute; right:-10px; top:200px; width:13px; height:86px; z-index:1;">
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td align="center">&nbsp;</td>
				</tr>
				<tr>
					<td align="center"><img src="../../images/common/quick_text.gif"></td>
				</tr>
				<tr>
					<td align="center"><a href="javascript:menu('3','2','1')"><img src="../../images/common/quick_img1.gif" border="0"></a></td>
				</tr>
				<tr>
					<td align="center"><a href="#top" onFocus="this.blur();"><img src="../../images/common/btn_top.gif" width="68" height="27" border="0"></a></td>
				</tr>
			</table>
			<script language=JavaScript>MovePosition();</script>	
		</div>
		<!---- quick link(e)-->
		<table width="980" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td align="right" style="padding:14px 106px 0px 0px">
					<table border="0" cellpadding="0" cellspacing="0">
					<form name="loginFrm" method="post" action="/html/sub07/070101_proc.php" onSubmit="return login_check(this)" target="iframe">	
						<input type="hidden" name="ret_login" value="Y">
						<input type="hidden" name="ret_host" value="<?=$_SERVER['HTTP_HOST']?>">
						<input type="hidden" name="ret_url" value="<?=$_REQUEST['ret_url']?>">				
						<tr>
							<td width="1"><a href="/"></a></td>
							<?if(!$_SESSION["member_id"]){?>
							<td width="62">
								<table width="194" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td width="96" class="template_idpw" style="padding:0px 0px 0px 13px">
											<input name="mbId" type="text" class="input_type001" id="name2" style="width:74px;" value="아이디" onClick="this.value=''" />
										</td>
										<td width="2"> </td>
										<td width="96" class="template_idpw" style="padding:0px 0px 0px 13px">
											<input name="mbPwd" type="password" class="input_type001" id="name" style="width:74px;" value="비밀번호" onClick="this.value=''"/>
										</td>
									</tr>
								</table>
							</td>					
							<td style="padding:0px 0px 0px 2px"><input type="image" src="../../images/template/btn_top_login.gif" alt="로그인" border="0"></td>
							<td style="padding:0px 0px 0px 20px"><a href="javascript:menu('7','2','1')"><img src="../../images/template/btn_join.gif" alt="회원가입" border="0" align="absmiddle"></a><a href="javascript:menu('7','3','1')"><img src="../../images/template/btn_idpw.gif" alt="아이지/비밀번호찾기" border="0" align="absmiddle"></a></td>
							<?}else{?>
							<td><a href="/html/sub07/member_logout.php"><img src="../../images/template/btn_logout.gif" alt="로그아웃" border="0" align="absmiddle"></a><a href="javascript:menu('8','1','1')"><img src="../../images/template/btn_member_mody.gif" alt="정보수정" border="0" align="absmiddle"></a></td>
							<?}?>
							<td><a href="http://member.ewhakids.or.kr/nakid/" target="_blank"><img src="../../images/template/btn_home.gif" alt="메인화면" align="absmiddle"></a><a href="javascript:menu('9','1','1')"><img src="../../images/template/btn_sitemap.gif" alt="사이트맵" border="0" align="absmiddle"></a></td>
						</tr>
					</form>
					</table>		
				</td>
			</tr>
		</table>

		<? if($_SERVER[PHP_SELF] != "/html/main/index.php"){ ?>
		<table width="902" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td>
					<div class="new-sub-visual type1"><!-- 각 type 1~6, 기타 type7 클래스 지정해주세요.  -->
						<? include "../../include/html/gnb.html"; ?>
					</div>
					<!--<script language="javascript">flash('980','<?=$flashHeight?>',"../../flash/visual_sub<?=substr(basename($pno),0,2)?>.swf?mNum=<?=intval(substr(basename($pno),0,2))?>&sNum=<?=intval(substr(basename($pno),2,2))?>")</script>-->
				</td>
			</tr>
		</table>
		<!--- include Top(E) --->
		<!--- Content(S) --->
		<table width="900" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width="226" valign="top">
					<? include "../../include/html/left".substr($pno,1,1).".html"; ?>
					<!--<script language="javascript">flash('195','500',"/flash/left_menu<?=$pno_1?>.swf?sNum=<?=$pno_2?>&cNum=<?=$pno_1?>")</script>-->
				</td>
				<td width="674" valign="top">
					<table border="0" cellspacing="0" cellpadding="0" class="contents">
						<tr>
							<td>
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td align="right">
											<!---현재위치--->
											<table border="0" cellpadding="0" cellspacing="0">
												<tr>
													<td class="history text11_gray3">
													<?
														if($row_page[KIND]==9)
														{
															echo ${"navi_".$pno};
														}else{
															echo "홈 &gt; ".$row_page[CATE1];
															if($row_page[CATE2]){ 
																echo " &gt; "; 
																if(!$row_page[CATE3] && !$row_page[CATE4] ){ echo"<span class='bold'>"; }
																echo $row_page[CATE2]; 
																if(!$row_page[CATE3] && !$row_page[CATE4] ){ echo"</span>"; }
															}
															if($row_page[CATE3]){ 
																echo " &gt; "; 
																if(!$row_page[CATE4] ){ echo"<span class='bold'>"; }
																echo $row_page[CATE3]; 
																if(!$row_page[CATE4] ){ echo"</span>"; }
															}
															if($row_page[CATE4]){ 
																echo " &gt; "; 
																echo "<span class='bold'>".$row_page[CATE4]."</span>";
															}
														}
														?>		
													</td>
												</tr>
											</table>
											<!---현재위치(e)--->
										</td>
									</tr>
								</table>
								<!---title--->
								<?
								if( substr($pno,0,4)=="0501" ){
									$titlePno = substr($pno,0,4)."01";
								}else{
									if( substr($pno,0,6)=="020201" || substr($pno,0,6)=="020202" || substr($pno,0,6)=="020203" || substr($pno,0,6)=="020204" || substr($pno,0,6)=="020205" )
										$titlePno = substr($pno,0,6);
									else
										$titlePno = $pno;
								}
								?>
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td><img src="../../images/title/title_<?=$titlePno?>.gif"></td>
									</tr>
								</table>
								<!---title(e)--->
								<? } ?>