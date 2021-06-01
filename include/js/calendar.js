// js calendar by jaewon
// last_modified : 2009/01/15
// Usage : <script type="text/javascript" src="calendar.js"></script>
//         <input type="text" id="start_date" name="start_date" value="20081027|null">
//         <input type="button" name="달력" onClick="calendar(event, 'start_date')">


// another modify : 2009/07/24     -- fix left position for div or iframe

var calendar_div;
var calendar_obj;
var calendar_tt;

// 숨겨야 되는 select element 저장변수(Array)
var hidden_select;
// element의 x, y, width, height를 가져옴. (select외에 object를 인수로 사용해도 됨 ex:div)
function get_pos(selectObj)
{
    var pos = new Array();
    
    var pos_x = 0, pos_y = 0;
    
    // while에서 offsetParent를 찾아가는 방식이라
    // 다른 지정자에 인수로 넘어온 object를 넘겨줌.
    obj = selectObj;
    
    // 좌표계산
    while(obj.offsetParent)
    {
        pos_y += parseInt(obj.offsetTop);
        pos_x += parseInt(obj.offsetLeft);
        
        obj = obj.offsetParent;
    }
    pos_x += parseInt(obj.offsetLeft);
    pos_y += parseInt(obj.offsetTop);
    
    // 좌표저장
    pos.x = pos_x;
    pos.y = pos_y;
    pos.x2 = pos_x + selectObj.offsetWidth;
    pos.y2 = pos_y + selectObj.offsetHeight;
    
    return pos;
}

function hide_select(x, y, x2, y2)
{
    var selects = document.getElementsByTagName('select');
    var hidden_count = 0;
    
    x = parseInt(x);
    y = parseInt(y);
    x2 = parseInt(x2);
    y2 = parseInt(y2);
    
    var x_cross = false;
    var y_cross = false;
    
    hidden_select = new Array();
    
    //alert(x + ':' + y + ':' + x2 + ':' + y2);
    for(var i=0; i<selects.length; i++)
    {
        selects[i].pos = new Array();
        selects[i].pos = get_pos(selects[i]);
        
        // Div 영역에 포함 되어 있다면
        if((x <= selects[i].pos.x && x2 >= selects[i].pos.x) || (x <= selects[i].pos.x2 && x2 >= selects[i].pos.x2))
            x_cross = true;
        else
            x_cross = false;
        
        if((y <= selects[i].pos.y && y2 >= selects[i].pos.y) || (y <= selects[i].pos.y2 && y2 >= selects[i].pos.y2))
            y_cross = true;
        else
            y_cross = false;
        
        if(x_cross == true && y_cross == true)
        {
            selects[i].style.visibility = "hidden";
            hidden_select[hidden_count++] = i;
        }
    }
}

function show_select()
{
    var selects = document.getElementsByTagName('select');
    for(var i=0; i<hidden_select.length; i++)
    {
        selects[hidden_select[i]].style.visibility = "visible";
    }
    hidden_select = null;
}

function calendar_set(e)
{
    if(!e) var e = window.event;
    var click_obj = e.target || e.srcElement;
    
    var pos_x = 0;
    var pos_y = 0;
    var obj = click_obj;
    
    while(obj.offsetParent)
    {
        pos_y += parseInt(obj.offsetTop);
        pos_x += parseInt(obj.offsetLeft);
        
        obj = obj.offsetParent;
    }
    pos_x += parseInt(obj.offsetLeft);
    pos_y += parseInt(obj.offsetTop);
    
    pos_y += click_obj.offsetHeight;
    
    calendar_div = document.getElementById('calendar_div');
    
    if(!calendar_div)
    {
        calendar_div = document.createElement("DIV");
        document.body.appendChild(calendar_div);
    }
	if (document.body.clientWidth < pos_x + 160)
	{
		pos_x = pos_x + click_obj.offsetWidth - 160;
	}
    calendar_div.id = "calendar_div";
    calendar_div.style.cssText = "width:160px; background-color:#ffffff; border:3px; border-style:double; border-color:#d0d0d0;";
    calendar_div.style.position = "absolute";
    calendar_div.style.top = pos_y + 'px';
    calendar_div.style.left = pos_x + 'px';
    
    calendar_div.style.visibility = "visible";
    calendar_div.onmouseover = function(e) {
        if(calendar_tt)
            window.clearTimeout(calendar_tt);
    }
    
    calendar_div.onmouseout = function() {
        if(calendar_tt)
            window.clearTimeout(calendar_tt);
        calendar_tt = window.setTimeout("calendar_hide()", 300);
    }
    
    calendar_div.focus();
    
    calendar_div.ondblclick = calendar_close;
}

