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


/*———————————–
送信ボタンを押した時の挙動
———————————–*/
if (array_key_exists("submit", $_POST)) {

  if (mysqli_connect_error()) {
    //　DATABASEに繋がらなかった場合
      die ("Database Connection Error");
  }



  if (!$_POST['course_id']) {

      $error .= "An course_id is required<br>";

  }

  if (!$_POST['course_name']) {

      $error .= "A course_name is required<br>";

  }

  if ($error != "") {

      $error = "<p>There were error(s) in your form:</p>".$error;

  } else {


    $query = "SELECT course_id FROM `course` WHERE course_id = '".mysqli_real_escape_string($link, $_POST['course_id'])."' LIMIT 1";

    $result = mysqli_query($link, $query);

    if (mysqli_num_rows($result) > 0) {
        // 既に登録されている講座は新規登録出来ない。
        $error = "この講座は既に登録されています";

    } else {

        $query = "INSERT INTO `course` (`course_id`, `course_name`) VALUES ('".mysqli_real_escape_string($link, $_POST['course_id'])."', '".mysqli_real_escape_string($link, $_POST['course_name'])."')";
        mysqli_query($link, $query);

        // 講座のレコード行数を、デフォルトでsortに代入する
        $courseQuery = "SELECT * FROM `course`";
        $courseResult = mysqli_query($link, $courseQuery);
        $sortNum = mysqli_num_rows($courseResult);
        echo "<script>alert(".$sortNum.");</script>";
        $sortQuery = 'UPDATE `course` SET sort = "'.$sortNum.'" WHERE course_id = "'.$_POST["course_id"].'"';
        echo "<script>alert(".$sortQuery.");</script>";
        mysqli_query($link, $sortQuery);

        //
        // if (!mysqli_query($link, $query)) {
        //
        //     $error = "<p>Could not sign you up - please try again later.</p>";
        //
        // } else {
        //
        //     $query = "UPDATE `users` SET password = '".md5(md5(mysqli_insert_id($link)).$_POST['password'])."' WHERE id = ".mysqli_insert_id($link)." LIMIT 1";
        //
        //     mysqli_query($link, $query);
        //
        //     $_SESSION['id'] = mysqli_insert_id($link);
        //
        //     if ($_POST['stayLoggedIn'] == '1') {
        //
        //         setcookie("id", mysqli_insert_id($link), time() + 60*60*24*365);
        //
        //     }
        //
        //     header("Location: course/list.php");
        //
        // }

    }

  }

}


?>



<h1>管理画面</h1>


<a href="/admin/course.php">講座管理</a>

<a href="/admin/user.php">ユーザー管理</a>


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

<script src="/_libs/jquery.tablednd.js"></script>

<script>
$(function() {

  /**
  * ドラッグアンドドロップ
  */
  $('#table-1').tableDnD({
    // 画像でのみ並べ替えドラッグをしたい場合
    // dragHandle: ".imgdrag img",
    onDrop: function(table, row) {
      $.post('/admin/sort.php', {
        sortitem: $.tableDnD.serialize()
      });
      alert("並び替えました");
// 下記2行はアラートもしくはコンソールでのPOST確認のためです。運用時は使用しません。
// alert("並び替えしました"+$.tableDnD.serialize());
// console.log($.tableDnD.serialize());
    }
  });


  /**
  * 講座追加
  */
  $('.js-add-course').click(function() {
    $('.js-add-course-form').show();
  });


});
</script>


<!-- ▲ このページ用JS ▲ -->
<?php
include($_SERVER['DOCUMENT_ROOT']."/_include/body_end.php");

?>
