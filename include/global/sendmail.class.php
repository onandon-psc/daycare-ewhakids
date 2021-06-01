<?php 

class Sendmail 
{ 
    /* 
     * ���Ϲ߼��� ���� Ŭ���� 
     * �ܺ� SMTP ������ �����մϴ�. 
     * Author: Gwangsoo, Ryu (piver@ineemail.com) 
     */ 
     
    protected $UseSMTPServer = false;            // �ٸ� SMTP ������ �̿��� ��� 
    protected $SMTPServer;                        // SMTP ���� ������ 
    protected $SMTPPort = 25;                    // Port 
    protected $SMTPAuthUser;                    // SMTP ���� ����� 
    protected $SMTPAuthPasswd;                    // SMTP ���� ��й�ȣ 
    protected $Socket; 
     
    protected $MailHeaderArray = array();        // ��������� ���� �迭 
     
    protected $MailFrom;                        // ������ ��� 
    protected $ReplyTo;                            // ȸ�Ź��� �ּ� (�⺻������ ������ �����ּҰ� �ȴ�) 
    protected $MailTo = array();                // �޴� ����� ���� �迭 
     
    protected $Subject;                            // �������� 
    protected $MailBody;                        // ���Ϻ��� 
    protected $Charset = 'EUC-KR';                // ���ϱ⺻ ĳ���ͼ� 
    protected $Attach = array();                // ���ڵ��� ÷������ 
     
    protected $Boundary;                        // Bound 
     
    public function __construct($charset = 'EUC-KR') 
    { 
        $this->Boundary = md5(uniqid(microtime()));            // �ٿ�带 �ʱ�ȭ�Ѵ� 
        if(!empty($charset)) $this->Charset = $charset;        // ĳ���ͼ� 
    } 
     
    public function setFrom($email, $name = null) 
    { 
        // ������ ���� 
        $this->setReplyTo($email); 
        return $this->MailFrom = ($name) ? $name . ' <' . $email . '>' : $email; 
    } 
     
    public function setReplyTo($email) 
    { 
        // ȸ���ּ� - �⺻������ ������ ������ ȸ���ּҷ� ���Ѵ� 
        return $this->ReplyTo = $email; 
    } 
     
    public function setSubject($Subject) 
    { 
        // ���� 
        return $this->Subject = $Subject; 
    } 
     
    public function addTo($email, $name = null) 
    { 
        // �޴� ������ �߰��Ѵ� 
        return $this->MailTo[$email] = $name; 
    } 
     
    public function addAttach($Filename, $Source) 
    { 
        // ÷�������� �߰��Ѵ� 
        $fp = fopen($Source, 'r');        // �ҽ������� ���� 
        if($fp) { 
            $fBody = fread($fp, filesize($Source));        // ������ ������ �о�´� 
            @fclose($fp); 
             
            $this->Attach[$Filename] = $fBody;            // Attach �迭�� ��´� 
        } 
    } 
     
    public function setMailBody($Body, $useHtml = true) 
    { 
        if(!$useHtml) {        // ���Ϻ����� HTML ������ �ƴϸ� HTML �������� �ٲپ��ش� 
            $Body = ' 
                <html> 
                    <head> 
                        <meta http-equiv="Content-Type" content="text/html; charset=' . $this->Charset . '"> 
                        <style type="text/css"> 
                            BODY, TH, TD, DIV, SPAN, P, INPUT { 
                                font-size:12px; 
                                line-height:17px; 
                            } 
                            BODY, DIV { text-align:justify; } 
                        </style> 
                    </head> 
                     
                    <body> 
                        ' . nl2br($Body) . ' 
                    </body> 
                </html> 
            '; 
        } 
         
        $this->MailBody = $Body;        // ���Ϻ����� ���Ѵ� 
    } 
     
