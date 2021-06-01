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
		$content	 = "���̵�, �ڳ��, �������, ����, �θ��, �ԼҴ��, �ҼӺ�ó1, �ҼӺ�ó2, ����1, ����2, �����з�, ������ȣ, �ڵ�����ȣ, �̸���, �����������, ��������� �������, ��⳯¥, �Լ������";
	}
	else
	{
		$content	 = "���̵�, �ڳ��, �������, ����, �θ��, �ԼҴ��, �ҼӺ�ó1, �ҼӺ�ó2, ����1, ����2, �����з�, ������ȣ, �ڵ�����ȣ, �̸���, �����������, ��������� �������, ��⳯¥, �Լ������, ����";
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
				if($row[$v]=='1') { $row[$v] = "��"; }
				if($row[$v]=='2') { $row[$v] = "��"; }
			}

			if($v == "class3")
			{
				$tmp_app = '';

				if($row[$v] == '1')
				{
					$tmp_app = '��ȸ ������';
				}
				else if($row[$v] == '2')
				{
					$tmp_app = '������ �ٷ��� �� �����Ļ��ü� ������';
				}
				else if($row[$v] == '3')
				{
					$tmp_app = '�ǿ��� ���� �� ��ȸ�� �Ⱓ�� �ٷ��� �� ��ȸ�� ���� ��������� �� 6���� �̻� ������Ա���';
				}
				else if($row[$v] == '4')
				{
					$tmp_app = '��ȸ�� ���־�ü ������';
				}
				else if($row[$v] == '5')
				{
					$tmp_app = '��ȸ ������ �����޴� ���� �� ��ü ������';
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
						case "0��" :
							$tmp_hometype .= "�������";
							break;
						case "a" :
							$tmp_hometype .= "�Ѻθ�";
							break;
						case "b" :
							$tmp_hometype .= "���ҵ�";
							break;
						case "c" :
							$tmp_hometype .= "�θ����";
							break;
						case "d" :
							$tmp_hometype .= "�ڳ��� �������";
							break;
						case "e" :
							$tmp_hometype .= "�ٹ�ȭ ����";
							break;
						case "f" :
							$tmp_hometype .= "���հ���";
							break;
						case "g" :
							$tmp_hometype .= "�¹���";
							break;
						case "h" :
							$tmp_hometype .= "���ڳ� �� ���ڳ�";
							break;
						case "i" :
							$tmp_hometype .= "��Ÿ���ҵ�(3,4��)";
							break;
						case "j" :
							$tmp_hometype .= "�Ծ�����";
							break;
						case "k" :
							$tmp_hometype .= "�������";
							break;
						case "l" :
							$tmp_hometype .= "�ش����";
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
					$waittype .= '2014�� �����';
				}

				if(strpos($row[$v],'15')===false){
				}
				else
				{
					if($waittype != '')
					{
						$waittype .= ', 2015�� ������';
					}
					else
					{
						$waittype .= '2015�� ������';
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
$file_name = "����ڸ��".date("Ymd");
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