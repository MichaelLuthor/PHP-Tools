<?php
$_GET['url'] = base64_encode(base64_encode('https://www.json.cn/'));
$url = base64_decode(base64_decode($_GET['url']));
readfile($url, false);