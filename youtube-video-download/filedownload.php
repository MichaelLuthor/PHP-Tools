<?php
$videoId = uniqid();
$filepath = __DIR__."/tmp-videos/{$videoId}";

$videoFile = fopen ($filepath, 'w+');
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $_POST['url']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FILE, $videoFile);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_exec($ch);
if ( 0 !== curl_errno($ch) ) {
    throw new \Exception("CURL 请求失败 :".curl_error($ch));
}
curl_close($ch);
fclose($videoFile);
echo json_encode(array('success'=>true,'message'=>'','data'=>array('url'=>"http://outtools.bwh1.suanhetao.com/youtube-video-download/tmp-videos/{$videoId}")));