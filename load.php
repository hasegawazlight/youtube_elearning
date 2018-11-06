<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>トップページ</title>

</head>

<body>

  <div id="container">



  </div>


<!-- ▼ 共通JS ▼ -->
<script src="/_libs/jquery-3.3.1.min.js"></script>

<script>

  $(function(){
    $('#container').load('index.php #appSummary',function() {
      alert($('#container').height());
    });
  });

</script>

<!-- ▲ このページ用JS ▲ -->

</body>
</html>
