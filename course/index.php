<?php



// DATABASE に接続
include($_SERVER['DOCUMENT_ROOT']."/_include/connection.php");

if (array_key_exists("id", $_SESSION)) {
  /*– ログインしている時 ———————–*/

  // 今ログインしているユーザーの情報を取得
  //
  // $loginQuery = 'SELECT * FROM users WHERE id ="'.$_SESSION['id'].'"';
  // if ($loginResult = mysqli_query($link,$loginQuery)) {
  //   while($loginRow = mysqli_fetch_array($loginResult)){
  //     $userName = $loginRow['email'];
  //   }
  // }else{
  //   echo "クエリの発行に失敗しました";
  // }
  //

  // 今視聴している講座の情報を取得
  $courseQuery = 'SELECT * FROM course WHERE course_id ="'.$_GET["course_id"].'"';
  if ($courseResult = mysqli_query($link,$courseQuery)) {
    while($courseRow = mysqli_fetch_array($courseResult)){
      $courseName = $courseRow['course_name'];
    }
  }else{
    echo "クエリの発行に失敗しました";
  }

  // meta情報
  if (isset($courseName)) {
    $title = $courseName;
  }

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


<div id="js-allready-alert" class="container mt-5" style="display:none;">
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    この講座は既に受講済みです
    <button type="button" id="js-search-close" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
</div>

<div class="container mt-5">
  <h1><?php echo $courseName; ?></h1>
  <div class="embed-responsive embed-responsive-16by9">
    <div id="sample"></div>
  </div>
</div>

<div class="container mt-5">
    <div id="status"></div>
</div>



<?php

}else{
/*– ログインしていない時 ———————–*/
echo 'この講座を閲覧したい場合は、<a href="/login.php">ログイン</a>もしくは<a href="/resistration.php">会員登録</a>してください。';
}
?>





<?php

// 共通FOOTER
include($_SERVER['DOCUMENT_ROOT']."/_include/footer.php");

// 共通JS
include($_SERVER['DOCUMENT_ROOT']."/_include/common_js.php");
?>
<!-- ▼ このページ用JS ▼ -->

<?php
// 既に受講済みの講座の場合は、既に受講済みのアラートを表示させる
$statusQuery = "SELECT status FROM `history` WHERE user_id = '".$_SESSION['id']."' AND course_id = '".$_GET["course_id"]."' LIMIT 1";
$statusResult = mysqli_query($link, $statusQuery);
while($statusRow = mysqli_fetch_array($statusResult)){
  $statusText = $statusRow['status'];
}

$_COOKIE["status_text"] = $statusText;

//echo "<p>".$statusText."</p>";
if ($statusText == '完了' ) {
?>
<script>
  $('#js-allready-alert').show();
</script>
<?php
}
?>


<script>


// IFrame Player API の読み込み
var tag = document.createElement('script');
tag.src = "https://www.youtube.com/iframe_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

// YouTubeの埋め込み
function onYouTubeIframeAPIReady() {
  ytPlayer = new YT.Player(
       'sample', // 埋め込む場所の指定
        {
           width: 640, // プレーヤーの幅
          height: 390, // プレーヤーの高さ
            playerVars: {
                rel: 0, // 再生終了後に関連動画を表示するかどうか設定
                autoplay: 1, // 自動再生するかどうか設定
                enablejsapi: 1, //JavaScript APIを有効に
                showinfo: 0,
                frameborder: 0,
                playsinline: 0,
                origin: location.protocol + "//" + location.hostname + "/"
            },
            // イベントの設定
            events: {
                'onStateChange': onPlayerStateChange, // プレーヤーの状態が変更されたときに実行
                'onReady': onPlayerReady
            }
        }
   );
}

// onReadyのコールバック関数
function onPlayerReady() {
    ytPlayer.loadVideoById({
        'videoId': '<?php echo $_GET["course_id"]; ?>',
<?php
// 途中まで再生していた場合は、前回視聴の続きから視聴する
if ($_GET["start"]) {
  echo "'startSeconds': ".$_GET['start'];
}
?>
    });
}

