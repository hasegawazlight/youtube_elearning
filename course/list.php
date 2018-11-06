<?php



// DATABASE に接続
include($_SERVER['DOCUMENT_ROOT']."/_include/connection.php");

// meta情報
$title = "講座一覧";


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
    <h1 id="appSummary">講座一覧</h1>

    <form action="<?php echo $_SERVER["REQUEST_URI"]; ?>" method="get">
      <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="キーワード検索" aria-label="Recipient's username" aria-describedby="button-addon2" name="search">
          <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="submit" id="button-addon2">検索</button>
          </div>
      </div>
    </form>

<?php

  // 現在のページ数
  if (array_key_exists('page', $_GET)) {
    $page = $_GET['page'];
    intval($page);
    $page = $page - 1;
  }else{
    $page = 0;
  }


  // 登録されている講座一覧を取得
  // searchパラメータ有無でクエリを出し分ける
  if (array_key_exists('search', $_GET)) {
    $search = $_GET['search'];
?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
      <strong>「 <?php echo $search; ?> 」</strong>で検索した結果
      <button type="button" id="js-search-close" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
<?php
    $listQuery = 'SELECT * FROM course WHERE course_name LIKE "%'.$search.'%" ORDER BY sort LIMIT 1 OFFSET '.$page;
    $listCountQuery = 'SELECT * FROM course WHERE course_name LIKE "%'.$search.'%"';
  }else{
    $listQuery = 'SELECT * FROM course ORDER BY sort LIMIT 1 OFFSET '.$page;
    $listCountQuery = 'SELECT * FROM course ORDER BY sort';
  }


  // Hitした講座数を取得

  if ($listCountResult = mysqli_query($link,$listCountQuery)) {
    $listCountNum = 0;
    while($row = mysqli_fetch_array($listCountResult)){
      $listCountNum++;
    }
  }
?>


    <div class="row ml-0 mr-0">


<?php

  // Hitした講座一覧を取得
  if ($listResult = mysqli_query($link,$listQuery)) {
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
    }
  }
?>

    </div>
  </div>


<?php


function pager($c, $t) {
    $current_page = $c;     //現在のページ
    $total_rec = $t;    //総レコード数
    $page_rec   = 1;   //１ページに表示するレコード
    $total_page = ceil($total_rec / $page_rec); //総ページ数
    $show_nav = 3;  //表示するナビゲーションの数

  $path = '?page=';
    if (array_key_exists('search', $_GET)){
      $path = '?search='.$_GET['search'].'&page=';
    }else{
      $path = '?page=';
    }


    //全てのページ数が表示するページ数より小さい場合、総ページを表示する数にする
    if ($total_page < $show_nav) {
        $show_nav = $total_page;
    }
    //トータルページ数が2以下か、現在のページが総ページより大きい場合表示しない
    if ($total_page <= 1 || $total_page < $current_page ) return;
    //総ページの半分
    $show_navh = floor($show_nav / 2);
    //現在のページをナビゲーションの中心にする
    $loop_start = $current_page - $show_navh;
    $loop_end = $current_page + $show_navh;
    //現在のページが両端だったら端にくるようにする
    if ($loop_start <= 0) {
        $loop_start  = 1;
        $loop_end = $show_nav;
    }
    if ($loop_end > $total_page) {
        $loop_start  = $total_page - $show_nav +1;
        $loop_end =  $total_page;
    }
    ?>
    <div id="pagenation" class="container mt-5">
      <nav aria-label="Page navigation example">
        <ul class="pagination">
            <?php
            //最初のページ以外だったら「前へ」を表示
            if ( $current_page > 1) echo '<li class="prev page-item"><a href="'. $path . ($current_page-1).'" class="page-link">&lsaquo;</a></li>';
            //2ページ移行だったら「一番前へ」を表示
            if ( $current_page > 2) echo '<li class="prev page-item"><a href="'. $path .'1" class="page-link">1</a></li><li class="page-item disabled"><a class="page-link">…</a></li>';
            for ($i=$loop_start; $i<=$loop_end; $i++) {
                if ($i > 0 && $total_page >= $i) {
                    if($i == $current_page) echo '<li class="active page-item">';
                    else echo '<li>';
                    echo '<a href="'. $path . $i.'" class="page-link">'.$i.'</a>';
                    echo '</li>';
                }
            }
            //最後から２ページ前だったら「一番最後へ」を表示
            if ( $current_page < $total_page - 1) echo '<li class="page-item disabled"><a class="page-link">…</a></li><li class="next page-item"><a href="'. $path . $total_page.'" class="page-link">'.$t.'</a></li>';
            //最後のページ以外だったら「次へ」を表示
            if ( $current_page < $total_page) echo '<li class="next page-item"><a href="'. $path . ($current_page+1).'" class="page-link">&rsaquo;</a></li>';
            ?>
        </ul>
      </nav>
    </div>
    <?php
}

//現在のページ, 総レコード数
pager($page+1, $listCountNum);
?>


<?php

// 共通FOOTER
include($_SERVER['DOCUMENT_ROOT']."/_include/footer.php");

// 共通JS
include($_SERVER['DOCUMENT_ROOT']."/_include/common_js.php");
?>
<!-- ▼ このページ用JS ▼ -->

<script>
  $(function(){

    // 検索結果アラートCLOSEで、GETパラメータを削除する。
    $('#js-search-close').click(function(){
      setTimeout(function() {
        document.location.href = window.location.pathname;
      }, 100);
    });

  });
</script>

<!-- ▲ このページ用JS ▲ -->
<?php
include($_SERVER['DOCUMENT_ROOT']."/_include/body_end.php");

?>
