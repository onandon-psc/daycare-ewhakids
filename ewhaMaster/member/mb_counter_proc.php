<?
include "../../include/global/config.php"; 
include "../../include/global/sendmail.class.php"; 

if ($act=="initlog") {
	$actstr = "접속통계 초기화";

	mysql_query("DELETE FROM gs_counter");
	mysql_query("DELETE FROM gs_counter_ref");
	$sql = "DELETE FROM gs_counter_ref_rank";

	$url = "mb_counter.php";

} elseif ($act=="initref") {
	$actstr = "접속경로 초기화";

	$sql = "DELETE FROM gs_counter_ref";
	$url = "mb_counter.php?mode=referer&reftype=all";

} else {
	echo "<script>alert('잘못된 접속통계 관리입니다.');</script>";
	exit;
}

mysql_query($sql);
if (mysql_error()) {
	echo "<script>alert('접속통계 작업 오류입니다.');</script>";
	exit();

} else {
	echo "<script>location.href = '$url';</script>";
}
?>