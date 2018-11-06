<?php



// DATABASE に接続
include($_SERVER['DOCUMENT_ROOT']."/_include/connection.php");

// meta情報
$title = "管理画面";


?>
<?php

// 共通headタグ
include($_SERVER['DOCUMENT_ROOT']."/_include/head.php");

 ?>
<body>
<?php

// 共通ヘッダー
include($_SERVER['DOCUMENT_ROOT']."/_include/header.php");


?>
<div class="container mt-5">

<?php

if (array_key_exists("id", $_SESSION)) {
  /*– ログインしている時 ———————–*/

if ($_GET["course_id"]) {
  $deleteCourseQuery = 'DELETE FROM course WHERE course_id = "'.$_GET["course_id"].'"';
  mysqli_query($link,$deleteCourseQuery);
  echo "<p>講座を削除しました</p>";
  echo '<p><a href="/admin/course.php">管理画面に戻る</a></p>';
}


if ($_GET["user"]) {
  $deleteUserQuery = 'DELETE FROM users WHERE email = "'.$_GET["user"].'"';
  mysqli_query($link,$deleteUserQuery);
  echo "<p>ユーザーを削除しました</p>";
  echo '<p><a href="/admin/user.php">管理画面に戻る</a></p>';
}

?>



<?php

}else{
  /*– ログインしていない時 ———————–*/
  echo 'ログインしてください';
}
?>
</div>

<?php

// 共通FOOTER
include($_SERVER['DOCUMENT_ROOT']."/_include/footer.php");

// 共通JS
include($_SERVER['DOCUMENT_ROOT']."/_include/common_js.php");
?>
<!-- ▼ このページ用JS ▼ -->
<!-- ▲ このページ用JS ▲ -->
<?php
include($_SERVER['DOCUMENT_ROOT']."/_include/body_end.php");

?>
