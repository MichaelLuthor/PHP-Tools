<?php
/**
 * @var $_GET['url'] 
 */
$response = array(
    'success' => true,
    'message' => '',
    'data' => null,
);

try {
    $ch = curl_init($_POST['url']);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_NOBODY, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    
    $sizeResponse = curl_exec($ch);
    if ( 0 !== curl_errno($ch) ) {
        throw new \Exception("CURL 请求失败 :".curl_error($ch));
    }
    if ( false === $sizeResponse ) {
        throw new \Exception("CURL 请求失败 :".curl_error($ch));
    }
    
    $sizeResponse = explode("\n", str_replace("\r", '', trim($sizeResponse)));
    $filesize = 0;
    foreach ( $sizeResponse as $line ) {
        if ( 'Content-Length:' === substr($line, 0, strlen('Content-Length:')) ) {
            $size = intval(trim(substr($line, strlen('Content-Length:'))));
            if ( 0 === $size ) {
                continue;
            }
            $filesize = $size;
        }
    }
    
    curl_close($ch);
    
    $response['data'] = ['size'=>$filesize];
} catch ( Exception $e ) {
    $response['success'] = false;
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
