<?

Function newUploadFile($updir, &$ofn, $bOverwrite = False) {
	if (!is_dir($updir)) return "";
	if (!$ofn[tmp_name]) return "";
	if (!$ofn[size]) return "";

	$fn = $ofn[name];
	$ext = substr(strrchr($fn, "."), 1);
	$ext = strtolower($ext);

	//=== Ȯ���� ���� (ũ�������� ȭ�ϸ� ����)
	if (eregi("exe|bat|com|inc|phtm|htm|shtm|php|php3|dot|asp|cgi|pl", $ext)) $fn .= ".tmp";

	$ext = substr(strrchr($fn, "."), 1);
	$ffn = substr($fn, 0, strlen($fn)-strlen($ext)-1);

	if ($bOverwrite) { //===== �����
		$newfn = $ffn;
	} else { //===== ���� ������ �ִٸ� ó��
		$fno = 0;
		$newfn = "$ffn";
		while (file_exists("$updir/$newfn.$ext")) {
			$fno++;
			$newfn = "$ffn($fno)";
		}
	}

	if (@move_uploaded_file($ofn[tmp_name], "$updir/$newfn.$ext")) {
		@chmod("$updir/$newfn.$ext", 0777);
		return "$newfn.$ext";
	} else {
		return "";
	}
}

	// ��� �̽������� ���
    function param($value){
        $value = htmlentities(trim($value), ENT_QUOTES, 'UTF-8');
        return $value;
    }

    // ���ڸ� ���� �տ� 0 ����
    function codeNumber($num){
       $strlength = strlen($num);
       if($strlength == "1"){
            $num = "0".$num;
       }
       return $num;
    }

    // �������� �� ����
    function save_Content( $content ){
        $url_1 = "=\\\"http://$_SERVER[SERVER_NAME]";
        $url_2 = "='http://$_SERVER[SERVER_NAME]";

        $content = str_replace($url_1,"=\"",$content );
        $content = str_replace($url_2,"='",$content );
        return $content;
    }

    function textKindChange($value){
        switch ($value){
            case 1:
                $returnValue = "<font color='blue'>����</font>";
                break;
            case 2:
                $returnValue = "����";
                break;
            case 3:
                $returnValue = "<font color='red'>��ũ</font>";
                break;
            case 4:
                $returnValue = "<font color='green'>DB��ũ</font>";
                break;
        }
        return $returnValue;
    }

    function parKindChange($value){
        switch ($value){
            case 1:
                $returnValue = "����ȯ��";
                break;
            case 2:
                $returnValue = "�����";
                break;
            case 3:
                $returnValue = "��������";
                break;
            case 4:
                $returnValue = "��ȣ�ۿ�";
                break;
            case 5:
                $returnValue = "�ǰ�������";
                break;
            case 6:
                $returnValue = "����";
                break;
            case 7:
                $returnValue = "����,������ȸ����";
                break;
            case 8:
                $returnValue = "����ȯ��,�����";
                break;
        }
        return $returnValue;
    }

    function txtOnline($value){
        switch ($value){
            case "N":
                $returnValue = "�̳�";
                break;
			case "Y":
                $returnValue = "<font color=#FF0000>���οϷ�</font>";
                break;
			case "E":
                $returnValue = "<font color=#0000FF>����</font>";
                break;
        }
        return $returnValue;
    }

    // �����ڸ���
    function trim_text($str, $len){

        if (strlen($str) < $len) return $str;

        $str = substr($str, 0, $len);
        $i = 0;

        while($len){
            $j = $str[--$len];
            if (!(chr(0x00) < $j && chr(0x7F) > $j)) $i++;
        }

        if ($i % 2) $str = substr($str, 0, -1);
            return $str .= '...';
    }

    // ��ũ��Ʈ
    function goBack($msg) {
        echo "
            <Script Language='JavaScript'>
            <!--
                alert('$msg');
                history.back();
            //-->
            </Script>";
        exit;
    }

    function goUrl($url) {
        echo "
            <Script Language='JavaScript'>
            <!--
                location.href='$url';
            //-->
            </Script>";
        exit;
    }

    function goMsg($msg) {
        echo "
            <Script Language='JavaScript'>
            <!--
                alert('$msg');
            //-->
            </Script>";
        exit;
    }

    function goMsgUrl($msg,$url) {
        echo "
            <Script Language='JavaScript'>
            <!--
                alert('$msg');
                location.href='$url';
            //-->
            </Script>";
        exit;
    }

    function pMsgUrl($msg,$url) {
        echo "
            <Script Language='JavaScript'>
            <!--
                alert('$msg');
                parent.location.href='$url';
            //-->
            </Script>";
        exit;
    }

    function check($msg){
        echo "
            <Script Language='JavaScript'>
            <!--
                alert('$msg');
            //-->
            </Script>";
        exit;
    }


    ## �޺��ڽ� Option ����Ʈ
