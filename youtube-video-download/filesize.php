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
    $url = base64_decode(base64_decode($_GET['url']));
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_NOBODY, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    $sizeResponse = curl_exec($ch);
    if ( false === $sizeResponse ) {
        throw new \Exception("CURL 请求失败 :".curl_error($ch));
    }
    curl_close($ch);
    
    $regex = '/Content-Length:\s(?P<size>[0-9].+?)\s/';
    preg_match($regex, $sizeResponse, $matche);
    if ( !isset($matche['size']) || 0 === $matche['size']*1 ) {
        throw new \Exception('Failed to get video size form youtube');
    }
    
    $response['data'] = ['size'=>($matche['size']*1)];
} catch ( Exception $e ) {
    $response['success'] = false;
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
