function save_favor_rent(userid, itemcode){
	if(!userid) {alert("로그인 후 이용하여 주세요.");return false;}
	if(!itemcode) {alert("상품코드가 없습니다.");return false;}
	if(!confirm("정말 저장 하시겠습니까?")){return false;}
	document.downloadForm.action = '/html/sub02/save_favor_rent.php?userid='+userid+'&itemcode='+itemcode;
	document.downloadForm.submit();
}

// 우편번호
function popPost(objzip1,objzip2,objaddr1,objaddr2) {
	url = "/html/sub08/popup_address.html";
	rtn = window.showModalDialog(url, window, "dialogWidth:432px; dialogHeight:380px;scroll:no;status:no;help:no");
	if(rtn){
		objzip1.value		= rtn['zip1'];
		objzip2.value		= rtn['zip2'];
		objaddr1.value		= rtn['addr1'];
		objaddr2.focus();
	}
}

function check_all(obj){
	if(obj.form && obj.form!="undefined"){
		for(var i=0;i<obj.form.length;i++){
			if(obj.form.elements[i].type.toLowerCase()=="checkbox"){
				if(obj.form.elements[i].checked!=obj.checked && obj.form.elements[i].name.indexOf(obj.name)>=0) obj.form.elements[i].click();
			}
		}
	}
	else{
		var tmpobj = obj;
		while(1){
			tmpobj = tmpobj.parentNode;
			if(tmpobj.tagName.toUpperCase() == "TABLE") break;
		}
		tmpobj = tmpobj.all.tags("INPUT");
		if(tmpobj== null) return;
		for(var i=0;i<tmpobj.length;i++){
			if(tmpobj[i].type.toLowerCase()=="checkbox"){
				if(tmpobj[i].checked!=obj.checked) tmpobj[i].click();
			}
		}
	}
}

function ShowFramePopup(){
	url		= arguments[0]?arguments[0]:"";
	fpwidth	= parseInt(arguments[1]?arguments[1]:"750");
	fpheight	= parseInt(arguments[2]?arguments[2]:"550");
	fpleft	= parseInt(arguments[3]?arguments[3]:"200");
	fptop	= parseInt(arguments[4]?arguments[4]:"100");
	if(url){
		RemoveFramePopup();
		if(!top.mainFrame) top.mainFrame = top;
		frame_popup_DIV = top.mainFrame.document.createElement("DIV");
		frame_popup_DIV.id = "frame_popup_DIV";
		frame_popup_DIV.style.width = fpwidth;
		frame_popup_DIV.style.height = fpheight;
		frame_popup_DIV.style.left = fpleft;
		frame_popup_DIV.style.top = fptop;
		frame_popup_DIV.style.border = "1px solid black";
		frame_popup_DIV.style.position= "absolute";
		frame_popup_DIV.style.display= "";
		top.mainFrame.document.body.appendChild(frame_popup_DIV);

		frame_popup_DIV.innerHTML = "<img src='http://gulumma.net/gulummanet/images/common/btn_close.gif' style='position:absolute;left:650;top:8;cursor:pointer' onclick='RemoveFramePopup()'>";

		frame_popup = top.mainFrame.document.createElement("IFRAME");
		frame_popup.id = "frame_popup";
		frame_popup.src = url;
		frame_popup.style.width = fpwidth;
		frame_popup.style.height = fpheight-2;
		frame_popup.frameBorder = "0";
		frame_popup.style.display= "";
		frame_popup_DIV.appendChild(frame_popup);

		top.mainFrame.document.body.onmousewheel = "return false;";
	}
}
function RemoveFramePopup(){
	tmpFP = arguments[0]?arguments[0]:top.mainFrame.document.getElementById("frame_popup_DIV");
	if(tmpFP) top.mainFrame.document.body.removeChild(tmpFP);
}
function viewover(obj) {
	event.srcElement.style.display="none";
	event.srcElement.nextSibling.style.display = "";
}
function hideover(obj) {
	event.srcElement.style.display="none";
	event.srcElement.previousSibling.style.display = "";
}
function changeImage(obj,src){
	obj.src = src;
}
// explore 변경 관련 - flash
function load_flash( src, w, h, id ) {
	if( typeof(id) == "undefined" ) id = "";

	html = '';
	html += '<OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="' + w + '" height="' + h + '" id="' + id + '">';
	html += '<param name="movie" value="' + src + '">';
    html += '<param name="quality" value="high">';
	html += '<param name="wmode" value="transparent">';
	html += '<embed src="' + src + '" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="' + w + '" height="' + h + '"></embed>';
	html += '</OBJECT>';
	
	document.writeln(html);
}
function objectToString(obj){
	var tmpstr = "";
	for(var i in obj){
		tmpstr += i+" : "+obj[i]+"\n";
	}
	return tmpstr;
}
function fnext(length){
	if(event.srcElement.value.length == length){
		if(event.keyCode == 9 || event.keyCode == 16 || event.keyCode == 37 || event.keyCode == 38 || event.keyCode == 39 || event.keyCode == 40){
			return;
		}
		var tmpobj = event.srcElement.nextSibling;
		var tmpcnt = 0;
		while(tmpcnt<100){
			if(tmpobj.nodeName == "INPUT"){
				if(tmpobj.style.display.toUpperCase()!="NONE"){
					tmpobj.focus();
					return;
				}
			}
			if(tmpobj.nextSibling==null) return;
			tmpobj = tmpobj.nextSibling;
			tmpcnt++;
		}
	}
}
// space 막기 useage : HTML -> <ELEMENT onkeydown="defenseNull()">
function defenseNull() {
	if( event.keyCode == 32 ) event.returnValue = false;
}

