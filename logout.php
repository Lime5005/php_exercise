<?php
session_start();
session_unset();
session_destroy();

setcookie('name', '', time() - 86400);
header("Location: ./login.php", true, 302);
exit();
?>