<?
	$cssType = "no";
	include "../../include/global/config.php";
	$menuName = ($_SESSION['member_sAdmin']=="Z") ? "���оȳ�" : "ȸ������";
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

<!---�����޴� ��--->
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
<!---�����޴� �� (e)--->
<script type="text/JavaScript">

	function goMenuDepth2(v1){

		var divSubMenuTitle = document.getElementById("divSubMenuTitle");
		var divMenuList = document.getElementById("divMenuList");

		divMenuList.innerHTML = "";
		divSubMenuTitle.innerText = v1; 	

		switch (v1){
			case "ȸ������":
				setMenu( "1", "ȸ������" , "../member/mb_list.php" ); 
				//setMenu( "2", "ȸ�����Ϲ߼�" , "../member/mb_list_mail.php" ); 				
				//setMenu( "3", "ȸ��Ż�𳻿�" , "../member/mb_secession.php" );
				//setMenu( "4", "ȸ���������" , "../member/mb_stat.php" );
				//setMenu( "5", "ȸ���������" , "../member/mb_counter.php" );
				break;
			case "�����ƺ������α׷�":
				setMenu( "1", "0��-�����ƺ���ȯ��" , "../../ewhaMaster/sub/index.php?pno=02020103" );
				setMenu( "2", "1��-�����ƺ���ȯ��" , "../../ewhaMaster/sub/index.php?pno=02020203" );
				setMenu( "3", "2��-�����ƺ���ȯ��" , "../../ewhaMaster/sub/index.php?pno=02020303" );
				setMenu( "4", "3��-�����ƺ���ȯ��" , "../../ewhaMaster/sub/index.php?pno=02020403" );
				setMenu( "5", "4��-�����ƺ���ȯ��" , "../../ewhaMaster/sub/index.php?pno=02020503" );
				setMenu( "7", "5��-�����ƺ���ȯ��" , "../../ewhaMaster/sub/index.php?pno=02020703" );
				setMenu( "6", "��Ÿ" , "../../ewhaMaster/sub/index.php?pno=020206" );
				break;
			case "��������":
				setMenu( "1", "��������" , "../../ewhaMaster/sub/index.php?pno=030101" ); 
				setMenu( "2", "�����ĽĴ�" , "../../ewhaMaster/sub/index.php?pno=030201" ); 
				setMenu( "3", "���Ʊ�Ĵ�" , "../../ewhaMaster/sub/index.php?pno=030202" ); 
				setMenu( "4", "�̴������" , "../../ewhaMaster/sub/index.php?pno=030301" ); 
				setMenu( "5", "�߰�������û" , "../030401/list.php" ); 
				break;
			case "���Ƹ���":
				setMenu( "1", "�ع�" , "../../ewhaMaster/sub/index.php?pno=040104" ); 
				setMenu( "2", "�޹�" , "../../ewhaMaster/sub/index.php?pno=040204" ); 
				setMenu( "3", "����" , "../../ewhaMaster/sub/index.php?pno=040304" ); 
				setMenu( "4", "�ɹ�" , "../../ewhaMaster/sub/index.php?pno=040404" ); 
				setMenu( "5", "������" , "../../ewhaMaster/sub/index.php?pno=040504" ); 
				setMenu( "6", "ȣ����" , "../../ewhaMaster/sub/index.php?pno=040604" ); 
				setMenu( "7", "�ٴٹ�" , "../../ewhaMaster/sub/index.php?pno=040704" ); 
				setMenu( "8", "���" , "../../ewhaMaster/sub/index.php?pno=040804" ); 
				setMenu( "9", "����" , "../../ewhaMaster/sub/index.php?pno=040904" ); 
				setMenu( "10", "�ϴù�" , "../../ewhaMaster/sub/index.php?pno=041004" ); 
				setMenu( "11", "���ֹ�" , "../../ewhaMaster/sub/index.php?pno=041104" ); 
				//setMenu( "12", "�ϴù�" , "../../ewhaMaster/sub/index.php?pno=041204" ); 
				break;		
			case "�θ𸶴�":
				setMenu( "1", "�̾߱��" , "../../ewhaMaster/sub/index.php?pno=050103" ); 
				setMenu( "2", "�θ���" , "../../ewhaMaster/sub/index.php?pno=050201" ); 
				setMenu( "3", "���� �� �������" , "../../ewhaMaster/sub/index.php?pno=050301" ); 
				break;
			/*case "���оȳ�":
				setMenu( "1", "����ڸ��" , "../../ewhaMaster/sub/index.php?pno=060301" ); 
				break;*/
			case "��Ÿ":
				setMenu( "1", "������Ź�" , "../../ewhaMaster/sub/index.php?pno=060401" ); 
				setMenu( "2", "Ư��Ȱ��" , "../../ewhaMaster/sub/index.php?pno=060501" ); 
				setMenu( "3", "���米��" , "../../ewhaMaster/sub/index.php?pno=060601" ); 
				break;
			case "��Ÿ����":
				setMenu( "1", "�˾�����" , "../popup/popup_list.php" ); 
				setMenu( "2", "���������Խ���" , "../../ewhaMaster/onandon/partner_qna.php" ); 
				<? if( $_SESSION['member_sAdmin'] == "M" ){ ?>
				setMenu( "3", "������ ��������" , "../../ewhaMaster/common/admin_modify.php" ); 
				<? } ?>
				break;
		}
	}

	goMenuDepth2('<?=$menuName?>');

</script>
