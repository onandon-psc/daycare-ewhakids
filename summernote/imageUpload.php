<?
@extract($_GET); @extract($_POST); @extract($_SERVER); @extract($_FILES);
if ($_FILES['file']['name']) {
    if (!$_FILES['file']['error']) {
        if ($_FILES['file']['type'] == 'image/jpeg') $fileExt = 'jpg';
        else if ($_FILES['file']['type'] == 'image/png') $fileExt = 'png';
        else if ($_FILES['file']['type'] == 'image/gif') $fileExt = 'gif';
        else {
            echo json_encode(array('path' => '지원하지 않는 이미지 형식입니다:::'.$_FILES['file']['type']));;
            exit;
        }
        $newfilename = round(microtime(true)).'.'.$fileExt;
        $tmpNum = 1;
        while (file_exists($_SERVER["DOCUMENT_ROOT"].'/summernote/attach/'.$newfilename)) {
            $newfilename = round(microtime(true)).$tmpNum.'.'.$fileExt;
            $tmpNum++;
        }
        $destinationFilePath = $_SERVER["DOCUMENT_ROOT"].'/summernote/attach/'.$newfilename;
        $upload = move_uploaded_file($_FILES['file']['tmp_name'], $destinationFilePath);
        if (!$upload) {
            echo json_encode(array('path' => $errorImgFile));
        }
        else{
            $destinationFilePath = explode($_SERVER["DOCUMENT_ROOT"], $destinationFilePath);
            echo json_encode(array('path' => $destinationFilePath[1]));
        }
    }
    else {
        echo  $message = '파일 에러 발생!: ' . $_FILES['file']['error'];
    }
}
?>