// 엔터 막기 useage : HTML -> <ELEMENT onKeyDown="defenseSubmit()">
function defenseSubmit() {
	if( event.keyCode == 13 ) event.returnValue = false;
}

// 숫자,영어,"_" 만 입력받기 useage : HTML -> <ELEMENT onkeydown="onlyId()" onkeypress="onlyId()" onpaste="return false;" style="IME-MODE:DISABLED;">
function onlyId() {
	var rtn = false;
	
	if(event.type=="keypress"){
		if (((event.keyCode >= 65 && event.keyCode <= 90) && !event.shiftKey) || ((event.keyCode >= 97 && event.keyCode <= 122) && event.shiftKey)) {
			alert("CAPS LOCK 이 켜져있습니다.");
			event.keyCode = 0;
		}
		return true;
	}

	if( event.keyCode >= 33 && event.keyCode <= 40 && !event.shiftKey ) rtn = true;
	if( event.keyCode >= 48 && event.keyCode <= 57 && !event.shiftKey ) rtn = true;
	if( event.keyCode >= 65 && event.keyCode <= 90 ) rtn = true;
	if( event.keyCode >= 96 && event.keyCode <= 105 && !event.shiftKey ) rtn = true;
	if( event.keyCode == 189 && event.shiftKey == true ) rtn = true;
	if( event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || event.keyCode == 46 ) rtn = true;
	
	if( rtn ) {
		return;
	}
	else {
		event.returnValue = false;
	}
}

//숫자만 입력받기 useage : HTML -> <ELEMENT onkeydown="onlyNumber()" onpaste="return false;" style="IME-MODE:DISABLED;">
function onlyNumber( canfloat ) {
	var rtn = false;

	if( canfloat !== true ) canfloat = false;

	if( event.keyCode >= 33 && event.keyCode <= 40 && !event.shiftKey ) rtn = true;
	if( event.keyCode >= 48 && event.keyCode <= 57 && !event.shiftKey ) rtn = true;
	if( event.keyCode >= 96 && event.keyCode <= 105 && !event.shiftKey ) rtn = true;
	if( event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || event.keyCode == 46 ) rtn = true;
	if( canfloat == true && ( event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 109 || event.keyCode == 189 ) ) rtn = true;

	if( rtn ) {
		return;
	}
	else{
		event.returnValue = false;
	}
}

function noChar() {
	if( event.keyCode == 9 ) return;
	var val = event.srcElement.value;
	var newVal = val.replace( /[^0-9]/gi, "" );
	event.srcElement.value = newVal;
}

function numCheck() {
	val = event.srcElement.value;
	str=" "+"-0123456789";
	for(i=0;i<val.length;i++) {
		if(str.indexOf(val.substring(i,i+1))<=0) {
			alert("숫자만 입력하세요");
			event.srcElement.value="";
			event.srcElement.focus();
			return;
		}
	}
}

function onlyNumeric() {
	var val = event.srcElement.value;
	if( val && !val.match( /^[-|0-9.][0-9.]*$/gi ) ) {
		alert( "숫자만 입력해 주세요." );
		event.srcElement.value = "";
		event.srcElement.focus();
		return;
	}
}

