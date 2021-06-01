<?
	$cssType = "no";
	include "../../include/global/config.php";
	$menuName = ($_SESSION['member_sAdmin']=="Z") ? "입학안내" : "회원관리";
?>
<link rel='stylesheet' href='/include/css/admin.css' type='text/css'>
<script src="<?=$INFO[rentUrl]?>/js/common.js" type='text/javascript'></script>
<script type="text/JavaScript">
<!--
	function setMenu( v1, v2, v3, v4 ) {

		var divSubMenuTitle = document.getElementById("divSubMenuTitle");
		var divMenuList = document.getElementById("divMenuList");
		var imgPath = ( 0 > 0 ) ? '<?=$INFO[rentUrl]?>/images/collapsed.gif' : '<?=$INFO[rentUrl]?>/images/expanded.gif' ;
		var menuListHTML = "" ; 
		menuListHTML += "<table width='100%' cellpadiing='0' cellspacing='0' border='0'>" ;
		menuListHTML += "	<tr>" ;  
		menuListHTML += "		<td width='10%'><img src='" + imgPath + "'/>" ;  
		menuListHTML += "		</td>" ;  
		menuListHTML += "		<td width='90%' class='cell01_2l'>" ;
		menuListHTML +="			<span id='"+v1+"' class='"+(v1==1?"menu2":"menu1")+"'>"
		menuListHTML += "				<a href=\"javascript:goMenu('"+ v3 +"', '"+v1+"');\">" + v2 + "</a>";  
		menuListHTML += "			</span>" ; 
		menuListHTML += "		</td>" ;  
		menuListHTML += "	</tr>" ;  
		menuListHTML += "	<tr>" ;
		menuListHTML += "		<td colspan='2' height='1' background='<?=$INFO[rentUrl]?>/images/common/tbl_back_dot.gif'></td>"  
		menuListHTML += "	</tr>" ;  
		menuListHTML += "</table>" ; 
		if ( divMenuList != null ) divMenuList.innerHTML += menuListHTML ;

	}
	
	function goMenu( url, v1 ){
		var tmpObjs = document.getElementById("divMenuList").getElementsByTagName("span");
		for (var i=0;i<tmpObjs.length;i++){
			if(tmpObjs[i].id==v1) tmpObjs[i].className = "menu2"; else tmpObjs[i].className = "menu1";
		}
        parent.mainFrame.location.href = url;
    }
//-->
</script>

<!---좌측메뉴 통--->
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td height="26" background="<?=$INFO[rentUrl]?>/images/common/bg4.gif" style="padding:1px 0px 0px 29px;" >
			<div id='divSubMenuTitle' class="text_white3"></div>
		</td>
	</tr>
	<tr>
		<td valign="top" background="<?=$INFO[rentUrl]?>/images/common/bg5.gif" class="bg1" style="padding:10px 0px 0px 12px;" >
			<table width="134" border="0" cellspacing="0" cellpadding="0" >
				<tr>
					<td valign="top"><div id='divMenuList'></div></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td valign='top'><img src='<?=$INFO[rentUrl]?>/images/common/tbl_menu_bottom.gif' /></td>
	</tr>				
</table>
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td  bgcolor="#5E8BC4"></td>
	</tr>
