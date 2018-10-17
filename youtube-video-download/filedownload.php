<?php
$filepath = __DIR__.'/tmp-videos/'.uniqid();

$videoFile = fopen ($filepath, 'w+');
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $_POST['url']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($ch, CURLOPT_FILE, $videoFile);
curl_exec($ch);
curl_close($ch);
fclose($videoFile);

header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename=video.tmp');
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: ' . filesize($filepath));
readfile($filepath);
unlink($filepath);