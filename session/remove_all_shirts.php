<?php

session_start();

unset($_SESSION['cart']);
unset($_SESSION['promotion']);

$return['items'] = 0;
$return['status'] = "OK";

echo json_encode($return);

?>