function moneyCheck() {
	var val = event.srcElement.value.replace(/[ ]/g,'');
	if( val && !val.match( /^[0-9\-\+\,]*$/gi ) ) {
		alert( "숫자만 입력해 주세요." );
		event.srcElement.value = "";
		event.srcElement.focus();
		return;
	}
}

// 숫자체크 후 트루/펄스 반환 by Bread
function numericCheck(val) {
	if(val.match(/^[-|0-9][0-9]*$/gi)) return true;
	else return false;
}

// 양수만 트루로 반환 by Bread
function numberCheck(val) {
	if( val.match( /^[0-9]*$/gi ) ) return true;
	else return false;
}

//숫자가 아닌경우는 비우고 다시 시작
function phoneCheck() {
	val=event.srcElement.value;
	str=" -0123456789";
	for(i=0;i<val.length;i++) {
		if(str.indexOf(val.substring(i,i+1))<=0) {
			alert("잘못된 전화번호입니다.");
			event.srcElement.value="";
			event.srcElement.focus();
			return;
		}
	}
}

// 일정입력뒤에 다음으로 전환
function moveNext( obj, num ) {
	val = event.srcElement.value;
	if( val.length == num ) obj.focus();
}

//비활성화..
function checkCheckBox( form,val,obj1, obj2 ) {
	val=event.srcElement.checked;
	if(obj1=="COPYRIGHT") {
		if(val) {
			eval("form."+obj1+".style.background='#FFFFFF'");
			if(obj2!="") eval("form."+obj2+".style.background='#FFFFFF'");
		}
		else {
			eval("form."+obj1+".style.background='#EEEEEE'");
			if(obj2!="") eval("form."+obj2+".style.background='#EEEEEE'");
		}
	}
	else {
		if(val) {
			eval("form."+obj1+".style.background='#EEEEEE'");
			if(obj2!="") eval("form."+obj2+".style.background='#EEEEEE'");
		}
		else {
			eval("form."+obj1+".style.background='#FFFFFF'");
			if(obj2!="") eval("form."+obj2+".style.background='#FFFFFF'");
		}
	}
	return;
}

//포커스 못오게..
function checkBlur( val ) {
	if(val) event.srcElement.blur();
	return;
}

function checkAll(form,chk){
	for(var i=0;i<form.elements.length;i++){
		if(form.elements[i].type=="checkbox") form[i].checked = chk;
	}
}

function checkAllWithName(form,name,chk){
	for(var i=0;i<form.elements.length;i++){
		if(form.elements[i].type=="checkbox" && form.elements[i].name==name) form.elements[i].checked = chk;
	}
}

function checkAllOverFormWithName(name,chk){
	for(var i=0;i<document.forms.length;i++){
		for(var j=0;j<document.forms[i].elements.length;j++){
			if(document.forms[i].elements[j].type=="checkbox" && document.forms[i].elements[j].name==name) document.forms[i].elements[j].checked = chk;
		}
	}
}

function checkAllWithoutFormWithName(name,chk){
	for(var i=0;i<document.all.length;i++){
		if( document.all[i].type=="checkbox" && document.all[i].name == name) document.all[i].checked = chk;
	}
}

function checkId( field ) {
	var len = field.length;

	var str = "4자 이상 12자 이하의\n영문자/숫자 조합으로 입력해주세요.\n첫글자는 영문이어야 합니다.";

	if( len == 0 ) return true;

 	// 길이는 4자 이상 12자 이하
	if( len < 4 || len > 12 ) {
		alert( str )
		event.srcElement.focus();
		return false;
	}
	// 영문자 및 숫자
	if( !field.match( /^[a-zA-Z][0-9a-zA-Z]*$/gi ) ) {
		alert( str );
		event.srcElement.focus();
		return false;
	}

	return true;
}


function checkEmail(field) {
	if(field.length>0) {
		if( ( field.indexOf(".")<0 ) || ( field.indexOf("@")<0) ) {
				alert("잘못된 메일주소입니다.");
				event.srcElement.value="";
				event.srcElement.focus();
				return;
		}
	}
}


// 아스키코드값을 이용한 한글만 입력받기
function hanCheck(str){
	if(str.length>0) {
		var len;
        len = str.length;
        for (i=0;i<len;i++) {
			if (str.charCodeAt(i) < 128 ) {
				alert('이 항목에는 한글만 입력가능합니다.');
				event.srcElement.value="";
				event.srcElement.focus();
				return;
			}
		}
	}
}

