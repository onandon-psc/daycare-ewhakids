<? 
	// config.php css 사용(x)
	$cssType = "no";

	include "../include/global/config.php";
?>
<html>
<head>
<style>
	body {
		margin-left : 0px;
		margin-right : 0px;
		margin-top : 0px;
		margin-bottom : 0px;
		background-color : #393939;
		overflow : hidden;
		border : none;
	}
	.tdmenu {
		font-weight:bold;
		font-family:돋움;
		font-size:12px;
		color:#81E4DA;
		background-color:#393939;
		height:30px;
		cursor:pointer;
		vertical-align:middle;
	}
	.trlink {
		font-family:돋움;
		font-size:12px;
		color:#ffffff;
		vertical-align:middle;
		height:15
	}
</style>
<script language="JavaScript">
<!--
	function left_menu(value){
		parent.mainFrame.location.href = value;
	}

	document.oncontextmenu = function() { return false; }
	document.ondragstart   = function() { return false; }

	function comFuncMouseOut(obj)
	{
		var g_color_LIST = '';

		if(obj.tagName == "TD") {
			obj.parentNode.style.backgroundColor = g_color_LIST;
		}
		else {
			obj.style.backgroundColor = g_color_LIST;
			var aNodeList = obj.childNodes;
			for( i=0; i<aNodeList.length; i++ ) {
				if( aNodeList[i].tagName.toUpperCase() == "TD" ) aNodeList[i].style.color = "#737373";
			}
		}
	}

	function comFuncMouseInColor(obj, bgcolor, color)
	{
		if(obj.tagName == "TD"){
			obj.parentNode.style.backgroundColor = bgcolor;
		}
		else{
			obj.style.backgroundColor = bgcolor;
			var aNodeList = obj.childNodes;
			for( i=0; i<aNodeList.length; i++ ) {
				if( aNodeList[i].tagName.toUpperCase() == "TD" ) aNodeList[i].style.color = color;
			}
		}
	}

	function comFuncMouseOutColor(obj, bgcolor, color)
	{
		if(obj.tagName == "TD") {
			obj.parentNode.style.backgroundColor = bgcolor;
		}
		else {
			obj.style.backgroundColor = bgcolor;
			var aNodeList = obj.childNodes;
			for( i=0; i<aNodeList.length; i++ ) {
				if( aNodeList[i].tagName.toUpperCase() == "TD" ) aNodeList[i].style.color = color;
			}
		}
	}

	// For Function
	function funcMouseIn( obj )
	{
		comFuncMouseInColor( obj, '#22787E', 'white');
	}
	function funcMouseOut( obj)
	{
		comFuncMouseOutColor( obj, '#212421', 'white');
	}
	// For Menu
	function menuMouseIn( obj )
	{
		comFuncMouseInColor( obj, '#393939', 'white');
	}
	function menuMouseOut( obj )
	{
		comFuncMouseOutColor( obj,'#393939', '#81E4DA');
	}
	function go( url )
	{
		parent.mainFrame.location.href = url;
	}
//-->
</script>
</head>
<body>
<!--메뉴영역-->
<br>
<table cellspacing=0 cellpadding=0 width='100%' border=0>
  <tr onclick='clickshow(1)' class='tdmenu' onMouseOver="menuMouseIn(this);" onMouseOut ="menuMouseOut(this);" >
    <td style="padding-left:10px">&nbsp;시스템관리</td>
  </tr>
  <tr>
    <td height=1 bgcolor='#000000'></td>
  </tr>
  <tr>
    <td height=1 bgcolor='#636363'></td>
  </tr>
  <tr>
    <td> <span id='block1' style="display: ; margin-left: 1px; cursor: hand">
      <table cellspacing=0 cellpadding=0 border=0 width='100%' bgcolor='#393939'>
        <tr>
          <td style="padding:6 5 5 5;">
            <table width="100%" bgcolor='#212421' cellspacing=0 cellpadding=0 border=0>
              <tr>
                <td height=1 bgcolor='#000000'></td>
              </tr>
              <tr>
                <td style="padding:10 3 10 3">
                  <table width="90%" align=center bgcolor='#212421' cellspacing=0 cellpadding=0 border=0>
                    <tr onMouseOver="funcMouseIn(this);" onMouseOut ="funcMouseOut(this);" class="trlink" onclick="go('boardman/index.php');">
                      <td style="padding-left:5px"> &#149; 메뉴관리</td>
                    </tr>
					<tr onMouseOver="funcMouseIn(this);" onMouseOut ="funcMouseOut(this);" class="trlink" onclick="go('insteadofmysqlconsole.php');">
                      <td style="padding-left:5px"> &#149; DB</td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr>
                <td height=1 bgcolor='#000000'></td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      </span> </td>
  </tr>
  <tr>
    <td height=1 bgcolor='#000000'></td>
  </tr>
  <tr>
    <td height=1 bgcolor='#636363'></td>
  </tr>
</table>
<script language="javascript">
<!--
	function clickshow(num){
		for (i=1;i<=1;i++){
			menu=eval("document.all.block"+i+".style");
			imgch=eval("document.bar"+i);

			if (num==i){
				if (menu.display=="block"){
					menu.display="none";
				} else {
					menu.display="block";
				}
			}else {
				menu.display="none";
			}
		}
 	}
	clickshow(1);
//-->
</script>
