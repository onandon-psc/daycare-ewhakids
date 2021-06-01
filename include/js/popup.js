/************************* 공통 *************************/

function setCookiePop(name, value, expiredays)
{
	var c_date = new Date();
	c_date.setDate( c_date.getDate() + expiredays );
	document.cookie = name+"=" + escape(value) + "; path=/; expires=" + c_date.toGMTString() + ";";
}


function getCookiePop( name )
{
	var nameOfCookie = name + "=";
	var x = 0;
	while ( x <= document.cookie.length )
	{
		var y = (x+nameOfCookie.length);
		if ( document.cookie.substring( x, y ) == nameOfCookie ) {
			if ( (endOfCookie=document.cookie.indexOf( ";", y )) == -1 )
			endOfCookie = document.cookie.length;
			return unescape( document.cookie.substring( y, endOfCookie ) );
		}
		x = document.cookie.indexOf( " ", x ) + 1;
		if ( x == 0 ) break;
	}
	return "";
}



/************************* 팝업창 *************************/

function close_popup(cooknm, cookval, cookday )
{
	setCookiePop(cooknm, cookval, cookday );
	window.close();
}


function open_popup(url,cooknm,wname, w,h,y,x,s,sdate,edate)
{
	if( getCookiePop( cooknm ) == "" ) 
	{
		var chk = "Y";
		if(sdate != "preView")
		{				
			time = document.timeFrm.time.value;		
			if ( sdate > 0 && sdate > time ) chk = "N";
			if ( edate > 0 && edate < time ) chk = "N";
		}
		if (chk=="Y") window.open(url, wname,"left="+x+", top="+y+", width="+w+", height="+h+", toolbar=no, menubar=no, statusbar=no, scrollbars="+s+", resizable=yes");
	}
}

pagetype = ""; // 현재창이 프레임일경우 pagetype을 frame으로 변경

function file_open_popup(url,cooknm,wname,w,h,y,x)
{
	window.open(url, wname,"left="+x+", top="+y+", width="+w+", height="+h+", toolbar=no, menubar=no, statusbar=no, scrollbars=no, resizable=yes");	
}

/************************* DIV 팝업 *************************/

if (parent.document=="[object]")
{		
	pagetype="frame";
} 


function close_popup_div(cooknm, cookval, cookday)
{
	wname=(arguments[3]?arguments[3]:"");
	setCookiePop(cooknm, cookval, cookday );
	if (pagetype=="frame" && opener==undefined)
	{
		parent.document.getElementById(wname).style.display='none';
	} else {
		window.close();
	}
}


function open_popup_div(url,cooknm,wname,w,h,y,x,s,sdate,edate)
{
	if( getCookiePop( cooknm ) == "" ) 
	{
		var chk = "Y";
		if(sdate != "preView")
		{			
			time = document.timeFrm.time.value;		
			if ( sdate > 0 && sdate > time ) chk = "N";
			if ( edate > 0 && edate < time ) chk = "N";
		}
		if (chk=="Y") ShowFramePopup(url,w,h,x,y,wname);
	}
}


function ShowFramePopup()
{
	url			= arguments[0]?arguments[0]:"";
	fpwidth		= parseInt(arguments[1]?arguments[1]:"800");
	fpheight	= parseInt(arguments[2]?arguments[2]:"600");
	fpleft			= parseInt(arguments[3]?arguments[3]:"100");
	fptop			= parseInt(arguments[4]?arguments[4]:"100");
	layerid		= (arguments[5]?arguments[5]:"popup");
	if(url){
		frame_popup_DIV = window.document.createElement("DIV");
		frame_popup_DIV.id = layerid;
		frame_popup_DIV.style.width = fpwidth;
		frame_popup_DIV.style.height = fpheight;
		frame_popup_DIV.style.left = fpleft;
		frame_popup_DIV.style.top = fptop;
		frame_popup_DIV.style.border = "1px solid black";
		frame_popup_DIV.style.position= "absolute";
		frame_popup_DIV.style.display= "";
		frame_popup_DIV.style.cursor="pointer";	
		frame_popup_DIV.style.zindex =100;
		frame_popup_DIV.filter="revealTrans(transition=9,duration=2) blendTrans(transition=4,duration=0.5)";

		frame_popup_DIV.onmouseover= function() {dragObj=frame_popup_DIV;drag=1;move=0;}
		frame_popup_DIV.onmouseout= function() {dragObj=frame_popup_DIV;drag=0;move=0;};

		window.document.body.appendChild(frame_popup_DIV);

		frame_popup = window.document.createElement("IFRAME");
		frame_popup.id = layerid;
		frame_popup.src = url+"?wname="+layerid;
		frame_popup.style.padding="0 0 0 0";
		frame_popup.style.width = fpwidth;
		frame_popup.style.height = fpheight;
		frame_popup.frameBorder = "0";
		frame_popup.style.display= "";
		frame_popup.style.cursor='hands';
		frame_popup_DIV.style.zindex =100;
		frame_popup_DIV.filter="revealTrans(transition=9,duration=2) blendTrans(transition=4,duration=0.5)";
		frame_popup_DIV.appendChild(frame_popup);

		window.document.body.onmousewheel = "return false;";
	}
}


function Hide(divid) 
{ 
	if (document.getElementById(divid)=="[object]")
	{
		if (document.getElementById(divid).filters.blendTrans!=undefined)
		{
			divid.filters.blendTrans.apply(); 
			divid.style.visibility = "hidden"; 
			divid.filters.blendTrans.play(); 
		} else {
			document.getElementById(divid).style.display="none";
		}
	}
} 