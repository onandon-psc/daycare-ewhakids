// �ֹε�Ϲ�ȣ 
function on_isnumeric(value)
{
	var pattern = /^[0-9]+$/;
	return pattern.test(value)?true:false;
}

function funcCheckFornum(reg_no){
  var sum = 0;
  var odd = 0;

  buf = new Array(13);
  for(i = 0; i < 13; i++){
   buf[i] = parseInt(reg_no.charAt(i));
  }

  odd = buf[7]*10 + buf[8];

  if(odd%2 != 0){
   return false;
  }

  if((buf[11] != 6)&&(buf[11] != 7)&&(buf[11] != 8)&&(buf[11] != 9)){
   return false;
  }

  multipliers = [2,3,4,5,6,7,8,9,2,3,4,5];
  for (i = 0, sum = 0; i < 12; i++){
   sum += (buf[i] *= multipliers[i]);
  }

  sum=11-(sum%11);

  if(sum>=10){
   sum-=10;
  }
  sum += 2;

  if(sum>=10){
   sum-=10;
  }

  if( sum != buf[12]){
   return false;
  }else{
   return true;
  }
}

function on_checkjumin( regno ){

	var tmpRegNo = regno;
	tmpRegNo = tmpRegNo.replace("-","");

//  regno = regno.substring(0,6) + '-' + regno.substring(6);
	if( regno.length != 14 ) return false;

	if ( tmpRegNo.charAt(6) =='5' || tmpRegNo.charAt(6) =='6' || tmpRegNo.charAt(6) =='7' || tmpRegNo.charAt(6) =='8'){
		return funcCheckFornum( tmpRegNo );
	}

    var  i = 0;
    var curDate;
    var curYear;
    var  curMonth;
    var birthYear = 0;              //������� ����
    var  birthMonth = 0;             //����� ����
    var Sum = 0;
    var Mod = 0;
    var YearIn = 0;
    var MonthIn = 0;
    var DateIn = 0;

    curDate = new Date();         //������ ��¥�� ����
    curYear = curDate.getYear();  //������ ��ü�κ��� ����(���� ���ڸ�)�� ����
    curMonth = curDate.getMonth() + 1;  //������ ���� ����

    // ������ ���� Ȯ�� Netscape 3.0, Explorer 3.0 �̻��� ���������� üũ
    if( ((navigator.appName.indexOf("Netscape") != -1) && (navigator.appVersion.substring(0, 1) >= 3)) ||
    ((navigator.appName.indexOf("Microsoft Internet Explorer") != -1) && (navigator.appVersion.substring(0, 1) >= 3)) )
    {
        //�ֹι�ȣ 14�ڸ��� ���ڸ��� üũ
        for( i=0 ; i < 14 ; i++ ){
         //�뽬(-)�� ������ ��� �Է°��� 0 ~ 9 ������ ������ üũ
            if(i != 6){
                if( (regno.charAt(i) < "0") || (regno.charAt(i) > "9") ){
                    //alert("�ֹε�Ϲ�ȣ�� �߸� �Է��ϼ̽��ϴ�!!");
                    return false;
                 }
            } //end if
        } // end for

   //     if( regno.charAt(7) == '3' || regno.charAt(7) == '4'){
   //         return true;
   //     }
        // �ֹι�ȣ �� ���ڸ�(����) = �������
        birthYear = (parseInt(regno.charAt(0))*10) + parseInt(regno.charAt(1));

        //�ֹι�ȣ ��°, ��° �ڸ� = �����
        birthMonth = (parseInt(regno.charAt(2))*10) + parseInt(regno.charAt(3));

        for( i = 0 ; i < 13 ; i++ ){
            if( i == 0)
            YearIn+=parseInt(regno.charAt(i))*10;
            if( i == 1)
            YearIn+=parseInt(regno.charAt(i));
            if( i == 2)
            MonthIn+=parseInt(regno.charAt(i))*10;
            if( i == 3)
            MonthIn+=parseInt(regno.charAt(i));
            if( i == 4)
            DateIn+=parseInt(regno.charAt(i))*10;
            if( i == 5)
            DateIn+=parseInt(regno.charAt(i));
            if( i < 6)
            Sum+=parseInt(regno.charAt(i))*(i+2);
            if( i > 6 && i < 9 )
            Sum+=parseInt(regno.charAt(i))*(i+1);
            if( i > 8)
            Sum+=parseInt(regno.charAt(i))*(i-7);
        } //end for

        Mod=11-(Sum%11);
        if((11-(Sum%11))>=10) Mod-=10;


        if( Mod!=parseInt(regno.charAt(13)) ){
            return false;
        }

        if( MonthIn < 1 || MonthIn > 12 || DateIn < 1 || DateIn > 31 ){
            return false;
        }

        if( (MonthIn ==4 || MonthIn == 6 || MonthIn == 9 || MonthIn == 11 ) && DateIn > 30 ){
            return false;
        }

        if( MonthIn ==2 && DateIn > 29 ){
            return false;
        }


    } // end if
    else
    return false;

    return true;
}

