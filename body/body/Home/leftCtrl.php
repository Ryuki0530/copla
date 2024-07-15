<?php
session_start();

if(isset($_SESSION['userID'])){
  header("Location: left.html");
  exit();
} else {
  header("Location: left1.html");  
  exit();
}

?>