<?php
function createGeoJSON($coordPart){
    $parts = explode('/', $coordPart);
    if(count($parts) <= 0)
        return 0;
    if(count($parts) == 1)
        return $parts[0];
    return floatval($parts[0]) / floatval($parts[1]);
}



function gps2Num($coordPart){
    $parts = explode('/', $coordPart);
    if(count($parts) <= 0)
        return 0;
    if(count($parts) == 1)
        return $parts[0];
    return floatval($parts[0]) / floatval($parts[1]);
}


function get_image_location($image = ''){
    $exif = exif_read_data($image, 0, true);
    if($exif && isset($exif['GPS'])){
        $str = explode("|",  $exif['IFD0']['ImageDescription']);
        $str = array_combine( array('project', 'long','lat', 'azimuth', 'zenith', 'timestamp', 'accuracy', 'uid'),  $str);
        return $str;
    }else{
        return false;
    }
}

function getDirContents($dir, &$results = array()) {
    $files = scandir($dir);


    foreach ($files as $key => $value) {

        $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
        $dirn = basename($path);

        if(is_file($path)){
            $dirn = basename(dirname($path));
        }

        if( !isset( $results[$dirn ]) ){
            $results[$dirn ]=array();
        }

        if (!is_dir($path)) {
            $results[ $dirn ][] = substr($path, strlen(getcwd())+1) ;
        } else if ($value != "." && $value != "..") {
            getDirContents($path, $results);
           // $results[$dirn][] = $path;
        }
    }

    return $results;
}