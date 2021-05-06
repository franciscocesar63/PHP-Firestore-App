<?php

include_once './model/GFirebase.php';
// phpinfo();
$fb = new Firestore('estudo');

// echo extension_loaded('grpc') ? 'yes' : 'no';
var_dump($fb->getDocuments());

