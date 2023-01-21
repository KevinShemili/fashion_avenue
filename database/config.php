<?php

$connection = mysqli_connect('localhost', 'root', '', 'fashion_avenue');

if (!$connection) {
    die("Connection error: " . mysqli_connect_error());
}
