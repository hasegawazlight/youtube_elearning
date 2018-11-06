  <header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="/">LOGO</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="/course/list.php">講座一覧</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/course/history.php">受講履歴一覧</a>
          </li>
        </ul>
        <div class="form-inline my-2 my-lg-0">
<?php

/*———————————–
ログイン状況により処理を出し分ける
———————————–*/

if (array_key_exists("id", $_SESSION)) {
  /*– ログインしている時 ———————–*/

  // 今ログインしているユーザーの情報を取得し出力する
  $loginQuery = 'SELECT * FROM users WHERE id ="'.$_SESSION['id'].'"';
  if ($loginResult = mysqli_query($link,$loginQuery)) {
    while($loginRow = mysqli_fetch_array($loginResult)){
      $userName = $loginRow['email'];
    }
  }else{
    echo "クエリの発行に失敗しました";
  }

?>
          <p><?php echo $_SESSION['id'].$userName; ?>さん</p>
          <a class="btn btn-outline-info my-2 my-sm-0" href="/?logout=1">ログアウト</a>
          <a class="btn btn-outline-info my-2 my-sm-0" href="/admin/">管理画面</a>
<?php
}else{
  /*– ログインしていない時 ———————–*/

  // 会員登録・ログインへのリンクを出力する
?>
          <a class="btn btn-outline-info my-2 my-sm-0" href="/registration.php">会員登録</a>
          <a class="btn btn-outline-info my-2 my-sm-0" href="/login.php">ログイン</a>
<?php
}

?>

        </div>
      </div>
    </nav>
  </header>


<!-- ▼ ログイン用モーダル ▼ -->
      <!-- <div id="login-modal" class="modal fade bd-example-modal-l" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="myModalLabel">ログイン</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method="post">
              <div class="modal-body">
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
              </div>
              <div class="modal-footer">
                <button type="submit" name="submit" class="btn btn-primary">ログイン</button>
              </div>
            </form>
          </div>
        </div>
      </div> -->
<!-- ▲ ログイン用モーダル ▲ -->

<!-- ▼ 会員登録用モーダル ▼ -->
      <!-- <div id="resist-modal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="myModalLabel">会員登録</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method="post">
              <div class="modal-body">
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
                      <input type="hidden" name="signUp" value="1">
                  </div>
              </div>
              <div class="modal-footer">
                <input type="submit" name="submit" class="btn btn-primary" value="会員登録">
                <button type="submit" name="submit" class="btn btn-primary" onclick="return:false;">会員登録</button>
              </div>
            </form>
          </div>
        </div>
      </div> -->
<!-- ▲ 会員登録用モーダル ▲ -->