function on_calcAge(sJumin, reqDate)
{
	var iAge = 0 ;
	var ch ;
	var i ;
	var i_year ;
	var i_mon ;
	var i_curYear ;
	var i_curMon ;

	if (sJumin == null || reqDate == null)
	{
		return 0 ;
	}

	if (sJumin.length != 10)
	{
		return 0 ;
	}

	i_year	= parseInt( sJumin.substring(0, 4) ,10) ;
	i_mon	= parseInt( sJumin.substring(5, 7) ,10) ;

	i_curYear	= parseInt( reqDate.substring( 0, 4 ) ,10);
	i_curMon	= parseInt( reqDate.substring( 5, 7 ) ,10);

	iAge = i_curYear - i_year;
	iAge--;

	if( iAge < 0 ) iAge = 0 ;

	return iAge ;
}

function on_check_jumin_len( obj1, obj2 )
{
	var str = obj1.value;

	if(str.match(/[^0-9]/)) { alert('���ڸ� �־��ּ���'); obj1.value = ''; obj1.focus(); return false; } 
	if( str.length == 6 ) {
	obj2.focus();
	}
}

function on_calc_jumin_age( obj1, obj2 , objAge, regDate)
{
	var str = obj2.value;	
	if(str.match(/[^0-9]/)) { alert('���ڸ� �־��ּ���'); obj2.value = ''; obj2.focus(); return false; } 
	if( str.length == 7 ) {
		if( obj1.value.length == 6 ) {
			
			if( on_check_jumin( obj1, obj2, true ) ) {
				
				if( obj1.value.substring(0,4) <= 2000){
					yearTop2 = "20";
				}else{
					yearTop2 = "19";
				}

				var birth = yearTop2 + obj1.value.substring(0,2) +"-" + obj1.value.substring(2,4)+"-"+ obj1.value.substring(4,6);
				objAge.value = on_calcAge( birth, regDate);
				return;
			}
		}
	}
	objAge.value = "0";
}

function check_length(len){
	
}
function jumin_check_length(no)
{
	var obj1=document.getElementById("childjumin1["+no+"]");
	var obj2=document.getElementById("childjumin2["+no+"]");
	return on_check_jumin_len( obj1, obj2 );
}

function jumin_check(no)
{
	var obj1=document.getElementById("chbirth"+no+"_1");
	var obj2=document.getElementById("chbirth"+no+"_2");
	var objAge=document.getElementById("chage"+no);
	return on_calc_jumin_age( obj1, obj2 , objAge, document.frm.toDay.value);

}

