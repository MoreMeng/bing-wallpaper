<?php
error_reporting( 0 );
header( "Access-Control-Allow-Origin: *" );
header( 'Access-Control-Allow-Methods:  GET' );

require realpath( '../dv-config.php' );
require DEV_PATH . '/functions/global.php';

$api = 'https://www.bing.com/HPImageArchive.aspx?format=js&idx=0&n=1&mkt=th-TH';

$source = curl_powerdrills( $api );

if ( $source !== false and !empty( $source ) ) {

    http_response_code( 200 );

    $data = json_decode( $source );

    $img = 'https://www.bing.com' . $data->images[0]->url;

    $fp = fopen( $img, 'rb' );

    header( 'Content-type: image/jpeg;' );

    foreach ( $http_response_header as $h ) {
        if ( strpos( $h, 'Content-Length:' ) === 0 ) {
            header( $h );
            break;
        }
    }

    fpassthru( $fp );
} else {
    http_response_code( 400 );
}
