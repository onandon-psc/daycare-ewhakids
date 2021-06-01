<?
$current_index = 'client';
include '../../include/global/inc_sub01.php';


if( (ereg("04",$pno) && $row_page[CATE1]=="유아마당") || ereg("050103|050201|050301|010301",$pno) )
{
	if(!$_SESSION['member_level'])
	{
?>
	<script language="javascript">
		  if(confirm('회원만 이용할 수 있습니다.\n로그인 하시겠습니까?')){
			  location.href = "/html/sub/index.php?pno=070101";	
		  }else{
			  location.href = "/assembly/";				  
		  }
	  </script>
<?
	}
	if($_SESSION['member_level'] == "R")
	{
		echo "<script language='javascript'>
					  alert('정회원만 이용 할 수 있습니다.');
					  location.href = '/assembly/';
				  </script>";
	}

}
include "../../include/html/top.php"; //   top	

// TAB
if( substr($pno,0,4)=="0501" )
{
	echo "<table width='655' cellspacing='0' cellpadding='0'>
				<tr>
				  <td>";
					@include "../../html/tab/".substr($pno,0,4).".htm"; // tab
	echo  "   </td>
				 </tr>
			   </table>";
}
else
{
	if( substr($pno,6,2)=="03" && (substr($pno,0,6)=="020201" || substr($pno,0,6)=="020202" || substr($pno,0,6)=="020203" || substr($pno,0,6)=="020204" || substr($pno,0,6)=="020205" || substr($pno,0,6)=="020207")  || substr($pno,0,6)=="020206") $tabPno = "0202";
	else $tabPno = substr($pno,0,6);
	@include "../../html/tab/".$tabPno.".htm"; // tab
}


include '../../include/global/inc_sub02.php';


include "../../include/html/footer.php";	// bottom

?>