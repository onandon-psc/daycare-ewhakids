<!-- include libraries(jQuery, bootstrap) -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<!--<link rel="stylesheet" href="//bootswatch.com/3/paper/bootstrap.css">-->
<!-- include summernote css/js -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<?

class summernote {

    private $editorId;
    private $editorScriptId;
    private $editorFormName;
    private $editorWidth;
    private $editorHeight;

    function summernote ($Id, $Width, $Height, $FormName) {
        $this->editorId = $Id;
        $this->editorScriptId = "summer_".$this->editorId;
        $this->editorWidth = $Width;
        $this->editorHeight = $Height;
        $this->editorFormName = $FormName;
    }

    function SHOW ($oldContent) {
        $tmpSelector = "img[data-filename~='\"";
        $tmpSelector .= "+info.fileNm+\"";
        $tmpSelector .= "']";
        echo "<textarea id=\"".$this->editorScriptId."\" name=\"".$this->editorId."\">$oldContent</textarea>";
        echo "<script>";
        echo "
            var list = new Array();

            var base64ToBlob = function(base64Data, contentType, sliceSize) {
                contentType = contentType || '';
                sliceSize = sliceSize || 512;
        
                var byteCharacters = atob(base64Data);
                var byteArrays = [];
        
                for (var offset = 0; offset < byteCharacters.length; offset += sliceSize) {
                    var slice = byteCharacters.slice(offset, offset + sliceSize);
        
                    var byteNumbers = new Array(slice.length);
                    for (var i = 0; i < slice.length; i++) {
                        byteNumbers[i] = slice.charCodeAt(i);
                    }
        
                    var byteArray = new Uint8Array(byteNumbers);
                    byteArrays.push(byteArray);
                }
        
                var blob = new Blob(byteArrays, { type: contentType });
        
                return blob;
            }
            $(document).ready(function() {
                $('form').submit(function (e){
                    list.forEach(function(info){
                        var formData = new FormData();
                        var t = \"".$tmpSelector."\";
                        var imgSrc =$(t).attr('src');
                        var block = imgSrc.split(';');
                        var contentType = block[0].split(':')[1];
                        var realData = block[1].split(',')[1];
                        var blob = base64ToBlob(realData, contentType);
                        formData.append('file', blob);
                        formData.append('imgType', contentType);
        
                        $.ajax({
                            url : '/summernote/imageUpload.php',
                            type: 'POST',
                            data: formData,
                            dataType: 'json',
                            async: false,
                            cache: false,
                            contentType: false,
                            processData: false,
                            success: function (data) {
                                $(t).attr('src', 'http://ewhakids.or.kr'+data.path);
                                $('#".$this->editorScriptId."').summernote('code', $('#".$this->editorScriptId."').summernote('code'));
                            },
                            error: function (error) {
                                console.log(error);
                            }
                        });
                    });
                });
                $('#".$this->editorScriptId."').summernote({
                    height: ".$this->editorHeight.",
                    width: ".$this->editorWidth.",
                    maxHeight: ".$this->editorHeight.",
                    maxWidth: ".$this->editorWidth.",
                    minHeight: ".$this->editorHeight.",
                    minWidth: ".$this->editorWidth.",
                    lang : 'ko-KR',
                    toolbar: [
                      ['style', ['style']],
                      ['font', ['bold', 'underline', 'clear']],
                      ['fontname', ['fontname']],
                      ['color', ['color']],
                      ['table', ['table']],
                      ['insert', ['link', 'picture', 'video']],
                      ['view', ['fullscreen']],
                    ],
                    callbacks: {
                        onChange: function(contents) {
                            contents = contents.split(/\bdata-filename=\"/);
                            contents.forEach(function (info, index){
                                var imgName = info.split('\"');
                                if (index == contents.length-1) {
                                    list.push({fileNm: imgName[0]});
                                }
                            })
                        }
                    }
                });
                return false;
            });
            ";
        echo "</script>";
    }
    function BSEND($checkContent=false){
        echo "var html_value = $('#".$this->editorScriptId."').summernote('code');";
        if($checkContent){
            echo "if(!html_value || $('#".$this->editorScriptId."').summernote('code')=='<p><br></p>'){alert('내용을 입력해 주세요'); $('#".$this->editorScriptId."').summernote('focus'); return false;}";
        }
    }

}


?>