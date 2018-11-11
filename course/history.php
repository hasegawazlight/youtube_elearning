<?php



// DATABASE に接続
include($_SERVER['DOCUMENT_ROOT']."/_include/connection.php");

// meta情報
$title = "受講履歴一覧";


?>
<?php

// 共通headタグ
include($_SERVER['DOCUMENT_ROOT']."/_include/head.php");

 ?>
<body>
<?php

// 共通ヘッダー
include($_SERVER['DOCUMENT_ROOT']."/_include/header.php");

  // このユーザーが受講したことのある講座の情報を取得
  $historyQuery = 'SELECT * FROM history WHERE user_id ="'.$_SESSION['id'].'"';

  if ($historyResult = mysqli_query($link,$historyQuery)) {
?>


<div class="container mt-5">
  <h1 id="appSummary">受講履歴一覧</h1>

<?php
// １つでも受講したことがある場合のみ表示
if (mysqli_num_rows($historyResult) > 0) {
?>
  <div class="table-responsive-sm">

    <table class="table table-hover">
      <thead>
        <tr>
          <th>
            講座名
          </th>
          <th>
            ステータス
          </th>
          <th>
            受講日時
          </th>
        </tr>
      </thead>
      <tbody>
<?php
  while($row = mysqli_fetch_array($historyResult)){
    if (!isset($row)) {
      echo "test";
    }
?>

        <tr>
          <td>
<?php
      if ($row['status'] != '完了') {
        // ステータスが完了ではない場合、前回に再生した時間が代入されているので、続きから再生させる
        echo '<a href="/course/?course_id='.$row['course_id'].'&start='.$row['status'].'" target="_blank">'.$row['course_name'].'</a>';
      }else{
        echo '<a href="/course/?course_id='.$row['course_id'].'" target="_blank">'.$row['course_name'].'</a>';
      }
?>
          </td>
          <td>
<?php
      if ($row['status'] != '完了') {
        // ステータスが完了ではない場合、前回に再生した時間／講座の時間　のパーセンテージを表示
        $statusRatio = $row['status'] / $row['course_time'] * 100;
        echo floor($statusRatio).'％';
      }else{
        echo $row['status'];
      }
?>
          </td>
          <td>
<?php
      echo $row['datetime'];
?>
          </td>
        </tr>
<?php

    }

  }else{
    // １つも受講したことがない場合
    echo 'まだ受講した講座はありません';
  }
}

?>
      </tbody>
    </table>
  </div>
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
