<?
	if( $msChk && !$_SESSION['masterSession'] ){
		echo"<script language='javascript'>
				 <!--
					alert('로그아웃 되었습니다.');
					parent.location.href='/ewhaMaster/';
				  //-->
				 </script>";
	}
?>