function on_check_jumin( obj1, obj2, bChild ){	

	if( obj1.value == "" ) {
		alert("�ֹε�Ϲ�ȣ�� �Է��Ͻʽÿ�.");
		obj1.focus();
		return false;
	}		
	
	if( !on_isnumeric( obj1.value ) ) {
		alert("�ֹε�Ϲ�ȣ�� ���ڷ� �Է��ϼž� �մϴ�.");
		obj1.focus();
		return false;
	}
	if( obj1.value.length != 6 ) {
		alert("�ֹε�Ϲ�ȣ 6�ڸ��� �Է��ϼž� �մϴ�.");
		obj1.focus();
		return false;
	}
	if( obj2.value == "" ) {
		alert("�ֹε�Ϲ�ȣ�� �Է��Ͻʽÿ�.");
		obj2.focus();
		return false;
	}
	if( !on_isnumeric( obj2.value ) ) {
		alert("�ֹε�Ϲ�ȣ�� ���ڷ� �Է��ϼž� �մϴ�.");
		obj2.focus();
		return false;
	}
	if( obj2.value.length != 7 ) {
		alert("�ֹε�Ϲ�ȣ 7�ڸ��� �Է��ϼž� �մϴ�.");
		obj2.focus();
		return false;
	}

	if( !on_checkjumin( obj1.value +"-" + obj2.value ) ) {
		alert("�ùٸ� �ֹε�Ϲ�ȣ�� �ƴմϴ�.\n��Ȯ�� �Է¹ٶ��ϴ�.");
		obj1.value = "";
		obj2.value = "";
		obj1.focus();
		return false;
	}	
	
	if( bChild == true ) {	// 97�� ���ĸ� ����
		
		brithYear = obj1.value.substring(0,2);

		if( obj2.value.charAt(0) == '3' || obj2.value.charAt(0) == '4' || obj2.value.charAt(0) == '7' || obj2.value.charAt(0) == '8' || brithYear == '97' || brithYear == '98' || brithYear == '99' ){	
		}else{
			alert("�Ƶ��� 1997�⵵ ���� �»��ڸ� ��� �����մϴ�.");
			obj1.value = "";
			obj2.value = "";
			obj1.focus();
			return false;
		}

	}
	return true;
}

// ID �ߺ�Ȯ��
function popId() {
	f = document.frm;

	if (f.mbId.value=="") {
		alert("���̵� �Է��Ͻʽÿ�!!");
		f.mbId.focus();
		return;
	}
	if (!f.mbId.value.match(/^[a-z\d]{5,15}$/)) {
		alert("���̵�� 5���̻� 16�� �̸�, ���� �� ���ڸ� ��밡���մϴ�.");
		f.mbId.focus();
		f.mbId.select();
		return;
	}
	mbId = f.mbId.value;
	url = "/html/sub07/popup_iddouble.php?mbId="+mbId;
	window.showModalDialog(url, window, "dialogWidth:454px; dialogHeight:359px;scroll:no;status:no;help:no;");
}
function popId2() {
	f = document.frm;

	if (f.mbId.value=="") {
		alert("���̵� �Է��Ͻʽÿ�!!");
		f.mbId.focus();
		return;
	}
	if (!f.mbId.value.match(/^[a-z\d]{5,15}$/)) {
		alert("���̵�� 5���̻� 16�� �̸�, ���� �� ���ڸ� ��밡���մϴ�.");
		f.mbId.focus();
		f.mbId.select();
		return;
	}
	var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
//  var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;

	var Width = 485;
	var Height = 389;
	if(navigator.appVersion.indexOf('MSIE 7')>-1 || navigator.appVersion.indexOf('MSIE 8')>-1){
		Width = 454;
		Height = 359;
	}
	var left = (screen.width/2)-(Width/2) + dualScreenLeft;
	var top = (screen.height/2)-(Height/2);

	mbId = f.mbId.value;
	url = "/html/sub07/popup_iddouble.php?mbId="+mbId;
	rtn = window.open(url, "", 'width='+Width+', height='+Height+', top='+top+', left='+left+', fullscreen=no, menubar=no, status=no, toolbar=no, titlebar=yes, location=no, scrollbar=no');
}

