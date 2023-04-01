<?php

header('Content-type: application/json');

if( !isset($_POST['file'])  ){
    echo json_encode( array("error"=> " File name not provided !"));
    exit(-1);
}


if(is_file($file)){
    if(unlink(realpath($file))){
        echo json_encode( array("ok"=> " File  ".$_POST['file']." deleted."));
        exit(-1);
    }
    echo json_encode( array("error"=> " Was not able to delete ".$_POST['file']."!"));
    exit(-1);
} else {
    if( !isset($_POST['file'])  ){
        echo json_encode( array("error"=> " File path ".$_POST['file']." not found!"));
        exit(-1);
    }
}
