<?php

$link = new mysqli("127.0.0.1", "root", "", "test");
$res = $link->query("show tables");
$data = $res->fetch_all(MYSQLI_ASSOC);

print_r($data);
?>