// ��й�ȣ����
function popPwd(id,removalPwd) {
	url = "/html/sub07	 /pwmody.php?mbId="+id+"&removalPwd="+removalPwd;
	window.showModalDialog(url, window, "dialogWidth:410px; dialogHeight:380px;status:no;help:no");
}

// ���â
function popSmd(url,w,h,s) {
	window.showModalDialog(url, window, "dialogWidth:"+w+"px; dialogHeight:"+h+"px;scroll:"+s+";status:no;help:no");
}

// �̸��� ã��
function popEmail() {
	url = "/html/sub07/popup_email.php";
	window.showModalDialog(url, window, "dialogWidth:454px; dialogHeight:250px;scroll:no;status:no;help:no");
}

// �̸��� ã��
function popEmail2() {
	url = "/html/sub07/new_popup_email.php";
	window.showModalDialog(url, window, "dialogWidth:454px; dialogHeight:250px;scroll:no;status:no;help:no");
}

// �Է�üũ
function input_check(f){
	try{
		var modeType = f.mode.value;
		var alphaDigit = "abcdefghijklmnopqrstuvwxyzABCDEFGHTJKLMNOPQRSTUVWXYZ1234567890";

		if(modeType == "write"){
			if ( !f.mbId.value ) {alert("���̵� �Է��Ͻʽÿ�!!");f.mbId.focus();return false;}
			if (!f.mbId.value.match(/^[a-z\d]{5,15}$/)) {alert("���̵�� 5���̻� 16�� �̸�, ���� �� ���ڸ� ��밡���մϴ�.");f.mbId.focus();f.mbId.select();return false;}
			if (f.mbId.value != f.idCheck.value) {alert("���̵� �ߺ� üũ�� �Ͻʽÿ�!!");f.mbId.focus();f.mbId.select();return false;}
		}
		if(modeType == "modify"){
			if ( f.mbPwd.value == "" ){alert("���� ��й�ȣ�� �Է��Ͻʽÿ�!!");f.mbPwd.focus();return false;}
			if ( f.mbPwd.value.length < 4 || f.mbPwd.value.length > 12){alert("���� ��й�ȣ�� 4~12�� �̳����� �մϴ�.");f.mbPwd.focus();return false;}
			if ( f.mbPwd2.value != "" ){
				if ( f.mbPwd2.value.length < 4 || f.mbPwd2.value.length > 12){alert("�� ��й�ȣ�� 4~12�� �̳����� �մϴ�.");f.mbPwd2.focus();return false;}
			}
		}

		if (!f.mbName.value){alert("�θ��̸��� �Է��Ͻʽÿ�!!");f.mbName.focus();return false;}
		if( !on_checkjumin( f.mbJumin1.value +"-" + f.mbJumin2.value ) ) {
			alert("�ùٸ� �ֹε�Ϲ�ȣ�� �ƴմϴ�.\n��Ȯ�� �Է¹ٶ��ϴ�.");
			f.mbJumin1.value = "";
			f.mbJumin2.value = "";
			f.mbJumin1.focus();
			return false;
		}		

		if(modeType == "write"){
			if ( f.mbPwd.value == "" ){alert("��й�ȣ�� �Է��Ͻʽÿ�!!");f.mbPwd.focus();return false;}
			if ( f.mbPwd.value.length < 4 || f.mbPwd.value.length > 12){alert("��й�ȣ�� 4~12�� �̳����� �մϴ�.");f.mbPwd.focus();return false;}
			if( (!f.mbPwd.value.match(/[a-zA-Z]/) || !f.mbPwd.value.match(/[0-9]/)) || f.mbPwd.value.match(/[^a-zA-Z0-9]/) ){alert("��й�ȣ�� ������ ������ ȥ������ �����Ǿ�� �մϴ�.");f.mbPwd.focus();return false;}
			if ( f.mbPwd2.value == "" ){alert("��й�ȣ Ȯ���� �Է��Ͻʽÿ�!!");f.mbPwd2.focus();return false;}
			if ( f.mbPwd.value != f.mbPwd2.value){alert("��й�ȣ�� ���� ��ġ���� �ʽ��ϴ�.");f.mbPwd.value = f.mbPwd2.value = "";f.mbPwd.focus();return false;}
			if ( f.mbPwd.value.indexOf(" ") >= 0){alert("��й�ȣ���� ������ ���� �ȵ˴ϴ�.");f.mbPwd.value = f.mbPwd2.value = "";f.mbPwd.focus();return false;}
			for (i=0; i < f.mbPwd.value.length; i++){
				if (alphaDigit.indexOf(f.mbPwd.value.substring(i, i+1)) < 0){alert("��й�ȣ�� ������ ������ ���ո� ����� �� �ֽ��ϴ�.");f.mbPwd.value=f.member.pwc="";f.mbPwd.focus();return false;}
			}
		}
		if (!f.mbEmail1.value){alert("�̸����� �Է��Ͻʽÿ�!!");f.mbEmail1.focus();return false;}
		if (!f.mbEmail2.value){alert("�̸����� �Է��Ͻʽÿ�!!");f.mbEmail2.focus();return false;}	
		if (!f.mbGroup.value){alert("��ȸ�ҼӺ�ó�� �Է��Ͻʽÿ�!!");f.mbGroup.focus();return false;}	
		//if (!f.mbNick.value){alert("�г����� �Է��Ͻʽÿ�!!");f.mbNick.focus();return false;}	

		if(modeType == "write"){			
			if( !f.elements["childName[1]"].value ){alert("�ڳ���� �Է��� �ֽʽÿ�.");f.elements["childName[1]"].focus();return false;}
			if( !f.elements["childBirth[1]"].value ){alert("�ڳ� ��������� �Է��� �ֽʽÿ�.");f.elements["childBirth[1]"].focus();return false;}			
		}		
		return;
	}
	catch(e){
		alert(e.message);
		return false;
	}
}

