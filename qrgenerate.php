<?php
include "phpqrcode.php";
QRcode::png($_GET['data'], false, $_GET['level'], $_GET['size'], 0, false);