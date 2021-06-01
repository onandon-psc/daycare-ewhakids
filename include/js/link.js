function goRedy(var1,var2,var3,var4){
	alert(var1+','+var2+','+var3+','+var4+','+var5);
}	

function returnNumber(v){
	if(v<10) v = "0"+v;
	return v;
}

function menu(var1,var2,var3,var4,var5){		
	pno = returnNumber(var1)+returnNumber(var2)+returnNumber(var3);
	if(var4) pno = pno + returnNumber(var4);
	if(var5) pno = pno + returnNumber(var5);

	if( pno=="060201") window.open('http://member.ewhakids.or.kr/html/application/');
	else 	location.href="/html/sub/index.php?pno="+pno;
}