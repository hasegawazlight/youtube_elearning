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
  //
  // if (!$_POST['course_name']) {
  //
  //     $error .= "A course_name is required<br>";
  //
  // }

  if ($error != "") {

      $error = "<p>There were error(s) in your form:</p>".$error;

  } else {


    $query = "SELECT course_id FROM `course` WHERE course_id = '".mysqli_real_escape_string($link, $_POST['course_id'])."' LIMIT 1";

    $result = mysqli_query($link, $query);

    if (mysqli_num_rows($result) > 0) {
        // 既に登録されている講座は新規登録出来ない。
        $error = "この講座は既に登録されています";

    } else {

        $query = "INSERT INTO `course` (`course_id`) VALUES ('".mysqli_real_escape_string($link, $_POST['course_id'])."')";
        mysqli_query($link, $query);

        // 講座のレコード行数を、デフォルトでsortに代入する（講座一覧の一番後ろに挿入される）
        $courseQuery = "SELECT * FROM `course`";
        $courseResult = mysqli_query($link, $courseQuery);
        $sortNum = mysqli_num_rows($courseResult);
        $sortQuery = 'UPDATE `course` SET sort = "'.$sortNum.'" WHERE course_id = "'.$_POST["course_id"].'"';
        mysqli_query($link, $sortQuery);

?>
      <div id="youtubeapi"></div>
      <script>
        // course_name と　course_time　は、YouTube APIから取得する。
          $('#youtubeapi').load( '/admin/youtube_api.php',{video_id:"<?php echo $_POST['course_id']; ?>"});



/*
          jQuery(function($){
            //ajax送信
            $.ajax({
                url : "youtube_api.php",
                type : "POST",
                dataType:"json",
                data : {course_id:"ssss"},
                error : function(XMLHttpRequest, textStatus, errorThrown) {
                    console.log("ajax通信に失敗しました");

                    console.log("XMLHttpRequest : " + XMLHttpRequest.status);
                    console.log("textStatus     : " + textStatus);
                    console.log("errorThrown    : " + errorThrown.message);
                },
                success : function(response) {
                    console.log("ajax通信に成功しました");
                    // console.log('停止時間は'+response[0]);
                    // console.log('今の時刻は'+response[1]);
                    // document.cookie = 'course_id=<?php echo $_GET["course_id"]; ?>';
                    // document.cookie = 'status_text='+ytPlayer.getCurrentTime();
                    // document.cookie = 'pausetime='+response[0];
                    // document.cookie = 'pause_or_ended=pause';
                    // $('#status').load('./ajax_successed.php');
                }
            });
        });
*/
      </script>
<?php
    }

  }
}



?>





<h2>講座一覧</h2>
<table id="table-1">
<?php

$listQuery = 'SELECT * FROM course ORDER BY sort';

if ($listResult = mysqli_query($link,$listQuery)) {
?>

<tr class="nodrop nodrag">
  <th>
    ID
  </th>
  <th>
    講座名
  </th>
  <th>
    時間
  </th>
  <th style="text-align:center;">
    削除ボタン
  </th>
</tr>

<?php
while ($table=mysqli_fetch_array($listResult)) {
?>
<tr id="<?php echo $table['id']; ?>">
  <td>
    <?php print(htmlspecialchars($table['course_id'])); ?>
  </td>
  <td>
    <?php print(htmlspecialchars($table['course_name'])); ?>
  </td>
  <td>
    <?php print(htmlspecialchars($table['course_time'])); ?>
  </td>
  <td style="text-align:center;">
    <a href="delete.php?course_id=<?php print(htmlspecialchars($table['course_id'])); ?>" onclick="return confirm('ID <?php echo $table['course_id'] ?> を削除しても良いですか？');">aaa</a>
  </td>
</tr>
<?php
}

}
?>

</table>

<a class="js-add"><i class="fas fa-plus-circle"></i></a>

<div id="error"><?php echo $error; ?></div>

<div class="js-add-form" style="display:none;">
  <form method="post">

      <input type="text" name="course_id" placeholder="course_id">

<!--
      <input type="text" name="course_name" placeholder="course_name">
      <input type="checkbox" name="stayLoggedIn" value=1>

      <input type="hidden" name="signUp" value="1"> -->

      <input type="submit" name="submit" value="登録">

  </form>
</div>




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
  $('.js-add').click(function() {
    $('.js-add-form').show();
  });


});
</script>


<!-- ▲ このページ用JS ▲ -->
<?php
include($_SERVER['DOCUMENT_ROOT']."/_include/body_end.php");

?>