// 주민번호 검사 by Bread
function checkJumin( form, jumin1, jumin2 ) {
	var str = "잘못된 주민등록번호입니다.";
		
	// 일단 유효성 체크
	if( !numberCheck( jumin1.value ) ) {
		alert( "숫자만 입력하셔야 합니다." );
		jumin1.focus();
		return false;
	}
	if( jumin1.value.length != 6 ) {
		alert( str );
		jumin1.focus();
		return false;
	}
	if( !numberCheck( jumin2.value ) ) {
		alert( "숫자만 입력하셔야 합니다." );
		jumin2.focus();
		return false;
	}
	if( jumin2.value.length != 7 ) {
		alert( str );
		jumin2.focus();
		return false;
	}
	
	var jumin = jumin1.value + jumin2.value;

	var len1 = jumin1.value.length;
	var len2 = jumin2.value.length;
	var len = len1 + len2;

	var gender = eval( jumin2.value.substring(0,1) );
	var year = eval( jumin1.value.substring(0,2) );
	var month = eval( jumin1.value.substring(2,4) );
	var day = eval( jumin1.value.substring(4,6) );

	var lastNum = eval( jumin.substring(12,13) );

	//성별체크
	if( gender == 1 || gender == 2 ) year += 1900;
	else if( gender == 3 || gender == 4 ) year += 2000;
	else {
		alert( str );
		jumin2.focus();
		return false;
	}

	// 날짜체크
	if( year < 1900 || month > 12 || day > 31 ) {
		alert( str );
		jumin1.focus();
		return false;
	}

	//주민번호 알고리즘 체크
	var chk = 0;
	for( var i = 0; i <= 5; i++ ) {
		chk = chk + ( ( i % 8 + 2 ) * eval( jumin1.value.substring(i,i + 1 ) ) );
	}
	for (var i = 6; i <=11 ; i++){
		chk = chk + ( ( i % 8 + 2 ) * eval( jumin2.value.substring(i - 6, i - 5 ) ) );
	}

	var okNum = 11 - ( chk % 11 );
	if( okNum > 9 ) okNum = okNum % 10;
	if( lastNum != okNum ) {
		alert( str );
		jumin1.focus();
		return false;
	}
	
	return true;
}

function goWrite( url, time, qrystring ) {
	self.location = url + "?refer=" + time + qrystring;
}

function getCookie( name ) {
  var arg = name + "=";
  var alen = arg.length;
  var clen = document.cookie.length;
  var i = 0;

  while( i < clen ) {
	  var j = i + alen;

	  if( document.cookie.substring(i,j) == arg ) {
		  var end = document.cookie.indexOf( ";", j );
		  if( end == -1 ) end = document.cookie.length;
		  return unescape( document.cookie.substring( j, end ) );
	  }

	  i = document.cookie.indexOf( " ", i ) + 1;
	  if( i == 0 ) break;
  }

  return null;
}

function showLayer( chk, layerid ) {
	if( chk ) layerid.style.display = "";
	else layerid.style.display = "none";
}

function showLayerYn( val, layer ) {
	if( val == "n" ) layer.style.display = "none";
	else if( val == "y" ) layer.style.display = "";
}

function showLayerNoChk( layerid ) {
	if( layerid.style.display == "none" ) layerid.style.display = "";
	else layerid.style.display = "none";
}

function syncHeight( id, added ) {
	if( added == null ) added = 0;
	obj = document.all( id );
	obj.height = obj.contentWindow.document.body.scrollHeight + added;
}

function syncHeightChild( id ) {
	obj = parent.document.all( id );
	//alert(document.body.scrollHeight);
	obj.height = document.body.scrollHeight;
}

function get_js_date( php_date ) {
	var tmp_year = php_date.substring( 0, 4 );
	var tmp_month = eval( php_date.substring( 5, 7 ) ) - 1;
	var tmp_day = eval( php_date.substring( 8, 10 ) );

	var js_date = new Date( tmp_year, tmp_month, tmp_day );

	return js_date;
}

function commaSplit( srcNumber ) {
    var txtNumber = '' + srcNumber;
    var rxSplit = new RegExp( '([0-9])([0-9][0-9][0-9][,.])' );
    var arrNumber = txtNumber.split( '.' );
    arrNumber[0] += '.';
    do {
        arrNumber[0] = arrNumber[0].replace( rxSplit, '$1,$2' );
    }
	while( rxSplit.test( arrNumber[0] ) );
    if( arrNumber.length > 1 ) {
        return arrNumber.join( '' );
    }
	else {
        return arrNumber[0].split( '.' )[0];
    }
}

