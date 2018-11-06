<?php
//ajax送信でPOSTされたデータを受け取る
$status = $_POST['status'];
//$datetime = $_POST['datetime'];
//受け取ったデータを配列に格納
$return_array = array($status);
//「$return_array」をjson_encodeして出力
echo json_encode($return_array);
?>