function html_select($name,$value_text,$select = null,$sep=null)
{
    if(is_null($select)){
        if(eregi("[[]]",$name)){

        } else {
            eval("global \$$name;\$select=\$$name;");
        }
    }

    $return_html        = array();
    $return_html[]      = sprintf('<select name="%s" %s>',$name,$sep);
    foreach($value_text as $value=>$text){
        $selected = !strcmp($select,$value) ? ' selected' : '';

        $return_html[]  = sprintf('<option value="%s"%s>%s</option>',$value,$selected,$text);
    }
    $return_html[]      = '</select>';
    return implode(null,$return_html);
}

## �޺��ڽ� Option ����Ʈ size
function html_select2($name,$value_text,$select = null,$sep=null)
{
    if(is_null($select)){
        if(eregi("[[]]",$name)){

        } else {
            eval("global \$$name;\$select=\$$name;");
        }
    }

    $return_html        = array();
    $return_html[]      = sprintf('<select name="%s"%s style=width:160>',$name,$sep);
    foreach($value_text as $value=>$text){
        $selected = !strcmp($select,$value) ? ' selected' : '';

        $return_html[]  = sprintf('<option value="%s"%s>%s</option>',$value,$selected,$text);
    }
    $return_html[]      = '</select>';
    return implode(null,$return_html);
}

    ## �޺��ڽ� Option ����Ʈ
    function echo_combo_option($arVal, $arName, $sel )
    {
        for( $i = 0 ; $i < count($arVal) ; $i++ )
        {
            if( $arVal[$i] == $sel )
                echo ("<option value='$arVal[$i]' selected>$arName[$i]</option>");
            else
                echo ("<option value='$arVal[$i]'>$arName[$i]</option>");
        }
    }
    # üũ�ڽ� ����Ʈ
    function echo_checkbox( $obj, $val, $name, $sel )
    {
        if( $val == $sel )
            echo("<input name='$obj' type='checkbox' value='$val' checked> $name");
        else
            echo("<input name='$obj' type='checkbox' value='$val' > $name");
    }
    # üũ�ڽ� ����Ʈ
    function echo_radiobox( $obj, $val, $name, $sel )
    {
        if( $val == $sel )
            echo("<input name='$obj' type='radio' value='$val' checked> $name");
        else
            echo("<input name='$obj' type='radio' value='$val' > $name");
    }

    function view_Content( $content )
    {
        $content        = stripslashes($content);
        $content        = str_replace("<P>","",$content);
        $content        = str_replace("</P>","<br>",$content);
        return $content;
    }
    function view_Text( $content )
    {
        $content    = stripslashes($content);
        $content    = str_replace("<P>","",$content);
        $content    = str_replace("</P>","<br>",$content);
        $content    = str_replace("\r\n","<br>",$content);
        return $content;
    }
    function trim_script_text( $str, $len )
    {
        $str = trim_text(strip_tags( $str ),$len );
        $str = str_replace("'","`", $str );
        $str = str_replace("\"","`", $str );
        $str= str_replace("\r\n","<br>",$str);
        return $str;
    }

    /* �Խ��� ����¡ �ڵ� ����
        <table border='0' cellspacing='0' cellpadding='0'>
          <tr>
            <td style='padding:0 8 0 0;'>
              <a href='#' onfocus='this.blur();'><img src='../../images/btn/btn_pprev.gif' border='0' align='absmiddle' ></a>
              <a href='#' onfocus='this.blur();'><img src='../../images/btn/btn_prev.gif' border='0' align='absmiddle'></a>
            </td>
            <td class='page'><a href='#' class='page_n'>1</a><a href='#' class='page'>2</a><a href='#' class='page'>3</a><a href='#' class='page'>4</a><a href='#' class='page'>5</a><a href='#' class='page'>6</a></td>
            <td style='padding:0 0 0 8;'>
              <a href='#' onfocus='this.blur();'><img src='../../images/btn/btn_next.gif' border='0' align='absmiddle'></a>
              <a href='#' onfocus='this.blur();'><img src='../../images/btn/btn_nnext.gif' border='0' align='absmiddle'></a>
            </td>
          </tr>
        </table>
    */

    function common_paging( $url,$total_count,$page,$list_page,$page_count ){

        if($total_count >0){
            $totalPage  =   floor(($total_count-1)/$page_count) + 1;
            if (!$page || $page < 0) {  $page=1;}

            if ($page > $totalPage) {   $page=$totalPage;}

            $startNo    =   ($page - 1) * $page_count;
            $r_value[startno]   =   $startNo;

            $firstPage  =   floor(($page-1)/$list_page)*$list_page + 1;
            $lastPage   =   $firstPage  +   ($list_page - 1);

            if ($lastPage >= $totalPage)
            {
                $flag   =   'yes';
                $lastPage   =   $totalPage;
            }
			
			$r_value[paging] .= "<table cellpadding=0 cellspacing=0 border=0><tr><td>";
            if($firstPage != 1){
                $page_imsi = $firstPage - 1;
                $r_value[paging] .=   "<a href='$url&page=$page_imsi' onFocus='this.blur();'><img src='/images/btn/btn_pprev.gif' style='margin-right:6px' align='absmiddle'></a>";
            }
			$r_value[paging] .= "</td><td>";
            if($page != 1){
                $page_imsi  =   $page   -   1;
                $r_value[paging] .=  "<a href='$url&page=$page_imsi' onFocus='this.blur();'><img src='/images/btn/btn_prev.gif' style='margin-right:15px' align='absmiddle'></a>";
            }
			$r_value[paging] .= "</td><td style='padding:2 0 0 0'>";
            for ($i=$firstPage;$i<=$lastPage ;$i++){
                $j = $j+1;
                if($j !='1') $r_value[paging] .=   "|";
                if ($i==$page)  $r_value[paging] .=   "<span class='page_n'>$i</span>";
                else                $r_value[paging] .=   "&nbsp;<a href='$url&page=$i' onFocus='this.blur();'><span  style='page'>".$i."</span></a>&nbsp;";
            }
			$r_value[paging] .= "</td><td>";
            if($page != $totalPage){
                $page_imsi  =   $page   +   1;
                $r_value[paging] .=   "<a href='$url&page=$page_imsi' onFocus='this.blur();'><img src='/images/btn/btn_next.gif' style='margin-left:15px' align='absmiddle'></a>";
            }
			$r_value[paging] .= "</td><td>";
            if($flag != 'yes'){
                $page_imsi  =   $lastPage   +   1;
                $r_value[paging] .=   "<a href='$url&page=$page_imsi' onFocus='this.blur();'><img src='/images/btn/btn_nnext.gif' style='margin-left:6' align='absmiddle'></a>";
            }
			$r_value[paging] .= "</td></tr></table>";
            return $r_value;
        }
        else
            return '';

    }