// 컨텐츠보호 온오프
function protectOnOff( onoff ) {
	if( onoff ) {
		document.oncontextmenu	= new Function( "return false;" );
		document.onselectstart		= new Function( "return false;" );
		document.ondragstart		= new Function( "return false;" );
	}
	else {
		document.oncontextmenu	= new Function( "return true;" );
		document.onselectstart		= new Function( "return true;" );
		document.ondragstart		= new Function( "return true;" );
	}
}

function bluring() { 
	try {
		if( event.srcElement.tagName.toUpperCase() == "A" || event.srcElement.tagName.toUpperCase() == "IMG" || event.srcElement.type == "radio" || event.srcElement.type == "checkbox" || event.srcElement.type == "image" || event.srcElement.type == "button" ) {
			document.body.focus(); 
		}
	}
	catch(e) {}
}

function noContent() {
	try {
		if( event.srcElement.tagName.toUpperCase() == "INPUT" || event.srcElement.tagName.toUpperCase() == "TEXTAREA" ) {
			protectOnOff( false );
		}
		else {
			protectOnOff( true );
		}
	}
	catch(e) {}
}

function empty( chkval ) {
	if( event.srcElement.value == chkval ) event.srcElement.value = "";
}

function winObjClose( obj_name ) {
	var chk = obj_name.location + null;
	if( obj_name && chk != undefined ) obj_name.close();
}

// 쿠키 생성하는 함수 : 입력값 - 쿠키이름 + 쿠키값 + 유효기간
function setCookie( name, value, expires ) {
	document.cookie = name + "=" + escape(value) + ( ( expires == null ) ? "" : ( ";expires = " + expires.toGMTString() ) )+ "; path=";
}

function setCookieSimple( name, value, expiresSec ) {
	var today = new Date();
	var expires = new Date();
	expires.setTime( today.getTime() + expiresSec );
	setCookie( name, value, expires );
}

function trim(str) {
      var count = str.length;
      var len = count;                
      var st = 0;

      while ((st < len) && (str.charAt(st) <= ' ')) {
         st++;
      }
      while ((st < len) && (str.charAt(len - 1) <= ' ')) {
         len--;
      }                
      return ((st > 0) || (len < count)) ? str.substring(st, len) : str ;   
}

function makeTarget( targetName ) {
	var oIFRAME = document.createElement( "<IFRAME style='display:none' name='" + targetName + "'></IFRAME>" );
	document.body.appendChild( oIFRAME );
}

function exeSubmit( frmObj ) {
	var oIFRAME = document.createElement( "<IFRAME style='display:none' name='execformframe'></IFRAME>" );
	document.body.appendChild( oIFRAME );
	frmObj.target = 'execformframe';
	frmObj.submit();
	return true;
}

function exeUrl( strURL ) {
	var oIFRAME = document.createElement( "<IFRAME style='display:none'></IFRAME>" );
	document.body.appendChild( oIFRAME );
	oIFRAME.src = strURL;
}

function setValue( obj, val ) {
	obj.value = val;
}

function showLayerForObj( obj, layerID, interHeight ) {
	var leftpos = 0;
	var toppos = 0;

	if( interHeight == null ) interHeight = 2;

	aTag = obj;
	do {
		aTag		=		aTag.offsetParent;
		leftpos	+=		aTag.offsetLeft;
		toppos		+=		aTag.offsetTop;
	}
	while( aTag.tagName != "BODY" );

	var targetLayer			=	layerID.style;
	targetLayer.left			=	obj.offsetLeft	 + leftpos;
	targetLayer.top			=	obj.offsetTop + toppos + obj.offsetHeight + interHeight;
	targetLayer.width		=	obj.offsetWidth + interHeight;

	targetLayer.visibility = '';
}

function hideLayerForObj( layerID ) {
	var targetLayer		=	layerID.style;

	targetLayer.visibility = 'hidden';
}

function pre_editnumber(){
	var t = event.srcElement;
	t.value = t.value.replace(/,/g,'');
	t.select();
}
function aft_editnumber(){
	var t = event.srcElement;
	var str = t.value.replace(/,/g,'');
	var tmpchk = str.substring(0,1);
	if( tmpchk == '-' || tmpchk == '+' ){
		str = str.substring(1,str.length);
	}
	var tmp = '';
	for( var i=str.length; i>0; i-=3 ){
		tmp = str.substring(i-3,i) + (tmp!=''?',':'') + tmp;
	}
	if( tmpchk == '-' || tmpchk == '+' ){
		tmp = tmpchk + tmp;
	}
	t.value = tmp;
}
