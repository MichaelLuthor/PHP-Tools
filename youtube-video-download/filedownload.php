<?php
$url = urldecode(base64_decode(base64_decode($_GET['url'])));
readfile($url, false);