    protected function AddBasicHeader() 
    { 
        // ������ �⺻ ����� �ۼ��Ѵ� 
        $this->addHeader('From', $this->MailFrom); 
        $this->addHeader('User-Agent', 'Dabuilder Mail System'); 
        $this->addHeader('X-Accept-Language', 'ko, en'); 
        $this->addHeader('X-Sender', $this->ReplyTo); 
        $this->addHeader('X-Mailer', 'PHP'); 
        $this->addHeader('X-Priority', 1); 
        $this->addHeader('Reply-to', $this->ReplyTo); 
        $this->addHeader('Return-Path', $this->ReplyTo); 
         
        if(count($this->Attach) > 0) {        // ÷�������� ���� ����� ��� 
            $this->addHeader('MIME-Version', '1.0'); 
            $this->addHeader('Content-Type', 'Multipart/mixed; boundary = "' . $this->Boundary . '"'); 
        } else {        // ÷�������� ���� �Ϲ� ������ ����� ��� 
            $this->addHeader('Content-Type', 'text/html; charset=' . $this->Charset); 
            $this->addHeader('Content-Transfer-Encoding', '8bit'); 
        } 
    } 
     
    protected function addHeader($Content, $Value) 
    { 
        // ��������� ������ �߰��Ѵ� 
        $this->MailHeaderArray[$Content] = $Value; 
    } 
     
    protected function MailAttach() 
    { 
        // ÷�������� ���� ��� ���Ϻ����� ÷�������� �����δ� 
        $arrRet = array(); 
         
        if(count($this->Attach) > 0) { 
            foreach($this->Attach as $Filename => $fBody) { 
                $tmpAttach = "--" . $this->Boundary . "\r\n"; 
                $tmpAttach .= "Content-Type: application/octet-stream\r\n"; 
                $tmpAttach .= "Content-Transfer-Encoding: base64\r\n"; 
                $tmpAttach .= "Content-Disposition: attachment; filename=\"" . $Filename . "\"\r\n\r\n"; 
                $tmpAttach .= $this->encodingContents($fBody) . "\r\n\r\n"; 
                 
                $arrRet[] = $tmpAttach; 
            } 
        } 
         
        return implode('', $arrRet); 
    } 
     
    public function setUseSMTPServer($boolean = null) 
    { 
        // �ܺ� SMTP ������ �̿��� �������� ���Ѵ� 
        return (is_null($boolean)) ? $this->UseSMTPServer : $this->UseSMTPServer = $boolean; 
    } 
     
    public function setSMTPServer($smtpServer = null, $port = 25) 
    { 
        // �ܺ� SMTP ������ �̿��� ��� SMTP ������ �����Ѵ� 
        $this->SMTPPort = $port; 

		return (is_null($smtpServer)) ? $this->SMTPServer : $this->SMTPServer = $smtpServer; 
    } 
     
    public function setSMTPUser($User = null) 
    { 
        // �ܺ� SMTP ������ �̿��� ��� �α��� ����ڸ� �����Ѵ� 
        return (is_null($User)) ? $this->SMTPAuthUser : $this->SMTPAuthUser = $User; 
    } 
     
    public function setSMTPPasswd($Passwd = null) 
    { 
        // �ܺ� SMTP ������ �̿��� ��� �α��� ��й�ȣ�� �����Ѵ� 
        return (is_null($Passwd)) ? $this->SMTPAuthPasswd : $this->SMTPAuthPasswd = $Passwd; 
    } 
     
    protected function encodingContents($contets) 
    { 
        // ���Ϻ����� ���ڵ��ϴ� ������ �Ѵ� 
        return chunk_split(base64_encode($contets)); 
    } 
     
    protected function makeMailHeader() 
    { 
        // ���� ������ ����� �ۼ��Ѵ� 
        $header = ""; 
        foreach($this->MailHeaderArray as $Key => $Val) 
            $header .= $Key . ": " . $Val . "\r\n"; 
         
        return $header . "\r\n"; 
    } 
     
    public function send() 
    { 
        // ������ �����Ѵ� 
        $this->AddBasicHeader();        // ������ �⺻����� �����Ѵ� 
         
        if($this->UseSMTPServer) return $this->_SMTPSend();        // �ܺ� SMTP ������ �̿��� ��� 
        else return $this->_localSend();                        // ���� SMTP �� �̿��� ��� 
    } 
     