function calendar_close(e)
{
    if(!e) var e = window.event;
    document.getElementById('calendar_div').style.visibility = "hidden";
    
    if(hidden_select)
        show_select();
    
    return false;
}

function calendar_draw(set_date)
{
    var days_arr = new Array(31,28,31,30,31,30,31,31,30,31,30,31);
    
    var html = "<table border=\"0\" width=\"100%\">";
    var calendar_date, calendar_t;
    
    if(set_date && set_date.length >= 4)
    {
        if(set_date.length == 4)
            set_date += '0101';
        else if(set_date.length == 6)
            set_date += '01';
        calendar_date = set_date;
        var y = calendar_date.substring(0, 4);
        var m = calendar_date.substring(4, 6);
        var d = calendar_date.substring(6, 8);
        var s_t = new Date(y, m-1, d);
        if(s_t.getMonth()+1 != Number(m) || s_t.getDate() != Number(d))
            calendar_t = null;
        else
            calendar_t = new Date(y, m-1, 1);
    }
    
    var t = new Date();
    var today = t.getFullYear();
    
    if(t.getMonth()+1 < 10)
        today += '0' + String(t.getMonth()+1);
    else
        today += String(t.getMonth()+1);
    
    if(t.getDate() < 10)
        today += '0' + String(t.getDate());
    else
        today += String(t.getDate());
    
    if(!calendar_t)
    {
        var y = t.getFullYear();
        var m = t.getMonth();
        
        calendar_t = new Date(y, m, 1);
    }
    
    var calendar_yymm = calendar_t.getFullYear();
    calendar_yymm += (calendar_t.getMonth()+1 < 10)? "-"+String('0' + (calendar_t.getMonth() + 1)) : "-"+String(calendar_t.getMonth()+1);
    
    var calendar_y = Number(calendar_yymm.substring(0, 4));
    var calendar_m = Number(calendar_yymm.substring(5, 7));
    
    var prev_m;
    if(Number(calendar_m) == 1)
    {
        prev_m = String(calendar_y - 1);
        prev_m += 12;
    }
    else
    {
        prev_m = String(calendar_y);
        prev_m += (calendar_m - 1 < 10)? '0' + (calendar_m - 1) : calendar_m - 1;
    }
    var next_m;
    if(Number(calendar_m) == 12)
    {
        next_m = String(calendar_y + 1);
        next_m += '01';
    }
    else
    {
        next_m = String(calendar_y);
        next_m += (calendar_m + 1 < 10)? '0' + (calendar_m + 1) : calendar_m + 1;
    }
    
    calendar_m = (calendar_m < 10)? String('0' + calendar_m) : String(calendar_m);
    var prev_y = String(calendar_y-1) + calendar_m;
    var next_y = String(calendar_y+1) + calendar_m;
    
    html += "<tr height=\"20\">";
    html += "<td colspan=\"6\" width=\"100%\" align=\"center\" valign=\"center;\">";
    html += "<span style=\"cursor:pointer; font-size: 12px;\" onClick=\"calendar_draw('"+prev_y+"')\">◀</span>&nbsp;";
    html += "<span style=\"cursor:pointer; font-size: 12px;\">"+calendar_y+"</span>&nbsp;";
    html += "<span style=\"cursor:pointer; font-size: 12px;\" onClick=\"calendar_draw('"+next_y+"')\">▶</span>&nbsp;";
    html += "<span style=\"cursor:pointer; font-size: 12px;\" onClick=\"calendar_draw('"+prev_m+"')\">◀</span>&nbsp;";
    html += "<span style=\"cursor:pointer; font-size: 12px;\">"+calendar_m+"</span>&nbsp;";
    html += "<span style=\"cursor:pointer; font-size: 12px;\" onClick=\"calendar_draw('"+next_m+"')\">▶</span>&nbsp;";
    html += "</td>";
    html += "<td align=\"right\" valign=\"center;\"><span style=\"cursor:pointer; font-size: 12px; font-weight:bold;\" onClick=\"calendar_close(event)\">X</span></td>";
    html += "</tr>";
    
    html += "<tr height=\"20\">";
    html += "<td style=\"background-color:#f0f0f0; font-weight:bold; font-size:11px;\">일</td>";
    html += "<td style=\"background-color:#f0f0f0; font-weight:bold; font-size:11px;\">월</td>";
    html += "<td style=\"background-color:#f0f0f0; font-weight:bold; font-size:11px;\">화</td>";
    html += "<td style=\"background-color:#f0f0f0; font-weight:bold; font-size:11px;\">수</td>";
    html += "<td style=\"background-color:#f0f0f0; font-weight:bold; font-size:11px;\">목</td>";
    html += "<td style=\"background-color:#f0f0f0; font-weight:bold; font-size:11px;\">금</td>";
    html += "<td style=\"background-color:#f0f0f0; font-weight:bold; font-size:11px;\">토</td>";
    html += "</tr>";
    
    var week = calendar_t.getDay();
    // 빈 TD 출력
    for(var i=0; i<week; i++)
    {
        html += "<td>&nbsp;</td>\n";
    }
    
    // 해당월의 마지막 날을 가져옴.
    if(String(calendar_t.getMonth()+1) == '2')
        max_days = ((( calendar_y % 4 == 0) && (calendar_y % 100 != 0)) || (calendar_y % 400 == 0))? 29 : 28;
    else
        max_days = days_arr[calendar_t.getMonth()];
    
    var this_date;
    for(var i=1; i<=max_days; i++)
    {
        if(week > 6)
        {
            html += "</tr>";
            week = 0;
        }
        if(week == 0)
        {
            html += "<tr height=\"20\">";
        }
        
        this_date = calendar_yymm;
        this_date += (i <= 9)? "-"+String('0' + i) : "-"+String(i);
        
        var style = "cursor:pointer; font-size:12px; text-align:center;";
        if(set_date == this_date)
            style += " text-decoration:underline;";
        if(today == this_date)
            style += " font-weight:bold;";
        if(week == 0)
            style += " color:red;";
        if(week == 6)
            style += " color:blue;";
        html += "<td style=\""+style+"\" onClick=\"calendar_set_date('"+this_date+"');\">"+i+"</td>";
        week ++;
    }
    
    if(week < 6)
    {
        for(var i=week; i<=6; i++)
        {
            html += "<td>&nbsp;</td>\n";
        }
        html += "</tr>";
    }
    html += "</table>";
    
    calendar_div.innerHTML = html;
}