// プレーヤーの状態が変更されたとき
function onPlayerStateChange(event) {
   // 現在のプレーヤーの状態を取得
   var ytStatus = event.data;
  // 再生終了したとき
 if (ytStatus == YT.PlayerState.ENDED) {
     console.log('再生終了');

  // 再生完了したら、DBに再生完了とその時間を登録する
  jQuery(function($){
      //ajax送信
      $.ajax({
          url : "ajax.php",
          type : "POST",
          dataType:"json",
          data : {status:"完了"},
          error : function(XMLHttpRequest, textStatus, errorThrown) {
              console.log("ajax通信に失敗しました");
          },
          success : function(response) {
              console.log("ajax通信に成功しました");
              console.log(response[0]);
              console.log(response[1]);
              document.cookie = 'course_id=<?php echo $_GET["course_id"]; ?>';
              document.cookie = 'status_text=完了';
//              document.cookie = 'nowtime='+response[1];
              document.cookie = 'pause_or_ended=ended';
              $('#status').load('./ajax_successed.php');

<?php

// // 再生完了した時にhistoryテーブルに書き込む
// $historyQuery = "INSERT INTO `history`(`course_id`,`course_name`,`user_id`,`datetime`,`status`)
//     VALUES ('".$_GET["course_id"]."',
//     '".$courseName."',
//     '".$_SESSION['id']."',
//     '".$now."',
//     '".$status."')";
//
// // 既に受講済みの講座の場合は、書き込まない
// if ($statusText != '完了' ) {
//   mysqli_query($link,$historyQuery);
// }
?>
              //$('#response').html(response[0]+', '+response[1]);
          }
      });
  });

      // 動画再生
//     event.target.playVideo();
   }
   // 再生中のとき
   if (ytStatus == YT.PlayerState.PLAYING) {
       console.log('再生中');
   }
 //   // 停止中のとき
   if (ytStatus == YT.PlayerState.PAUSED) {
        console.log('停止中');
        console.log(ytPlayer.getCurrentTime());

            //ajax送信
            $.ajax({
                url : "ajax.php",
                type : "POST",
                dataType:"json",
                data : {status:ytPlayer.getCurrentTime()},
                error : function(XMLHttpRequest, textStatus, errorThrown) {
                    console.log("ajax通信に失敗しました");
                },
                success : function(response) {
                    console.log("ajax通信に成功しました");
                    console.log('停止時間は'+response[0]);
                    console.log('今の時刻は'+response[1]);
                    document.cookie = 'course_id=<?php echo $_GET["course_id"]; ?>';
                    document.cookie = 'status_text='+ytPlayer.getCurrentTime();
                    document.cookie = 'pausetime='+response[0];
//                    document.cookie = 'nowtime='+response[1];
                    document.cookie = 'pause_or_ended=pause';
                    $('#status').load('./ajax_successed.php');
      <?php

      // $pausetime = $_COOKIE["pausetime"];
      //
      // // 再生完了した時にhistoryテーブルに書き込む
      // $historyQuery = "INSERT INTO `history`(`course_id`,`course_name`,`user_id`,`datetime`,`status`)
      //     VALUES ('".$_GET["course_id"]."',
      //     '".$courseName."',
      //     '".$_SESSION['id']."',
      //     '".$now."',
      //     '".$pausetime."')";
      //
      // // 既に受講済みの講座の場合は、書き込まない
      // if ($statusText != '完了' ) {
      //   mysqli_query($link,$historyQuery);
      // }
      ?>
                    //$('#response').html(response[0]+', '+response[1]);
                }
            });

   }
 //   // バッファリング中のとき
  if (ytStatus == YT.PlayerState.BUFFERING) {
     console.log('バッファリング中');
  }
 //   // 頭出し済みのとき
 if (ytStatus == YT.PlayerState.CUED) {
      console.log('頭出し済み');
 }
}


// ページを離脱しようとした時の挙動
$(window).on("beforeunload",function(e){
  ytPlayer.pauseVideo();
  console.log('停止しました');
  //return "任意のメッセージ";
});

</script>
<!-- ▲ このページ用JS ▲ -->
<?php
include($_SERVER['DOCUMENT_ROOT']."/_include/body_end.php");

?>
