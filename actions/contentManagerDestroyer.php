<?php
session_start();
session_unset();
session_destroy();

header("Location: ../pages/content_manager/login.php");
exit();
