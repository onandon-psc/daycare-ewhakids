<?
	include "../../include/global/config.php";
	//##########################################
	// �������� �����ֱ� ���� ���� ������
	//
	// $pno  ;  ������ ��ȣ ( ���� �߿��� ���ڰ� )
	//
	// $row_page ; $pno�� �̿��Ͽ� ���� ������ ���� ����
	//
	//##########################################

	//---------------------------------------
	//   ������ ���� ���
	//---------------------------------------
	$toDay = strtotime(date("Y-m-d"));
	/*
	$query = "SELECT * FROM ddm_page_count WHERE regdate='$toDay' && pno='$pno'";
	$result	= mysql_query($query);
	$row		= @mysql_fetch_array($result);

	if($row[pno]){
		$query = "UPDATE ddm_page_count SET count=count+1 WHERE regdate='$toDay' && pno='$pno'";
	}else{
		$query  ="INSERT INTO ddm_page_count (regdate,pno,count) VALUES ('$toDay','$pno','1')";
	}
	mysql_query($query);
	*/
	//---------------------------------------
	//   ȯ�� ���� ���
	//---------------------------------------

	//###  ������ Ÿ�� #####//
	$cPageType_Board = "1";         // Board Ÿ��
	$cPageType_Html	= "2";
	$cPageType_Link		= "3";
	$cPageType_Toys	= "4";          //�峭�������� ����
	$cPageType_Par		= "5";          //�������ڷ��

	//include "common.php";     // ���� �Լ�

	$indexKind = "2";

	//if ($pno=='080201') {echo "<script>alert('�ù����� ���Դϴ�. \\n\\nȸ�������� �Ұ����Ͻʴϴ�.');history.back();</script>";}
	//include "cls_db.php"  ;       // DB ���� �� �������

	if( empty($pno) ) $pno = "010101";

	if( !empty($pno) ) {
		if( !is_numeric( $pno ) ) goBack("[E001] ���ٿ���");
	}
	if( !empty($board_idx) ) {
		if( !is_numeric( $board_idx ) ) goBack("[E002] ���ٿ���");
	}

	if(!stristr($HTTP_HOST,"develop")){
	//	if(in_array(substr($pno,0,2),array("08"))){
	//			goBack("�غ����Դϴ�.");
	//	}
	}

	$pno_1 = substr($pno, 0, 2 );       // Depth1
	$pno_2 = substr($pno, 2, 2 );       // Depth2
	$pno_3 = substr($pno, 4, 2 );       // Depth3
	$pno_4 = substr($pno, 6, 2 );       // Depth4

	// 1.2 DB ���� üũ üũ
	$query	= "SELECT * FROM BOARD_MANAGER WHERE PNO='$pno'  AND LAST_YN='Y' AND USE_YN='Y' ";
	$result	= mysql_query($query);
	$row_page = @mysql_fetch_array($result);


	### ������ CSS �� ����ǥ ����.#######
	$depth01 = intval(substr($pno,0,2));
	$depth02 = intval(substr($pno,2,2));
	$depth03 = intval(substr($pno,4,2));
	$depth04 = intval(substr($pno,6,2));


	### ������ CSS �� ����ǥ ����.#######
	$csBdTitle  = " class='btitle$pno_1' ";
	$csBdLine   = " class='bline$pno_1' ";
	$csBdBack   = " class='bback$pno_1' ";
	$cContentWidth=676;


	#### DB ���̺� ���� ###############
	$table					= $row_page[TBLNAME];
	$boardHit_table	= "ddm_board_hit";
	$table_hit				= "board_hit";
	$table_comment	= "board_comment";
	$file_url					= "../../upload/board/";

	#### ���� ���� ###############
	$boardWriteBtn              = 0 ;           // ���� ��ư
	if( $_SESSION[member_id] ) {
		$boardWriteBtn          = 1;
		if( $row_page[BD_WRITE] == "9"  && $_SESSION[member_level] != '9' ) $boardWriteBtn = 0;
	}
	$boardReplyBtn              = 0;            // ��� ��ư
	if( $_SESSION[member_id] ) {
		$boardReplyBtn              = 1;
		if( $row_page[BD_WRITE] == "9"  && $_SESSION[member_level] != '9' ) $boardReplyBtn = 0;
		if( $row_page[BD_REPLY] == "N" ) $boardReplyBtn = 0;
	}
	$boardModifyBtn         = 0;            // ���� ��ư
	if( $_SESSION[member_id] ) {
		$boardModifyBtn         = 1;
		if( $row_page[BD_WRITE] == "9"  && $_SESSION[member_level] != '9' ) $boardModifyBtn = 0;
	}
	$boardDeleteBtn         = 0;            // ���� ��ư
	if( $_SESSION[member_id] ) {
		$boardDeleteBtn         = 1;
		if( $row_page[BD_WRITE] == "9"  && $_SESSION[member_level] != '9' ) $boardDeleteBtn = 0;
	}
	$boardSecu				    = 0;
	if( $row_page[BD_SECU] =="Y" )  $boardSecu                  = 1;
	$boardFileNum				= $row_page[BD_FILE];                                                                           // ÷������ ����
	$boardPreNext				= 0 ;       if( $row_page[BD_PRENEXT] == "Y" )  $boardPreNext   = 1;       // ����/������ ǥ�� ����
	$boardComment			= 0 ;       if( $row_page[BD_COMMENT] == "Y" )  $boardComment   = 1;   // ��� ��뿩��
	$boardListNum				= $row_page[BD_LIST];                                                                          // ���� ����Ʈ Row ��

	$boardTab					= $row_page[TAB_FILE];                                                                         // Tab �޴�����
	$boardStyle					= $row_page[BOARDKIND];                                                                     // �Խ��� ��Ÿ��

	$boardViewClick  = 1;       // View Ŭ�� ����
	if( $row_page[BD_VIEW] > "0" && !$_SESSION[member_id] ) {
		$boardViewClick = 0;
		$boardViewScript ="alert('�α����� �Ͻñ� �ٶ��ϴ�.');";
	}

	$week_arr = array("<span style='color:red'>��</span>", "��", "ȭ", "��", "��", "��", "<span style='color:blue'>��</span>");

	//echo $_SESSION['masterSession']."*";
	#### ������ ��Ŭ��� ###############
?>