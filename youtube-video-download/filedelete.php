<?php
$videoId = $_REQUEST['id'];
$filepath = __DIR__."/tmp-videos/{$videoId}";
unlink($filepath);
echo "OK";