<?
	include "../../include/db/connect.php"; 

	if($childAge)
	{
		switch($childAge)
		{
			case "C":
				$year = date('Y') - 1; 
				//$whereAnd .= " && childBirth like ('$year%') && '".date('Y-m-d')."' < childBirth ";
				$whereAnd .= " && left(childBirth,4)='".$year."' ";
				break;

			case "A":
				$year = date('Y') - $childAge; 
				//$whereAnd .= " && childBirth like ('$year%') && '".date('Y-m-d')."' < childBirth ";
				$whereAnd .= " && ('".date('Y-m-d')."' < childBirth or left(childBirth,4)='".$year."') ";
				break;
			
			case "Z":
				$year = date('Y'); 
				//$whereAnd .= " && childBirth like ('$year%') && '".date('Y-m-d')."' < childBirth ";
				$whereAnd .= " && (('".$year."-09-01' > childBirth and left(childBirth,4)='".$year."') or ('".substr($year,2,3)."0831' > left(childJumin,6) and left(childJumin,2)='".substr($year,2,3)."'))";
				break;

			default:
				$year = date('Y') - ($childAge); 
				$whereAnd .= " && (left(childBirth,4)='".$year."' or left(childJumin,2)='".substr($year,2,3)."')";
				break;
		}
	}
	
	if($childAge=="")
	{
		$columns = array(mbId, childName, childBirth, sex, parentName, class3, class1, class2, position1, position2, homeType, telephone, mobile, email, recordName, recordBirth, regdate, waittype);
	}
	else
	{
		$columns = array(mbId, childName, childBirth, sex, parentName, class3, class1, class2, position1, position2, homeType, telephone, mobile, email, recordName, recordBirth, regdate, waittype, idx);
	}
	$query	= "SELECT * FROM ona_application WHERE 1 $whereAnd ORDER BY class3 asc, class4 asc, regdate asc, idx asc";
	$result = mysql_query($query);

	if($childAge=="")
	{
		$content	 = "아이디, 자녀명, 생년월일, 성별, 부모명, 입소대상, 소속부처1, 소속부처2, 직위1, 직위2, 가정분류, 구내번호, 핸드폰번호, 이메일, 재원중형제명, 재원중형제 생년월일, 대기날짜, 입소희망년";
	}
	else
	{
		$content	 = "아이디, 자녀명, 생년월일, 성별, 부모명, 입소대상, 소속부처1, 소속부처2, 직위1, 직위2, 가정분류, 구내번호, 핸드폰번호, 이메일, 재원중형제명, 재원중형제 생년월일, 대기날짜, 입소희망년, 순위";
	}
	$content .= "\r\n";

	$tmp_num = 1;

	while ($row=mysql_fetch_array($result)) {
		foreach($columns as $i=>$v) {

			if($v == "regdate") $row[$v] = @date('Y-m-d',$row[$v]);

			if($v == "childBirth")
			{
				if($row[$v]=='')
				{
					$row[$v] = "20".substr($row['childJumin'],0,2)."-".substr($row['childJumin'],2,2)."-".substr($row['childJumin'],4,2);
				}
			}

			if($v == "sex")
			{
				if($row[$v]=='1') { $row[$v] = "남"; }
				if($row[$v]=='2') { $row[$v] = "여"; }
			}

			if($v == "class3")
			{
				$tmp_app = '';

				if($row[$v] == '1')
				{
					$tmp_app = '국회 공무원';
				}
				else if($row[$v] == '2')
				{
					$tmp_app = '무기계약 근로자 및 직영후생시설 종사자';
				}
				else if($row[$v] == '3')
				{
					$tmp_app = '의원실 인턴 및 국회내 기간제 근로자 및 국회내 상주 정당관계자 및 6개월 이상 상시출입기자';
				}
				else if($row[$v] == '4')
				{
					$tmp_app = '국회내 상주업체 종사자';
				}
				else if($row[$v] == '5')
				{
					$tmp_app = '국회 보조금 지원받는 법인 및 단체 종사자';
				}

				$row[$v] = $tmp_app;
			}

			if($v == "homeType")
			{
				$tmp_ht = explode(",",$row[$v]);
				$tmp_hometype = '';
				$tmp_i = 0;
				foreach( $tmp_ht as $v)
				{
					if($tmp_i != 0) { $tmp_hometype .= ", "; }
					switch($v){
						case "0세" :
							$tmp_hometype .= "출생예정";
							break;
						case "a" :
							$tmp_hometype .= "한부모";
							break;
						case "b" :
							$tmp_hometype .= "저소득";
							break;
						case "c" :
							$tmp_hometype .= "부모장애";
							break;
						case "d" :
							$tmp_hometype .= "자녀의 형제장애";
							break;
						case "e" :
							$tmp_hometype .= "다문화 가정";
							break;
						case "f" :
							$tmp_hometype .= "조손가정";
							break;
						case "g" :
							$tmp_hometype .= "맞벌이";
							break;
						case "h" :
							$tmp_hometype .= "두자녀 및 세자녀";
							break;
						case "i" :
							$tmp_hometype .= "기타저소득(3,4층)";
							break;
						case "j" :
							$tmp_hometype .= "입양유아";
							break;
						case "k" :
							$tmp_hometype .= "재원형제";
							break;
						case "l" :
							$tmp_hometype .= "해당없음";
							break;
					}
					$tmp_i++;
				}
				
				$row[$v] = $tmp_hometype;
			}

			if($v == "waittype")
			{
				$waittype = '';
				if(strpos($row[$v],'14')===false){
				}
				else
				{
					$waittype .= '2014년 충원시';
				}

				if(strpos($row[$v],'15')===false){
				}
				else
				{
					if($waittype != '')
					{
						$waittype .= ', 2015년 신입학';
					}
					else
					{
						$waittype .= '2015년 신입학';
					}
				}

				$row[$v] = $waittype;
			} 
			
			if($childAge!="")
			{
				if($v == "idx")
				{
					$row[$v] = $tmp_num;
					$tmp_num++;
				}
			}

			if ($i==0) {
				$content .= "\"".$row[$v]."\"";
			} else {
				$content .= ",\"".$row[$v]."\"";
			}
		}
		$content .= "\r\n";
	}
$file_name = "대기자명단".date("Ymd");
if(eregi("msie", $_SERVER['HTTP_USER_AGENT']) && eregi("5\.5", $_SERVER['HTTP_USER_AGENT'])) {
    header("content-type: doesn/matter");
    header("content-length: ".strlen($content));
    header("content-disposition: attachment; filename=$file_name.csv");
    header("content-transfer-encoding: binary");
} else {
    header("content-type: file/unknown");
    header("content-length: ".strlen($content));
    header("content-disposition: attachment; filename=$file_name.csv");
    header("content-description: php generated data");
}
header("pragma: no-cache");
header("expires: 0");
echo $content;
?>