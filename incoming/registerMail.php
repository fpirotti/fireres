<?php


function registerMail($image = ''){
    $lut =  array();
    if(file_exists("lut.json")){
        $lut =  json_decode(file_get_contents("lut.json"), true  );
    }
    $host = "{imap.gmail.com:993/ssl/novalidate-cert}geocatch_fireres";
    $mailbox = imap_open($host, "fpirotti@gmail.com",
        "iflyrqldjkpdzobc");
    if($mailbox===false){
        return false;
    }
    $mailboxes = imap_list($mailbox, $host, '*');
    $mail = imap_search($mailbox, "SUBJECT 'geocatchappid'");
    if($mail===false){
        return false;
    }

    foreach ($mail as $key => $val){
        $mail_headers = imap_headerinfo($mailbox, $val);
        $from = $mail_headers->fromaddress;
        $subject = $mail_headers->subject;
        $mailAndId = explode("-", $subject)  ;
        $lut[ $mailAndId[1]  ]=  $from;
    }
    file_put_contents("lut.json", json_encode($lut, JSON_PRETTY_PRINT));
    chmod("lut.json", 0777);
    file_put_contents("lut.js", "validUsers = " . json_encode($lut, JSON_PRETTY_PRINT) . ";" );
    chmod("lut.js", 0777);

    imap_close($mailbox);

    return(count($lut));

}
?>