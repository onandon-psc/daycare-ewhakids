<?
	if($castle!="no") {
//		define("__CASTLE_PHP_VERSION_BASE_DIR__", "/home/ewhakids/public_html/castle-php/");
//		include_once(__CASTLE_PHP_VERSION_BASE_DIR__ . "/castle_referee.php");
	}

	function dbConnect($host, $user, $name, $passwd){
		$conn	= mysql_connect($host, $user, $passwd) or die("서버 연결에 실패 했습니다. 잠시 후 다시 시도 하세요");
		$err		= mysql_select_db($name, $conn);
			
		if(!$err){
			$errNo		= mysql_errno($conn);
			$errMsg	= mysql_error($conn);
			exit;
		}
		mysql_query("set names euckr", $conn);
		return $conn;
	}	

	$DB[host]	= "222.122.156.104";
	$DB[user]	= "ewhakids";
	$DB[name]	= "ewhakids";
	$DB[pwd]	= "~ewhakids";

	$db = dbConnect($DB[host],$DB[user],$DB[name],$DB[pwd]);
?>