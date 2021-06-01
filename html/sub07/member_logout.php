<? 
	session_start(); 
	session_destroy();	
	session_start(); 
	$_SESSION["indexok"]="Y";
	echo " <script>
			   <!--
					//alert('로그아웃 되었습니다.');
					location.href='/assembly/';
				-->
			   </script>";
?>