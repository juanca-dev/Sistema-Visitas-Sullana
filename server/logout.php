<?php
session_start();
session_destroy(); // Borra todo
header("location:../login.php"); // Patas a la calle
exit();