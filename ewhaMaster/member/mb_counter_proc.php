<?
include "../../include/global/config.php"; 
include "../../include/global/sendmail.class.php"; 

if ($act=="initlog") {
	$actstr = "������� �ʱ�ȭ";

	mysql_query("DELETE FROM gs_counter");
	mysql_query("DELETE FROM gs_counter_ref");
	$sql = "DELETE FROM gs_counter_ref_rank";

	$url = "mb_counter.php";

} elseif ($act=="initref") {
	$actstr = "���Ӱ�� �ʱ�ȭ";

	$sql = "DELETE FROM gs_counter_ref";
	$url = "mb_counter.php?mode=referer&reftype=all";

} else {
	echo "<script>alert('�߸��� ������� �����Դϴ�.');</script>";
	exit;
}

mysql_query($sql);
if (mysql_error()) {
	echo "<script>alert('������� �۾� �����Դϴ�.');</script>";
	exit();

} else {
	echo "<script>location.href = '$url';</script>";
}
?>