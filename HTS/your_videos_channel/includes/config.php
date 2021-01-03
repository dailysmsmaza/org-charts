<?php

    //database configuration

    $host       = "localhost";
    $user       = "dailysms_dsmuser";
    $pass       = "OJK6kg~r}s26";
    $database   = "dailysms_video_channel";

    $connect = new mysqli($host, $user, $pass, $database);

    if (!$connect) {
        die ("connection failed: " . mysqli_connect_error());
    } else {
        $connect->set_charset('utf8');
    }

?>