<?php

// DATABASE に接続
include($_SERVER['DOCUMENT_ROOT']."/_include/connection.php");



//ajax送信でPOSTされたデータを受け取る
//$status = $_POST["course_id"];
//$datetime = $_POST['datetime'];
//受け取ったデータを配列に格納
//$return_array = array($status);
//「$return_array」をjson_encodeして出力
//echo json_encode($return_array);
?>

<?php

//echo "youtubeapisqlの".$_COOKIE["course_id"];
$courseName = $_COOKIE["course_name"];

$courseName = mysqli_real_escape_string($link,$courseName);

$updateQuery = 'UPDATE `course` SET course_time = "'. $_COOKIE["course_time"].'" WHERE course_id = "'.$_COOKIE["course_id"].'"';
mysqli_query($link, $updateQuery);

//echo "youtubeapisqlの".$updateQuery."<br>";

$updateQuery = 'UPDATE `course` SET course_name = "'. $courseName.'" WHERE course_id = "'.$_COOKIE["course_id"].'"';
mysqli_query($link, $updateQuery);
//echo "youtubeapisqlの".$updateQuery;
//
//
// $updateQuery = 'UPDATE `course` SET course_time = "'. $_COOKIE["course_time"].'" WHERE course_id = "'.$_COOKIE["course_id"].'"';
// mysqli_query($link, $updateQuery);

?>
