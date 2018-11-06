<?php

session_start();
//ローカル用
$link = mysqli_connect("localhost", "root", "root", "youtube_new");
//サーバー用
//$link = mysqli_connect("localhost", "root", "password", "youtube_new");
$link -> set_charset("utf8");
// サーバー名、データベースユーザー名、パスワード、データベース名

if(mysqli_connect_error()){
  die("Database Connection Error");
}else{
//  echo "データベース接続に成功しました<br>";
}

?>
