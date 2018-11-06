<?php

// DATABASE に接続
include($_SERVER['DOCUMENT_ROOT']."/_include/connection.php");

$courseId = $_COOKIE["course_id"];
$statusText = $_COOKIE["status_text"];
$pausetime = $_COOKIE["pausetime"];
$now = new DateTime;
$nowtime = $now->format('Y-m-d H:i:s');
$pause_or_ended = $_COOKIE["pause_or_ended"];
if ($pause_or_ended == 'pause') {
  $statusInsert = $pausetime;
}else{
  $statusInsert = '完了';
}

// 今視聴している講座の情報を取得
$courseQuery = 'SELECT * FROM course WHERE course_id ="'.$courseId.'"';
$courseResult = mysqli_query($link,$courseQuery);
while($courseRow = mysqli_fetch_array($courseResult)){
  $courseName = $courseRow['course_name'];
}

// 一回目の視聴かどうかのフラグを立てる
$statusQuery = "SELECT status FROM `history` WHERE user_id = '".$_SESSION['id']."' AND course_id = '".$courseId."' LIMIT 1";
$statusResult = mysqli_query($link, $statusQuery);
$firstFlug = true;
if(mysqli_num_rows($statusResult) > 0){
  $firstFlug = false;
}
while($statusRow = mysqli_fetch_array($statusResult)){
  $statusText = $statusRow['status'];
}

if ($firstFlug == true ) {
  // 一回目の視聴の場合は、INSERT文を入れる
  $historyQuery = "INSERT INTO `history`(`course_id`,`course_name`,`user_id`,`datetime`,`status`)
  VALUES ('".$_COOKIE["course_id"]."',
  '".$courseName."',
  '".$_SESSION['id']."',
  '".$nowtime."',
  '".$statusInsert."')";
  mysqli_query($link,$historyQuery);

}elseif ($statusText != '完了' ) {
  // 完了以外の場合は、UPDATE文を入れる
  $historyQuery = "UPDATE `history` SET status = '".$statusInsert."',datetime = '".$nowtime."' WHERE user_id = '".$_SESSION['id']."' AND course_id = '".$_COOKIE["course_id"]."' LIMIT 1";
  mysqli_query($link,$historyQuery);
}


?>
