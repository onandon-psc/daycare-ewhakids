<?
	$cssType = "no";
	include "../../include/global/config.php";
?>
<link rel='stylesheet' href='/include/css/admin.css' type='text/css'>
<script language="javascript">
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

	function _logout(){
		parent.location.href='logout.php';
	}

	function mainLocation(url){
		parent.location.href=url;
	}

	function goMenuDepth1(v1,v2){
		var tmpObjs = document.getElementById("topMenuTable").getElementsByTagName("span");
		for (var i=0;i<tmpObjs.length;i++){
			if(tmpObjs[i].innerHTML.indexOf(v1)>-1) tmpObjs[i].className = "text_yellow"; else tmpObjs[i].className = "text_white";
		}
		parent.leftFrame.goMenuDepth2(v1);
		parent.mainFrame.location.href = v2;
	}
//-->	
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td background="<?=$INFO[rentUrl]?>/images/common/bg2.gif" style="padding:0 0 0 0;">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="158" align="center"><font color="#FFFFFF"><b><?=$INFO[company]?></b></font></td>
					<td width="40">&nbsp;</td>
					<td>
						<table border="0" cellspacing="0" cellpadding="0" id="topMenuTable">
							<tr>
								<? if($_SESSION['member_sAdmin']!='Z'){ ?>
								<td><span class='text_yellow'><a href="javascript:goMenuDepth1('회원관리','../member/mb_list.php');" style='cursor:pointer'>회원관리</a></span></td>
								<td style="padding:0 20 0 20;"><img src='<?=$INFO[rentUrl]?>/images/common/line_thin.gif'></td>
								<td><span class='text_white'><a href="javascript:goMenuDepth1('영유아보육프로그램','../../ewhaMaster/sub/index.php?msChk=master&pno=02020103');" style='cursor:pointer'>영유아보육프로그램</a></span></td>
								<td style="padding:0 20 0 20;"><img src='<?=$INFO[rentUrl]?>/images/common/line_thin.gif'/></td>
								<td><span class='text_white'><a href="javascript:goMenuDepth1('열린마당','../../ewhaMaster/sub/index.php?msChk=master&pno=030101');" style='cursor:pointer'>열린마당</a></span></td>
								<td style="padding:0 20 0 20;"><img src='<?=$INFO[rentUrl]?>/images/common/line_thin.gif'/></td>
								<td><span class='text_white'><a href="javascript:goMenuDepth1('유아마당','../../ewhaMaster/sub/index.php?msChk=master&pno=040104');" style='cursor:pointer'>유아마당</a></span></td>
								<td style="padding:0 20 0 20;"><img src='<?=$INFO[rentUrl]?>/images/common/line_thin.gif'/></td>
								<td><span class='text_white'><a href="javascript:goMenuDepth1('부모마당','../../ewhaMaster/sub/index.php?msChk=master&pno=050103');" style='cursor:pointer'>부모마당</a></span></td>
								<? } ?>
								<td style="padding:0 20 0 20;"><img src='<?=$INFO[rentUrl]?>/images/common/line_thin.gif'/></td>
								<td><span class='text_white'><a href="javascript:goMenuDepth1('기타','../../ewhaMaster/sub/index.php?msChk=master&pno=060401');" style='cursor:pointer'>기타</a></span></td>								
								<td style="padding:0 20 0 20;"><img src='<?=$INFO[rentUrl]?>/images/common/line_thin.gif'/></td>
								<? if($_SESSION['member_sAdmin']!='Z'){ ?>
								<td><span class='text_white'><a href="javascript:goMenuDepth1('기타관리','../popup/popup_list.php');" style='cursor:pointer'>기타관리</a></span></td>
								<? } ?>
							</tr>
						</table>
					<td>					
					<!---로고, 메인메뉴(e)--->
					<td width="60" align="right" style="padding:0 20 0 0">
						<table border="0" cellspacing="0" cellpadding="3">
							<tr>								
								<td><a href="javascript:;" onclick="_logout();"><img src="<?=$INFO[rentUrl]?>/images/common/btn_logout.gif" alt="로그아웃" align="absmiddle" id="Image4" onMouseOver="MM_swapImage('Image4','','<?=$INFO[rentUrl]?>/images/common/btn_logout_on.gif',1)" onMouseOut="MM_swapImgRestore()" style='padding-right:10px'></a></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan='13' height='1' bgColor='#FFFFFF'></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td height="24" bgcolor="5e8bc4">&nbsp;</td>
	</tr>
</table>