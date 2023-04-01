<?php

    require("functions.php");
    include("registerMail.php");
    $nMailValid = registerMail();
    $tot="  ";
	$feature = ' {
		"type": "Feature",
		"properties": {
			"project": "%s",
			"uid": "%s",  
			"accuracy": "%s",
			"azimuth": "%s",
			"zenith": "%s",  
			"date": "%s",  
			"path": "%s"
		},
		"geometry": {
			"type": "Point",
			"coordinates": [ %f, %f]
		}
	} ';
	$features = array();
    $files1 = getDirContents("./imgs/") ;
    $maxx =0;
    $maxy =0;
    $miny=99999;
    $minx=99999;
    $layergroups = [];
    $projects = [];
    $errors = [];
    foreach ($files1 as $key => $filec){

        if(count($filec)>0){

            $tot= $tot . PHP_EOL;
            foreach ($filec as $file){
                $fl = get_image_location($file);

                if($fl===false){
                    echo $file . " no location<br>";
                    continue;
                }

                $lat = floatval($fl["lat"]);
                $lng = floatval($fl["long"]);


                if($lat == 0 && $lng==0 ){
                    $errors[] = $file;
                    unlink($file);
                    continue;
                }

                if($lat > $maxy) $maxy = $lat;
                if($lat < $miny) $miny = $lat;
                if($lng > $maxx) $maxx = $lng;
                if($lng < $minx) $minx = $lng;

				$ddd =date('Y-m-dTH:i:s', floatval($fl["timestamp"])/1000  );
				$features[] =  PHP_EOL . sprintf($feature, $fl["project"], 
										$fl["uid"], $fl["accuracy"],
										$fl["azimuth"],$fl["zenith"], $ddd,
										$file,
										$lng,  $lat );
             }
        }
    }
 
 //var '. basename(__FILE__, '.php').' = 
    $geojson = ' { "type": "FeatureCollection",
        "features": [ '.  implode(', ', $features)  .' ]
    }' ;
	
	if(file_put_contents("fireRESgeocatch.geojson", $geojson)){
		echo "N. of validated users: " . $nMailValid . ". N. of photoes: ". count($features) . ". ";
	} else {
		echo "Cannot write to JSON file! ";
	}

?>