// �Է�üũ
function input_check2(f){
	try{
		var modeType = f.mode.value;
		var alphaDigit = "abcdefghijklmnopqrstuvwxyzABCDEFGHTJKLMNOPQRSTUVWXYZ1234567890";
		var check = /^(?=.*[a-zA-Z])(?=.*[!@#$%^*+=-])(?=.*[0-9]).*$/;

		if(modeType == "write"){
			if ( !f.mbId.value ) {alert("���̵� �Է��Ͻʽÿ�!!");f.mbId.focus();return false;}
			if (!f.mbId.value.match(/^[a-z\d]{5,15}$/)) {alert("���̵�� 5���̻� 16�� �̸�, ���� �� ���ڸ� ��밡���մϴ�.");f.mbId.focus();f.mbId.select();return false;}
			if (f.mbId.value != f.idCheck.value) {alert("���̵� �ߺ� üũ�� �Ͻʽÿ�!!");f.mbId.focus();f.mbId.select();return false;}
		}
		if(modeType == "modify"){
			if ( f.mbPwd.value == "" ){alert("���� ��й�ȣ�� �Է��Ͻʽÿ�!!");f.mbPwd.focus();return false;}
			if ( f.mbPwd.value.length < 4 || f.mbPwd.value.length > 12){alert("���� ��й�ȣ�� 4~12�� �̳����� �մϴ�.");f.mbPwd.focus();return false;}
			if ( f.mbPwd2.value != "" ){
				if ( f.mbPwd2.value.length < 6 || f.mbPwd2.value.length > 16){alert("�� ��й�ȣ�� 6~16�� �̳����� �մϴ�.");f.mbPwd2.focus();return false;}
				if ( !check.test(f.mbPwd2.value)) {alert("�� ��й�ȣ�� ����, ����, Ư�������� �������� �Է����ּ���.");f.mbPwd2.focus();return false;}
				if ( f.mbPwd2.value.indexOf(" ") >= 0){alert("��й�ȣ���� ������ ���� �ȵ˴ϴ�.");f.mbPwd2.focus();return false;}
			}
		}

		if (!f.mbName.value){alert("�θ��̸��� �Է��Ͻʽÿ�!!");f.mbName.focus();return false;}	

		if(modeType == "write"){
			if ( f.mbPwd.value == "" ){alert("��й�ȣ�� �Է��Ͻʽÿ�!!");f.mbPwd.focus();return false;}
			if ( f.mbPwd.value.length < 6 || f.mbPwd.value.length > 16){alert("��й�ȣ�� 6~16�� �̳����� �մϴ�.");f.mbPwd.focus();return false;}
			if ( !check.test(f.mbPwd.value)) {alert("��й�ȣ�� ����, ����, Ư�������� �������� �Է����ּ���.");f.mbPwd.focus();return false;}
			//if( (!f.mbPwd.value.match(/[a-zA-Z]/) || !f.mbPwd.value.match(/[0-9]/)) || f.mbPwd.value.match(/[^a-zA-Z0-9]/) ){alert("��й�ȣ�� ������ ������ ȥ������ �����Ǿ�� �մϴ�.");f.mbPwd.focus();return false;}
			if ( f.mbPwd2.value == "" ){alert("��й�ȣ Ȯ���� �Է��Ͻʽÿ�!!");f.mbPwd2.focus();return false;}
			if ( f.mbPwd.value != f.mbPwd2.value){alert("��й�ȣ�� ���� ��ġ���� �ʽ��ϴ�.");f.mbPwd.value = f.mbPwd2.value = "";f.mbPwd.focus();return false;}
			if ( f.mbPwd.value.indexOf(" ") >= 0){alert("��й�ȣ���� ������ ���� �ȵ˴ϴ�.");f.mbPwd.value = f.mbPwd2.value = "";f.mbPwd.focus();return false;}
			/*
			for (i=0; i < f.mbPwd.value.length; i++){
				if (alphaDigit.indexOf(f.mbPwd.value.substring(i, i+1)) < 0){alert("��й�ȣ�� ������ ������ ���ո� ����� �� �ֽ��ϴ�.");f.mbPwd.value=f.member.pwc="";f.mbPwd.focus();return false;}
			}
			*/
		}
		if (!f.mbEmail1.value){alert("�̸����� �Է��Ͻʽÿ�!!");f.mbEmail1.focus();return false;}
		if (!f.mbEmail2.value){alert("�̸����� �Է��Ͻʽÿ�!!");f.mbEmail2.focus();return false;}	
		if (!f.mbGroup.value){alert("��ȸ�ҼӺ�ó�� �Է��Ͻʽÿ�!!");f.mbGroup.focus();return false;}	
		//if (!f.mbNick.value){alert("�г����� �Է��Ͻʽÿ�!!");f.mbNick.focus();return false;}	

		if(modeType == "write"){			
			if( !f.elements["childName[1]"].value ){alert("�ڳ���� �Է��� �ֽʽÿ�.");f.elements["childName[1]"].focus();return false;}
			if( !f.elements["childBirth[1]"].value ){alert("�ڳ� ��������� �Է��� �ֽʽÿ�.");f.elements["childBirth[1]"].focus();return false;}			
		}		
		return;
	}
	catch(e){
		alert(e.message);
		return false;
	}
}

 function msgposit_list(evt){
	if(navigator.appName == "Netscape"){
	   helpbox.style.left = evt.pageX + 10;
	   helpbox.style.top  = evt.pageY + 20;
	} else {
	   helpbox.style.posLeft = event.x + 10 + document.body.scrollLeft;
	   helpbox.style.posTop  = event.y + 20 + document.body.scrollTop;
	}
 }

 function msgset_list(v){
	  var text;
	  helpbox.style.visibility = "visible";
	  if( v == "1" ){
		  text = "<table width='350' border='0' cellspacing='0' cellpadding='0'><tr><td><img src='../../images/member/box_top.gif' width='350' height='9'></td></tr><tr>      <td background='../../images/member/box_bg.gif' style='padding:5 0 0 0;'><table width='320' border='0' align='center' cellpadding='0' cellspacing='0'><tr><td class='font_gary1'><img src='../../images/common/icon1.gif'> �峭��/���� �뿩 ȸ���̶�?</td></tr><tr><td class='m1_1' style='padding:3 0 0 14;'>�������� �����ϴ� ������ �� �θ�, �������� �����ϰ� �ִ� �������� �峭�� �� ������ �뿩 �� �� �ִ� ȸ��</td></tr><tr><td class='m1_1' style='padding:3 0 0 14;'><b>ȸ������ ���</b></td></tr><tr><td class='m1_1' style='padding:3 0 0 14;'>�������������� ����Ʈ ȸ������ �� ������������������(��ġ/û��)�� ����, ��ȸ�� ���� �� ������������������ ȸ��ī�� �߱�</td></tr><tr><td class='m1_1' style='padding:3 0 0 20;'>�� ��ȸ�� : 1����<br>�� �뿩 : �峭�� 2��+���� 2�� �Ǵ� ���� 5��<br>�� �뿩�Ⱓ : 10��</td></tr></table></td></tr><tr><td><img src='../../images/member/box_bottom.gif' width='350' height='10'></td></tr></table>";
	  }else{
		  text = "<table width='350' border='0' cellspacing='0' cellpadding='0'><tr><td><img src='../../images/member/box_top.gif' width='350' height='9'></td></tr><tr><td background='../../images/member/box_bg.gif' style='padding:5 0 0 0;'><table width='320' border='0' align='center' cellpadding='0' cellspacing='0'><tr><td class='font_gary1'><img src='../../images/common/icon1.gif'> ���������� ȸ���̶�?</td></tr><tr><td class='m1_1' style='padding:3 0 0 14;'>������ ���� �����ü����� ������ ��� �����ڰ� ���������� �� å������ ���� ������ �뿩�� �� �ִ� ȸ��</td></tr><tr><td class='m1_1' style='padding:3 0 0 14;'><b>ȸ������ ���</b></td></tr><tr><td class='m1_1' style='padding:3 0 0 14;'>�������������� ����Ʈ ȸ������ �� ������������������(û��)�� ����, ��ȸ�� ���� �� ������������������ �뿩 ȸ��ī�� �߱�</td></tr><tr><td class='m1_1' style='padding:3 0 0 20;'>�� ��ȸ�� : 1����<br>�� �뿩 : ���� 10��<br>�� �뿩�Ⱓ : 10��</td></tr></table></td></tr><tr><td><img src='../../images/member/box_bottom.gif' width='350' height='10'></td></tr></table>";
	  }
	  helpbox.innerHTML = text;
 }

 function msghide_list(){helpbox.style.visibility = "hidden";}

 function _f_add(){
	var tmpChildTable = document.getElementById("childTable");
	var tmpHiddenChildTable = document.getElementById("hiddenChildTable");

//	tmpChildTable.insertRow().replaceNode(tmpHiddenChildTable.rows(0).cloneNode(true));

	var tmpRow = tmpChildTable.insertRow(tmpChildTable.rows.length);
	tmpRow.parentNode.replaceChild(tmpHiddenChildTable.rows.item(0).cloneNode(true), tmpRow);

	for(var i=1;i<tmpChildTable.rows.length;i++){
		var tmpInputs = tmpChildTable.rows[i].getElementsByTagName("INPUT");
		for(var i2=0;i2<tmpInputs.length;i2++){
			tmpInputs[i2].outerHTML = tmpInputs[i2].outerHTML.replace(/\[[0-9]*\]/,"["+i+"]");
		}
	}
}

function _f_del(obj){
	var tmpObj = obj;
	while(tmpObj.nodeName!="TR"){
		tmpObj = tmpObj.parentNode;
	}
	tmpObj.parentNode.removeChild(tmpObj);
}