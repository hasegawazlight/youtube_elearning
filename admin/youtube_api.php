<?php

// DATABASE に接続
include($_SERVER['DOCUMENT_ROOT']."/_include/connection.php");



//ajax送信でPOSTされたデータを受け取る
//$status = $_POST["course_id"];
//$datetime = $_POST['datetime'];
//受け取ったデータを配列に格納
//$return_array = array($status);
//「$return_array」をjson_encodeして出力
//echo json_encode($return_array);
?>

<script>

$(function(course_id) {
  $.getJSON("https://www.googleapis.com/youtube/v3/videos?id=<?php echo $_POST["video_id"]; ?>&key=AIzaSyAXaf1hhDGFxS5LaQkrKmHezQ8qQkgeqwM&part=snippet,contentDetails" , function(data) {

  console.log('タイトルは'+data["items"][0]["snippet"]["title"]);
  console.log('動画の長さは'+data["items"][0]["contentDetails"]["duration"]);

  var course_name = data["items"][0]["snippet"]["title"];
  var duration_api = data["items"][0]["contentDetails"]["duration"];
    console.log(hmsToSec(duration_api));
    document.cookie = 'course_name='+course_name;
    document.cookie = 'course_time='+hmsToSec(duration_api);
    document.cookie = 'course_id=<?php echo $_POST["video_id"]; ?>';


  $('#youtubeapi').load( '/admin/youtube_api_sql.php');
  });




/**
* YouTube DATA API で返ってきた動画の長さを合計秒数に整形する
*　@return duration_sec
*/
function hmsToSec(duration){

  /**
  * 変数定義
  */
  var duration_h_sec ="";
  var duration_m_sec ="";
  var duration_s_sec ="";


  /**
  * 時間（hour）取得し、秒（Sec）に変換
  */
  if (duration.match(/H/)) {
    var duration_h = duration.split("H");
    duration_h = parseInt(duration_h[0].replace( /PT/g , "" ));
    duration_h_sec = duration_h * 60 * 60;
  }

  /**
  * 分（Min）取得し、秒（Sec）に変換
  */
  if (duration.match(/M/)) {
    if (duration.match(/H/)) {
      // 1時間以上の動画の場合
      var duration_m = duration.split("H");
      var duration_m = duration_m[1].split("M");
      var duration_m = parseInt(duration_m[0]);
    }else{
      // 1時間未満の動画の場合
      var duration_m = duration.split("M");
      duration_m = parseInt(duration_m[0].replace( /PT/g , "" ));
    }
    duration_m_sec = duration_m * 60;

  /**
  * 秒（Sec）取得
  */
    // 1分以上の動画の場合
    var duration_s = duration.split("M");
    duration_s_sec = parseInt(duration_s[1].replace( /S/g , "" ));
  }else{
    // 1分未満の動画の場合
    var duration_s = duration.split("S");
    duration_s_sec = parseInt(duration_s[0].replace( /PT/g , "" ));
  }


  /**
  *　時間（Hour）＋分（Min）＋秒（Sec）の合計 秒（Sec）取得
  */
  if(duration_h_sec != ""){
    var duration_sec = duration_s_sec+duration_m_sec+duration_h_sec;
  }else if(duration_m_sec != ""){
    var duration_sec = duration_s_sec+duration_m_sec;
  }else{
    var duration_sec = duration_s_sec;
  }

  return duration_sec;

}


});

</script>
