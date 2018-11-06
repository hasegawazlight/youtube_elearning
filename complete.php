<?php
function ytended(){
echo "test";

// 再生終了したら受講完了とみなす。
//$query = 'UPDATE `users` SET course_boolean="1" WHERE email="akirasegaawaa@gmail.com" LIMIT 1';
$date =  date('Y/m/d H:i:s');

$query = "INSERT INTO courses(id,name,history,datetimes) VALUES (".$_SESSION['id'].",'講座名です',1,'".$date."')";

mysqli_query($link,$query);
//echo $query;
//$date =  date('Y/m/d H:i:s');
//$query2 = 'UPDATE `courses` SET course_datetime="'.$date.'" WHERE email="akirasegaawaa@gmail.com" LIMIT 1';
//$query2 = 'UPDATE `courses` SET datetime="'.$date.'" WHERE id="1" LIMIT 1';
//mysqli_query($link,$query2); 
}
?>