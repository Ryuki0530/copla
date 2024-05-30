<?php
    //セッション破棄とリダイレクト
    session_start();
    $_SESSION = array();
    session_destroy();
    header("Location: ../body/Home/left1.html");
    exit();
?>