</table>
<!---좌측메뉴 통 (e)--->
<script type="text/JavaScript">

	function goMenuDepth2(v1){

		var divSubMenuTitle = document.getElementById("divSubMenuTitle");
		var divMenuList = document.getElementById("divMenuList");

		divMenuList.innerHTML = "";
		divSubMenuTitle.innerText = v1; 	

		switch (v1){
			case "회원관리":
				setMenu( "1", "회원관리" , "../member/mb_list.php" ); 
				//setMenu( "2", "회원메일발송" , "../member/mb_list_mail.php" ); 				
				//setMenu( "3", "회원탈퇴내역" , "../member/mb_secession.php" );
				//setMenu( "4", "회원가입통계" , "../member/mb_stat.php" );
				//setMenu( "5", "회원접속통계" , "../member/mb_counter.php" );
				break;
			case "영유아보육프로그램":
				setMenu( "1", "0세-영유아보육환경" , "../../ewhaMaster/sub/index.php?pno=02020103" );
				setMenu( "2", "1세-영유아보육환경" , "../../ewhaMaster/sub/index.php?pno=02020203" );
				setMenu( "3", "2세-영유아보육환경" , "../../ewhaMaster/sub/index.php?pno=02020303" );
				setMenu( "4", "3세-영유아보육환경" , "../../ewhaMaster/sub/index.php?pno=02020403" );
				setMenu( "5", "4세-영유아보육환경" , "../../ewhaMaster/sub/index.php?pno=02020503" );
				setMenu( "7", "5세-영유아보육환경" , "../../ewhaMaster/sub/index.php?pno=02020703" );
				setMenu( "6", "기타" , "../../ewhaMaster/sub/index.php?pno=020206" );
				break;
			case "열린마당":
				setMenu( "1", "공지사항" , "../../ewhaMaster/sub/index.php?pno=030101" ); 
				setMenu( "2", "이유식식단" , "../../ewhaMaster/sub/index.php?pno=030201" ); 
				setMenu( "3", "유아기식단" , "../../ewhaMaster/sub/index.php?pno=030202" ); 
				setMenu( "4", "이달의행사" , "../../ewhaMaster/sub/index.php?pno=030301" ); 
				setMenu( "5", "야간보육신청" , "../030401/list.php" ); 
				break;
			case "유아마당":
				setMenu( "1", "해반" , "../../ewhaMaster/sub/index.php?pno=040104" ); 
				setMenu( "2", "달반" , "../../ewhaMaster/sub/index.php?pno=040204" ); 
				setMenu( "3", "별반" , "../../ewhaMaster/sub/index.php?pno=040304" ); 
				setMenu( "4", "꽃반" , "../../ewhaMaster/sub/index.php?pno=040404" ); 
				setMenu( "5", "나무반" , "../../ewhaMaster/sub/index.php?pno=040504" ); 
				setMenu( "6", "호수반" , "../../ewhaMaster/sub/index.php?pno=040604" ); 
				setMenu( "7", "바다반" , "../../ewhaMaster/sub/index.php?pno=040704" ); 
				setMenu( "8", "산반" , "../../ewhaMaster/sub/index.php?pno=040804" ); 
				setMenu( "9", "강반" , "../../ewhaMaster/sub/index.php?pno=040904" ); 
				setMenu( "10", "하늘반" , "../../ewhaMaster/sub/index.php?pno=041004" ); 
				setMenu( "11", "우주반" , "../../ewhaMaster/sub/index.php?pno=041104" ); 
				//setMenu( "12", "하늘반" , "../../ewhaMaster/sub/index.php?pno=041204" ); 
				break;		
			case "부모마당":
				setMenu( "1", "이야기방" , "../../ewhaMaster/sub/index.php?pno=050103" ); 
				setMenu( "2", "부모교육" , "../../ewhaMaster/sub/index.php?pno=050201" ); 
				setMenu( "3", "육아 및 교육상담" , "../../ewhaMaster/sub/index.php?pno=050301" ); 
				break;
			/*case "입학안내":
				setMenu( "1", "대기자명단" , "../../ewhaMaster/sub/index.php?pno=060301" ); 
				break;*/
			case "기타":
				setMenu( "1", "가정통신문" , "../../ewhaMaster/sub/index.php?pno=060401" ); 
				setMenu( "2", "특별활동" , "../../ewhaMaster/sub/index.php?pno=060501" ); 
				setMenu( "3", "교사교육" , "../../ewhaMaster/sub/index.php?pno=060601" ); 
				break;
			case "기타관리":
				setMenu( "1", "팝업관리" , "../popup/popup_list.php" ); 
				setMenu( "2", "유지보수게시판" , "../../ewhaMaster/onandon/partner_qna.php" ); 
				<? if( $_SESSION['member_sAdmin'] == "M" ){ ?>
				setMenu( "3", "관리자 정보수정" , "../../ewhaMaster/common/admin_modify.php" ); 
				<? } ?>
				break;
		}
	}

	goMenuDepth2('<?=$menuName?>');

</script>
