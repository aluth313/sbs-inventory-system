<?php 

date_default_timezone_set("Asia/Jakarta");

define('host','localhost');
define('name', 'root');
define('pass', 'november');
define('dbase', 'service_db');

$conn = mysqli_connect(host, name, pass, dbase) or die('Unable to connect');

?>