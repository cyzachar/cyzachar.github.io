<?php

function get_web_page($url) {
    $options = array(
        CURLOPT_RETURNTRANSFER => true,   // return web page
        CURLOPT_HEADER         => false,  // don't return headers
        CURLOPT_FOLLOWLOCATION => true,   // follow redirects
        CURLOPT_MAXREDIRS      => 10,     // stop after 10 redirects
        CURLOPT_ENCODING       => "",     // handle compressed
        CURLOPT_USERAGENT      => "test", // name of client
        CURLOPT_AUTOREFERER    => true,   // set referrer on redirect
        CURLOPT_CONNECTTIMEOUT => 120,    // time-out on connect
        CURLOPT_TIMEOUT        => 120,    // time-out on response
    ); 

    $ch = curl_init($url);
    curl_setopt_array($ch, $options);

    $content  = curl_exec($ch);

    curl_close($ch);

    return $content;
}


$rPois   = get_web_page("http://192.168.1.4/rapids/api/poi/getPointOfInterest.php");
$rTags   = get_web_page("http://192.168.1.4/rapids/api/poi/getTags.php");
$rMedia  = get_web_page("http://192.168.1.4/rapids/api/poi/getPoiMedia.php");
$rCoords = get_web_page("http://192.168.1.4/rapids/api/poi/getPoiCoords.php");

$allData = "[".$rPois.",".$rTags.",".$rMedia.",".$rCoords."]";

echo $allData;


?>