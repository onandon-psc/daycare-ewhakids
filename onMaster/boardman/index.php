<?
	include "../../include/global/config.php";
	include "../board_session.php"; 
	
	if( !isset($pcode) ) $pcode = "01";

	$query	= "SELECT * FROM BOARD_MANAGER WHERE last_yn ='Y' && substring(PNO,1,2) ='$pcode' ORDER BY PNO";
	$result	= mysql_query($query);

?>
<script language="javascript">
<!--
	function locationMenu(){
		url = "menuList.php";
		retVal = window.showModalDialog(url, window, "dialogWidth:520px; dialogHeight:520px;scroll:yes;status:no;help:no");
		if(retVal) location.href('index.php');
	}

	function locationReg(v){
		url = "sysReg.php?pno_1="+v;
		retVal = window.showModalDialog(url, window, "dialogWidth:690px; dialogHeight:600px;scroll:yes;status:no;help:no");
		if(retVal) location.href('index.php?pcode=<?=$pcode?>');
	}

	function locationMod(value, pno){		
		url = "sysReg.php?pno="+pno+"&seq="+value;
		retVal = window.showModalDialog(url, window, "dialogWidth:690px; dialogHeight:600px;scroll:yes;status:no;help:no");
		if(retVal) location.href('index.php?pcode=<?=$pcode?>');
	}

	function change_large()
	{
		var pcode = document.all.pcode.value;
		var url      = "<?=$PHP_SELF?>?pcode=" + pcode;
		location.href = url;
	}
//-->
</script>

<form name="locationForm" method="post" action="reg.php">
  <input type="hidden" name="seq">
  <input type="hidden" name="menuCode">
</form>
<? $colnum = 11; ?>
<table width='100%' border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" bgcolor="#EFEFEF" style="padding:5px">◈ <b>메뉴관리</b></td>
  </tr>
  <tr>
    <td height="5"></td>
  </tr>
  <tr>
    <td> Depth1
      <select name=pcode onchange="javascript:change_large();">
        <?
			$cateQuery	= "SELECT * FROM BOARD_MANAGER_CATE WHERE viewType='Y' ORDER BY menuCode";
			$cateResult	= mysql_query($cateQuery);
			while( $cateRow = mysql_fetch_array($cateResult) ) {
				$sel = "";
				if( $cateRow[MENUCODE] == $pcode ) $sel = " selected ";
				echo ("
				<option value='$cateRow[MENUCODE]' $sel>[ $cateRow[MENUCODE] ] $cateRow[MENUNAME]</option>");
			}			
        ?>
      </select>
    </td>
  </tr>
  <tr>
    <td align='center'>
      <table width='100%' cellpadding='0' cellspacing='0' border='0'>
        <tr>
          <td height='1' colspan='<?=$colnum?>' bgcolor='#D3A66D'></td>
        </tr>
        <tr>
          <td height='5' colspan='<?=$colnum?>' bgcolor="#FBF9F5"></td>
        </tr>
        <tr align='center' bgcolor="#FBF9F5">
          <td width="8%"><b>코드</b></td>
          <td width="12%"><b>Depth1</b></td>
          <td width="12%"><b>Depth2</b></td>
          <td width="10%"><b>Depth3</b></td>	
          <td width="8%"><b>Depth4</b></td>	
          <td width="8%"><b>Depth5</b></td>	
          <td width="12%"><b>테이블명</b></td>
          <td width="24%"><b>링크파일</b></td>
          <td width="3%"><b>구분</b></td>
          <td width="3%"><b>사용 </b></td>
        </tr>
        <tr>
          <td height='5' colspan='<?=$colnum?>' bgcolor="#FBF9F5"></td>
        </tr>
        <tr>
          <td height='1' colspan='<?=$colnum?>' bgcolor='#D3A66D'></td>
        </tr>
        <?	
			while ($row= @mysql_fetch_array($result) ){
		?>
        <tr align='center' bgcolor="#FFFFFF" onMouseOver=this.style.backgroundColor='#F5F5EA' onMouseOut=this.style.backgroundColor='#FFFFFF'>
          <td height="26" align="left" style="padding-left:3px">
            <a href="sysDel.php?pno=<?=$row[PNO]?>&returnParam=<?=$_SERVER['QUERY_STRING']?>" onclick="return confirm('정말 삭제하시겠습니까?');">[<b>X</b>]</a><?=$row[PNO]?>
          </td>
          <td onclick="locationMod('<?=$row[SEQ]?>','<?=$row[PNO]?>');" style="cursor:pointer">
            <?=$row[CATE1]?>
          </td>
          <td onclick="locationMod('<?=$row[SEQ]?>','<?=$row[PNO]?>');" style="cursor:pointer">
            <?=$row[CATE2]?>
          </td>
          <td onclick="locationMod('<?=$row[SEQ]?>','<?=$row[PNO]?>');" style="cursor:pointer">
            <?=$row[CATE3]?>
          </td>
          <td onclick="locationMod('<?=$row[SEQ]?>','<?=$row[PNO]?>');" style="cursor:pointer">
            <?=$row[CATE4]?>
          </td>
          <td onclick="locationMod('<?=$row[SEQ]?>','<?=$row[PNO]?>');" style="cursor:pointer">
            <?=$row[CATE5]?>
          </td>
          <td onclick="locationMod('<?=$row[SEQ]?>','<?=$row[PNO]?>');" style="cursor:pointer">
            <?=$row[TBLNAME]?>
          </td>
          <td align="left" onclick="locationMod('<?=$row[SEQ]?>','<?=$row[PNO]?>');" style="cursor:pointer">
            <?=$row[LINK_FILE]?>
          </td>       
          <td onclick="locationMod('<?=$row[SEQ]?>','<?=$row[PNO]?>');" style="cursor:pointer">
            <?=textKindChange($row[KIND])?>
          </td>
          <td onclick="locationMod('<?=$row[SEQ]?>','<?=$row[PNO]?>');" style="cursor:pointer">
            <?=$row[USE_YN]?>
          </td>
        </tr>
        <tr>
          <td height='1' colspan='<?=$colnum?>' bgcolor='#EFEFEF'></td>
        </tr>
        <?		
			$no = $no-1; 
			} // for
		?>
        <tr>
          <td height='1' colspan='<?=$colnum?>' bgcolor='#D3A66D'></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td align="right" style="padding:5 0 0 0">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="50%" align="left">
            <input type="button" value="대분류관리" onclick="locationMenu();" style="padding:3px;cursor:pointer">
          </td>
          <td align="right">
            <input type="button" value="등록" onclick="locationReg('<?=$pcode?>');" style="padding:3px;cursor:pointer">
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>