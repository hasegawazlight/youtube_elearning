<?php



// DATABASE に接続
include($_SERVER['DOCUMENT_ROOT']."/_include/connection.php");


// meta情報
$title = "ログインページ";






// error文用の変数
$error = "";

/*———————————–
ログイン状況により処理を出し分ける
———————————–*/
if (array_key_exists("logout", $_GET)) {
  /*– ログアウトしている時 ———————–*/
    session_unset();
//    unset($_SESSION);
    setcookie("id", "", time() - 60*60);
    $_COOKIE["id"] = "";
    echo 'logout検知しました';

} else if ((array_key_exists("id", $_SESSION) AND $_SESSION['id']) OR (array_key_exists("id", $_COOKIE) AND $_COOKIE['id'])) {
  /*– ログインしている時 ———————–*/

  // list.phpに遷移させる
    header("Location: course/list.php");

}



// ログイン・会員登録フォーム用script
include($_SERVER['DOCUMENT_ROOT']."/_include/login_or_resist__form.php");


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
      <h1>
        ログイン
      </h1>
      <p class="lead">以下のフォームよりログインしてください</p>
    </div>

    <div class="container mt-5">
      <form method="post">
        <div class="row">
          <div class="form-group col-sm-6">
            <label for="exampleFormControlInput1">Email address</label>
            <input type="email" name="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
          </div>
          <div class="form-group col-sm-6">
            <label for="exampleInputPassword1">Password</label>
            <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
          </div>
            <input type="hidden" name="stayLoggedIn" value=1>
            <input type="hidden" name="signUp" value="0">
        </div>
        <?php
        $errorWrap ='<div id="error" class="alert alert-danger col-sm-6" role="alert">'.$error.'</div>';
        if (!$error == '') {
          echo $errorWrap;
        }
        ?>
        <button type="submit" name="submit" class="btn btn-primary">ログイン</button>
      </form>

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