// ����ó��
function File_Process($file,$file_name,$file_dir,$file_type,$old_file_name) {
	set_time_limit(0);
    global $uid;
    global $page;
    global $CodeType;
    global $SearchSelect;
    global $Keyword;
    global $check_passwd;

    if(!file_exists($file_dir)){
        mkdir($file_dir);
    }

    if ( $file ) { #������ ������츸

        $file_name = stripslashes($file_name);
        $file_name = ereg_replace("[[:space:]]","_",$file_name);
        $file_name = ereg_replace("#","",$file_name);
        $file_name = ereg_replace("%","",$file_name);

        $change_file_name = strtolower($file_name);
		
		$exp = explode('.',$file_name);

        if (
            ereg(".php",$change_file_name) ||
            ereg(".phtml",$change_file_name) ||
            ereg(".php3",$change_file_name) ||
            ereg(".php4",$change_file_name) ||
            ereg(".inc",$change_file_name) ||
			sizeof($exp) > 2
		   ) {

            if ( $file_type == "edit" ) {
                echo ("
                <form name=\"history_back\" action=\"edit.php\" method=\"post\">
                <input type=\"hidden\" name=\"uid\" value=\"$uid\">
                <input type=\"hidden\" name=\"page\" value=\"$page\">
                <input type=\"hidden\" name=\"CodeType\" value=\"$CodeType\">
                <input type=\"hidden\" name=\"SearchSelect\" value=\"$SearchSelect\">
                <input type=\"hidden\" name=\"Keyword\" value=\"$Keyword\">
                <input type=\"hidden\" name=\"passwd\" value=\"$check_passwd\">
                </form>
                <script>
                window.alert('�������� ���� ���� �����Դϴ�.');
                document.history_back.submit();
                </script>
                ");
            } else {
                echo("
                <script>
                window.alert('�������� ���� ���� �����Դϴ�.');
                history.back(-1)
                </script>"
                );
            }

            exit;
            return false;
        }
            $file_name = str_replace("htm","nohtm",$file_name);
            $file_name = str_replace("ph","noph",$file_name);
            $file_name = str_replace("pl","nopl",$file_name);
            $file_name = str_replace("jsp","nojsp",$file_name);
            $file_name = str_replace("asp","noasp",$file_name);
            $file_name = str_replace("html","nohtm",$file_name);
            $file_name = str_replace("java","nojava",$file_name);
        }

        if ($file_type == "edit" && $file_type != "del") { #���� ������ ���

        if ( $old_file_name ) { #������ ������ ���� ��츸 ����

            $img  = $file_dir."/".$old_file_name;
            @unlink($img);
            @exec("rm rf $img");

        }

    }

    if (  $file_type == "insert" && $file_type != "del" || $file_type == "edit" && $file_type != "del") { #���� �߰��� ������ ���

        if ($file) { // ������ ���� ��� ó���Ѵ�

            if($file_name){

                // ������ ���ϰ� �̸��� ���� ��� filename �� 2_filename �� ���� rename
                $now_count = 0;
                $echo_now_count = "";				

                #--- ���� ������ üũ -----------#
                /*
                $size = $file_size;
                if( $size > 10240000 ){
                echo "
                <script language='javascript'>
                alert(\"������ 5MB �̻� �Է��Ҽ� �����ϴ�.\");
                history.go(-1);
                </script>";
                exit;
                }
                */

                #--- ������� ���� ������ üũ ---#
				if($file_name != "tmp_img.jpg"){
					while( 1 ){
						$file_name = $exp[0].$echo_now_count.".".$exp[1]; // �����̸� ����
						if( !file_exists("$file_dir/$file_name") ) break;
						if( $now_count ) $now_count++; else $now_count=2;
						$echo_now_count = "(".$now_count.")";
					}
				}

                // ���Ϻ���
                if( !copy($file,"$file_dir/$file_name") ) {
                    echo "���� ���ε� ����, �Խ��ǿ�ڿ��� �˷��ֽʽÿ�";
                } else {
				chmod ("$file_dir/$file_name", 0777); 
				}

            }

        } #������� ������ ���� ��� ó��

    } # �߰� �� ����

    if ($file_type == "del") { #���� ������ ���

        if ( $old_file_name ) { #������ ������ ���� ��츸 ����

            $img  = $file_dir."/".$old_file_name;
            unlink($img);
            exec("rm rf $img");

        }

    }

    return $file_name;

}
#---------- ������� ���� ���μ��� ó�� ---------#

//2009.05.04 ����ϰ��� �Լ� �߰�(����ȣ)
/* �̹��� ũ�� ����
    getimagesize() : gif,jpg,png�̹����� ũ�⸦ ���Ѵ�. 4���� �迭�� ���ϵȴ�.
    0��°:�̹��� �ʺ�(�ȼ�����) 1��°: �̹��� ����
    2��°:�̹��� ����(1:gif,2:jpg,3:index)
    3��°:�̹��� �ʺ�� ���̸� html �Ӽ����� ������(height=xxx width=xxx)
*/
function ImageResize($ratio,$width,$height,$img,$alt,$property,$event) {
    define("Limit_Width",$width); // ���ϴ� ���α�� limit��
    define("Limit_Height",$height); // ���ϴ� ���α�� limit��

    $imgchk = $_SERVER["DOCUMENT_ROOT"] . $img;
    $imgsize = getimagesize($imgchk);
    //echo $imgchk . "<br>";
    //echo "width = $imgsize[0]  height = $imgsize[1]";
    if ( file_exists($imgchk) ) {
        $imgsize = getimagesize($imgchk);
    }else{
        echo "ȭ�� ��ġ�� ��Ȯ���� �ʽ��ϴ�.<br>";
        return "";
    }
    if ( ( $imgsize[0] > Limit_Width ) && ( $imgsize[1] > Limit_Height ) ){
        // ���� ����� ���� �� ���� �Ѵ� �Ѱ躸�� Ŭ��
        $sumw = ($ratio * Limit_Height)/$imgsize[1];
        $sumh = ($ratio * Limit_Width)/$imgsize[0];
        $img_width = ceil(($imgsize[0]*$sumw)/100);
        $img_height = ceil(($imgsize[1]*$sumh)/100);
        //$IMG_size = " height='$img_height' width='$img_width' ";
    } elseif ( $imgsize[1] > Limit_Height ) {
        // �Ѱ���̺��� Ŭ��
        $sumw = ($ratio * Limit_Height)/$imgsize[1];
        $img_width = ceil(($imgsize[0]*$sumw)/100);
        $img_height = Limit_Height;

        //$IMG_size = " height='$img_height' ";
    } elseif ( $imgsize[0] > Limit_Width ) {
        // �Ѱ���̺��� ������
        $sumh = ($ratio * Limit_Width)/$imgsize[0];
        $img_height = ceil(($imgsize[1]*$sumh)/100);
        $img_width = Limit_Width;
        //$IMG_size = " width='$img_width' ";
    } else {
        // �Ѵ� �Ѱ躸�� ������
        // limit���� ũ�� �ʴ� ���� ���� ������ �״��.....
        $img_width = $imgsize[0];
        $img_height = $imgsize[1];
        //$IMG_size = " height='$img_height' width='$img_width' ";
    }

    if($img_height > Limit_Height) $img_height = Limit_Height;
    if($img_width > Limit_Width) $img_width = Limit_Width;

    $IMG_size = " height='$img_height' width='$img_width' ";
/*
echo "img=$img<br>";
echo "img_width=$img_width<br>";
echo "img_height=$img_height<br>";
echo "IMG_size=$IMG_size<br>";

echo "<img src='$img' border='0' $IMG_size $alt $property $event>";
*/
    $re_img="<img src='$img' border='0' $IMG_size $alt $property $event>";
    return $re_img;
}

/*
�ѱ��ڸ��� �Լ�
$n : ǥ���� ���ڼ�(�ѱ��� ��� n = n/2, ������ ��� n=n
$cutstr: ���ڿ��� �߸��Ŀ� ���� ���ڿ�
*/
function StringCut($string,$n,$cutstr="...")  //$n : Cutting String Number
{
    if($n%2)
        $n++;
    $len=strlen($string);   //string length
    if($len<$n)
        return $string;
    else
    {
        $OneNextN=$n+1;
        $newstring=substr($string,0,$n);
        $total=0;
        for($i=0;$i<$n;$i++)
        {
            $asc=ord(substr($string,$i,1));
            if($asc>128)
                $total++;
        }
        if($total%2)
        {
            $newstring=substr($string,0,$OneNextN);
        }

        $newstring.=$cutstr;
        return $newstring;
    }
}




	function sqlArray( $sql, $idx='', $idx_array=false ) {
		$result = @mysql_query($sql);
		while( $row = @mysql_fetch_array($result) ) {
			if( $idx ) {
				if( $idx_array )	$data[$row[$idx]][] = $row;
				else				$data[$row[$idx]] = $row;
			}
			else $data[] = $row;
		}
		return $data;
	}

	function sqlRow( $sql ) {
		$result = @mysql_query($sql);
		$row = @mysql_fetch_array($result);
		return $row;
	}

	function sqlRowOne( $sql ) {
		$result = @mysql_query($sql);
		$row = @mysql_fetch_array($result);
		return $row[0];
	}
	function sqlArrayOne($sql) {
		$result = mysql_query($sql);
		while( $row = mysql_fetch_array($result) ) $data[] = $row[0];
		if(mysql_errno()){
			echo "<script>alert('������ �߻��Ͽ����ϴ�.');</script>";
			exit;
		}
		return $data;
	}
	
	// �˱����ⱳ�� ����ð�
	function chTime($v){
		switch($v){
			case 1: $v = "09:30";	break;
			case 2: $v = "10:00";	break;
			case 3: $v = "10:30";	break;
			case 4: $v = "11:00";	break;
			case 5: $v = "11:30";	break;
			case 6: $v = "12:00";	break;
			case 7: $v = "12:30";	break;
			case 8: $v = "01:00";	break;
			case 9: $v = "01:30";	break;
			case 10: $v = "02:00";	break;
			case 11: $v = "02:30";	break;
			case 12: $v = "03:00";	break;
			case 13: $v = "03:30";	break;
			case 14: $v = "04:00";	break;
			case 15: $v = "04:30";	break;
			case 16: $v = "05:00";	break;
			case 17: $v = "05:30";	break;				
		}
		return $v;
	}
?>