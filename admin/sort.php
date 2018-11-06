<?php

// DATABASE に接続
include($_SERVER['DOCUMENT_ROOT']."/_include/connection.php");

// 配列化
parse_str($_POST["sortitem"],$sortitem);

// 全件カウント
$num = count($sortitem['table-1']);

for($i=0; $i<$num; $i++) {
  // SQL文　該当テーブルのテーブル名・カラム名に変更してください。（"sort":ソート順カラム名、"id":データのIDカラム名）
  $sql = "UPDATE course SET sort = '".$i."' WHERE id = '".$sortitem['table-1'][$i]."'";
  // SQL文を実行
  mysqli_query($link, $sql);
}

?>