    protected function _SMTPSend() 
    { 
        /* 
         * �ܺ� SMTP ������ �̿��� ��� ���������� ���ؼ� ������ �����Ѵ� 
         */ 
        $Succ = 0; 
         
        if($this->SMTPServer) { 
            $this->addHeader('Subject', $this->Subject);        // ��������� ������ �߰��Ѵ� 
            $MailBody = $this->makeMailBody();                    // ���Ϻ����� �����Ѵ� 
             
            if(count($this->MailTo) > 0) {            // �޴� ������ ������ ���� �۾��� �ݺ��Ѵ� 
                foreach($this->MailTo as $Email => $Name) { 
                    $mailTo = ($Name) ? $Name . ' <' . $Email . '>' : $Email;    // �޴»�� 
                    $this->addHeader('To', $mailTo);            // ��������� �޴»���� �߰��Ѵ� 
                     
                    $Contents = $this->makeMailHeader() . "\r\n" . $MailBody;    // ��������� ������ �̿��� ������ ������ �����Ѵ� 

                    $this->Socket = fsockopen($this->SMTPServer, $this->SMTPPort);            // ���������Ѵ� 
                    if($this->Socket) { 
                        $this->_sockPut('HELO ' . $this->SMTPServer); 
                        if($this->SMTPAuthUser) {                                // SMTP ���� 
                            $this->_sockPut('AUTH LOGIN'); 
                            $this->_sockPut(base64_encode($this->SMTPAuthUser)); 
                            $this->_sockPut(base64_encode($this->SMTPAuthPasswd)); 
                        } 
                        $this->_sockPut('MAIL FROM: ' ."<".$this->ReplyTo.">");            // ������ ���� 
                        $this->_sockPut('RCPT TO: '  . "<" . $Email . ">");                    // �޴¸��� 
                        $this->_sockPut('DATA'); 
                        $this->_sockPut($Contents);                                // ���ϳ��� 
                        $Result = $this->_sockPut('.');                            // ���ۿϷ� 
                        if(strpos($Result, 'Message accepted for delivery') !== false) $Succ++;        // ���������Ǵ� 
                        $this->_sockPut('QUIT');                // �������� 
                    } 
                } 
            } 
        } else $Succ = $this->_localSend();            // �ܺ� SMTP ������ �̿����� ������ ���� SMTP�� �̿��ؼ� �����Ѵ� 
         echo "Succ".$Succ;

        return $Succ; 
    } 
     
    protected function _sockPut($str) 
    { 
        // �������ӽ� �������� �� ����� �ޱ� 
        fputs($this->Socket, $str . "\r\n"); 
		$rtn=fgets($this->Socket, 512);
		echo $str . "[rtn:".$rtn ."]\r\n";

        return $rtn; 
    } 
     
    protected function _localSend() 
    { 
        $Contents = $this->makeMailBody();        // ���Ϻ����� �ۼ��Ѵ� 
         
        $Succ = 0; 
        foreach($this->MailTo as $Email => $Name) { 
            $toMail = ($Name) ? $Name . ' <' . $Email . '>' : $Email;    // �޴¸��� 
            $this->addHeader('To', $toMail);                            // ��������� �޴¸����� �߰��Ѵ� 
            $header = $this->makeMailHeader();                            // ����� �ۼ��Ѵ� 
             
            if(mail($Email, $this->Subject, $Contents, $header)) $Succ++;    // �������� �Ǵ� 
        } 
         
        return $Succ; 
    } 
     
    protected function makeMailBody() 
    { 
        // ������ ������ �ۼ��Ѵ� 
        $mailbody = ""; 
         
        if(count($this->Attach) > 0) {            // ÷�������� ���� ��� ������ ���ڵ��Ͽ� ����� 
            $mailbody .= "--" . $this->Boundary . "\r\n"; 
            $mailbody .= "Content-Type: text/html; charset=" . $this->Charset . "\r\n"; 
            $mailbody .= "Content-Transfer-Encoding: base64\r\n\r\n"; 
            $mailbody .= $this->encodingContents($this->MailBody) . "\r\n\r\n"; 
            $mailbody .= "\r\n" . $this->MailAttach(); 
        } else $mailbody = $this->MailBody;        // ÷�������� ������ �׳� HTML �������� ���Ϻ����� �����Ѵ� 
         
        return $mailbody; 
    } 
} 

?>