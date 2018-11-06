<?php



// DATABASE に接続
include($_SERVER['DOCUMENT_ROOT']."/_include/connection.php");


// meta情報
$title = "トップページ";




/*———————————–
ログアウトボタン押下時の挙動
———————————–*/
if (array_key_exists("logout", $_GET)) {
    session_unset();
//    unset($_SESSION);
    setcookie("id", "", time() - 60*60);
    $_COOKIE["id"] = "";
    //echo 'logout検知しました';
}
//
// else if ((array_key_exists("id", $_SESSION) AND $_SESSION['id']) OR (array_key_exists("id", $_COOKIE) AND $_COOKIE['id'])) {
//   /*– ログインしている時 ———————–*/
//
//   // list.phpに遷移させる
//     header("Location: course/list.php");
//
// }


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


<?php

// 講座数の取得
$listCountQuery = 'SELECT * FROM course ORDER BY sort';
if ($listCountResult = mysqli_query($link,$listCountQuery)) {
  $listCountNum = 0;
  while($row = mysqli_fetch_array($listCountResult)){
    $listCountNum++;
  }
}
// ユーザー数の取得
$userCountQuery = 'SELECT * FROM users';
if ($userCountResult = mysqli_query($link,$userCountQuery)) {
  $userCountNum = 0;
  while($row = mysqli_fetch_array($userCountResult)){
    $userCountNum++;
  }
}

 ?>

  <div class="jumbotron">
    <div class="container">
      <h1 class="display-4">Hello, world!</h1>
      <p class="lead">This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
      <hr class="my-4">
      <p><i class="fab fa-youtube"></i>講座数：<span class="odometer course_num"></span>、<!--<i class="fas fa-graduation-cap"></i>--><i class="fas fa-users"></i>ユーザー数：<span class="odometer user_num"></span></p>
      <p>It uses utility classes for typography and spacing to space content out within the larger container.</p>
      <a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a>
    </div>
  </div>



  <div class="container">
    <h2 id="appSummary">講座一覧</h2>

    <div class="row ml-0 mr-0">
<?php
  // 登録されている講座一覧を取得
  $listQuery = 'SELECT * FROM course ORDER BY sort';

  if ($listResult = mysqli_query($link,$listQuery)) {
    $i = 0;
    while($row = mysqli_fetch_array($listResult)){
?>
      <div class="card">
        <img class="card-img-top" src="http://i.ytimg.com/vi/<?php echo $row['course_id']; ?>/mqdefault.jpg" alt="Card image cap">
        <div class="card-body">
          <h5 class="card-title"><?php echo $row['course_name']; ?></h5>
          <!-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> -->
          <a href="<?php echo "/course/?course_id=".$row['course_id']; ?>" class="btn btn-primary">Go somewhere</a>
        </div>
      </div>
<?php
      // トップページには最大３件まで表示
      $i++;
      if ($i > 2) {
        break;
      }
    }
  }
?>
    </div>
  </div>



  <div class="container text-center">
    <a href="/course/list.php" class="btn btn-primary btn-lg">すべての講座を見る</a>
  </div>



<?php

// 共通FOOTER
include($_SERVER['DOCUMENT_ROOT']."/_include/footer.php");

// 共通JS
include($_SERVER['DOCUMENT_ROOT']."/_include/common_js.php");
?>
<link rel="stylesheet" href="/_libs/odometer-0.4.6/odometer-theme-default.css">

<!-- ▼ このページ用JS ▼ -->
<script src="/_libs/odometer-0.4.6/odometer.min.js"></script>
<script>

  $(function(){
    // 講座数とユーザー数のエフェクト
    $('.course_num').html('<?php echo $listCountNum; ?>');
    $('.user_num').html('<?php echo $userCountNum; ?>');
  });

</script>

<!-- ▲ このページ用JS ▲ -->
<?php
include($_SERVER['DOCUMENT_ROOT']."/_include/body_end.php");

?>
