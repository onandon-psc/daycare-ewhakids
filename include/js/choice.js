function onSelectAll(f){	

	if(!f) f = document.listForm;

	b_value = false;
	if(f.select_all.checked){
		b_value = true;	
	}
	
	len = f.elements["fcheck"].length;

	if(len){
		for (var i=0; i< len; i++) {
			f.fcheck[i].checked = b_value;
		}
	}else{
		f.fcheck.checked = b_value;
	}

}

function getChecked(f){

	if(!f) f = document.listForm;
	
	var values = "";
	len = f.elements["fcheck"].length;
	
	if(len){
		for (var i=0; i< len; i++) {
			if(f.fcheck[i].checked)
				if(values == "")
					values += f.fcheck[i].value;
				else
					values += ","+f.fcheck[i].value;
		}	
	}else{
		values = f.fcheck.value;
	}
	
	return values;

}


// 회원삭제
function getChecked2(value,f){

	if(!f) f = document.listForm;
	
	var values, values2;

	len = f.elements["fcheck"].length;
	
	if(len){
		for (var i=0; i< len; i++) {
			if(f.fcheck[i].checked){
				if(values == ""){
					values += f.fcheck[i].value;
					values2 += f.fcheck2[i].value;	
				}else{
					values += ","+f.fcheck[i].value;
					values2 +=","+f.fcheck2[i].value;	
				}
			}
		}	
	}else{
		values	 = f.fcheck.value;
		values2 = f.fcheck2.value;
	}

	if ( value == "2"){
		values = values2;
	}
	
	return values;

}