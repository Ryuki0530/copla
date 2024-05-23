<?php
$commentArray = array();
$pdo = null;
$stmt = null;
$check = 0;

//echo("HELLO");

require_once __DIR__ . '/../etc/Settings.php';
//DB接続
try{
    $pdo = new PDO('mysql:host='.$db_host.';dbname='.$db_name, $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // PDOのエラーモードを設定して例外を投げるようにする
  //  echo("接続完了！");
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>