function calendar_set_date(set_date)
{
    if(calendar_obj)
        calendar_obj.value = set_date ; 
    calendar_close();
    
    if (calendar_obj.name == 'sdate1' ) {
    	var form = document.rentForm ;
    	if ( typeof( form ) != 'undefined' ) {
    		fnGetReturnDate() ; 
    	}
    }
    
}

function calendar_hide()
{
    if(calendar_tt)
        window.clearTimeout(calendar_tt);
    calendar_close();
}

function calendar_afterHide()
{
    if(calendar_tt)
        window.clearTimeout(calendar_tt);
    this.t = window.setTimeout("calendar_hide()", 300);
}

function calendar_clearT()
{
    if(calendar_tt)
        window.clearTimeout(calendar_tt);
}

function calendar(e, obj)
{
    if(!e) var e = window.event;
//	alert(obj);
    calendar_obj = obj;
    var default_date = calendar_obj.value.replace(/[^0-9]/g, '');
    
    if(default_date.length < 4)
        default_date = '';
    else if(default_date.length == 4)
        default_date += '0101';
    else if(default_date.length == 6)
        default_date += '01';
    
    if(!calendar_obj)
    {
        alert(calendar_obj + ' object is null');
        return;
    }
    
    calendar_set(e);
    calendar_draw(default_date);
    
    if(hidden_select)
        show_select();
    
    if(navigator.userAgent.indexOf('Chrome') == -1 && navigator.userAgent.indexOf('Firefox') == -1 && navigator.userAgent.indexOf('Safari') == -1)
    {
        var calendar_div = document.getElementById('calendar_div');
        hide_select(parseInt(calendar_div.style.left), parseInt(calendar_div.style.top), parseInt(calendar_div.style.left) + parseInt(calendar_div.offsetWidth), parseInt(calendar_div.style.top) + parseInt(calendar_div.offsetHeight));
    }
}

