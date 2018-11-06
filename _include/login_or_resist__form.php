<?php


/*———————————–
送信ボタンを押した時の挙動
———————————–*/
if (array_key_exists("submit", $_POST)) {

    //$link = mysqli_connect("localhost", "root", "root", "youtube");

    if (mysqli_connect_error()) {
      //　DATABASEに繋がらなかった場合
        die ("Database Connection Error");
    }



    if (!$_POST['email']) {

        $error .= "An email address is required<br>";

    }

    if (!$_POST['password']) {

        $error .= "A password is required<br>";

    }

    if ($error != "") {

        $error = "<p>There were error(s) in your form:</p>".$error;

    } else {

        if ($_POST['signUp'] == '1') {

            /*———————————–
            会員登録時の挙動
            ———————————–*/

            $query = "SELECT id FROM `users` WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."' LIMIT 1";

            $result = mysqli_query($link, $query);

            if (mysqli_num_rows($result) > 0) {
                // 既に登録されているメールアドレスは新規登録出来ない。
                $error = "That email address is taken.";

            } else {

                $query = "INSERT INTO `users` (`email`, `password`) VALUES ('".mysqli_real_escape_string($link, $_POST['email'])."', '".mysqli_real_escape_string($link, $_POST['password'])."')";

                if (!mysqli_query($link, $query)) {

                    $error = "<p>Could not sign you up - please try again later.</p>";

                } else {

                    // $query = "UPDATE `users` SET password = '".md5(md5(mysqli_insert_id($link)).$_POST['password'])."' WHERE id = ".mysqli_insert_id($link)." LIMIT 1";
                    //
                    // mysqli_query($link, $query);

                    $query = "SELECT * FROM `users` WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."'";

                    $result = mysqli_query($link, $query);

                    $row = mysqli_fetch_array($result);

                    if (isset($row)) {
                      $_SESSION['id'] = $row['id'];
                    }


                    if ($_POST['stayLoggedIn'] == '1') {

                        //setcookie("id", mysqli_insert_id($link), time() + 60*60*24*365);
                        setcookie("id", $row['id'], time() + 60*60*24*365);

                    }

                    //会員登録のお知らせ（管理者向け）
                    mb_send_mail("akirasegaawaa@gmail.com","会員登録がありました","内容は下記のとおりです。\n\n----------------------------\n\n".$_POST['email']."\n".$_POST['password'],"From:noreply@segawa.test");

                    //会員登録のお知らせ（ユーザー向け）
                    mb_send_mail($_POST['email'],"会員登録ありがとうございます","内容は下記のとおりです。\n\n----------------------------\n\n".$_POST['email']."\n".$_POST['password'],"From:noreply@segawa.test");

                    header("Location: course/list.php");

                }

            }

        } else {

            /*———————————–
            ログイン時の挙動
            ———————————–*/

            $query = "SELECT * FROM `users` WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."'";

            $result = mysqli_query($link, $query);

            $row = mysqli_fetch_array($result);

            if (isset($row)) {
//                        $hashedPassword = $_POST['password'];
// hashed がわからないので一旦スルー　おそらくセキュリティの面で有用。
                $hashedPassword = md5(md5($row['id']).$_POST['password']);
//                        echo $hashedPassword;

                if ($hashedPassword == $row['password']) {

                    $_SESSION['id'] = $row['id'];

                    if ($_POST['stayLoggedIn'] == '1') {

                        setcookie("id", $row['id'], time() + 60*60*24*365);

                    echo "<script>location.href='./course/list.php';</script>";
                    }
                    echo "<script>location.href='./course/list.php';</script>";

                } else {

                    $error = "That email/password combination could not be found.";

                }

            } else {

                $error = "That email/password combination could not be found.";

            }

        }

    }


}

?>
