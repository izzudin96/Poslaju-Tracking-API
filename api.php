<?php

/*  Poslaju Tracking API created by Afif Zafri.
    Tracking details are fetched directly from Poslaju tracking website,
    parse the content, and return JSON formatted string.
    Please note that this is not the official API, this is actually just a "hack",
    or workaround for implementing Poslaju tracking feature in other project.
    Usage: http://site.com/index.php?trackingNo
*/

if(isset($_GET['trackingNo']))
{
    $trackingNo = $_GET['trackingNo']; # put your poslaju tracking number here 

    $url = "http://poslaju.com.my/track-trace-v2/"; # url of poslaju tracking website

    # store post data into array (poslaju website only receive the tracking no with POST, not GET. So we need to POST data)
    $postdata = http_build_query(
        array(
            'trackingNo' => $trackingNo,
            'hvtrackNoHeader' => '',
            'hvfromheader' => 0
        )
    );

    # use cURL instead of file_get_contents(), this is because on some server, file_get_contents() cannot be used
    # cURL also have more options and customizable
    $ch = curl_init(); # initialize curl object
    curl_setopt($ch, CURLOPT_URL, $url); # set url
    curl_setopt($ch, CURLOPT_POST, 1); # set option for POST data
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata); # set post data array
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); # receive server response
    $result = curl_exec($ch); # execute curl, fetch webpage content
    curl_close($ch);  # close curl

    # using regex (regular expression) to parse the HTML webpage.
    # we only want to good stuff
    # regex patern
    $patern = "#<table id='tbDetails'(.*?)</table>#"; 

    # execute regex
    preg_match_all($patern, $result, $parsed);  


    print_r($parsed[0]);

}


?>
