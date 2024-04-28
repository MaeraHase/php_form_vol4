<?php
//0. SESSION開始！！
session_start();

//【重要】
//insert.phpを修正（関数化）してからselect.phpを開く！！
//１．関数群の読み込み
include("funcs.php");
$pdo = db_conn();
// try {
//   $db_name = "php_form";     //データベース名
//   $db_id   = "root";      //アカウント名
//   $db_pw   = "";          //パスワード：XAMPPはパスワード無しに修正してください。
//   $db_host = "localhost"; //DBホスト
//   $pdo = new PDO('mysql:dbname='.$db_name.';charset=utf8;host='.$db_host, $db_id, $db_pw);
// } catch (PDOException $e) {
//   exit('DB Connection Error:'.$e->getMessage());
// }

//LOGINチェック → funcs.phpへ関数化しましょう！↓
// if(!isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"]!=session_id()){
//    exit("Login Error");
// }else{
//    session_regenerate_id(true);//SESSION KEYを入れ替える関数
//    $_SESSION["chk_ssid"] = session_id();
// }
sschk();//ログインしないとアクセスできないようにする

//２．データ登録SQL作成
$sql = "SELECT * FROM php_form"; //'php_form_login'又は'$db_name'にするとページが開かなくなる。
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

//３．データ表示
$values = "";
if($status==false) {
    sql_error($stmt);
//   $error = $stmt->errorInfo();
//   exit("SQLError:".$error[2]);
}

//全データ取得
$values =  $stmt->fetchAll(PDO::FETCH_ASSOC); //PDO::FETCH_ASSOC[カラム名のみで取得できるモード]
// $json = json_encode($values,JSON_UNESCAPED_UNICODE);

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>おすすめしたい本</title>
<link rel="stylesheet" href="form.css">
<link href="form.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>
</head>
<body id="main">
<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
      <p class="navbar-brand1"> <?=$_SESSION["name"]?>さんこんにちは！</p>
      <a class="navbar-brand2" href="index.php">データ登録</a><var>
      <a class="navbar-brand3" href="logout.php">ログアウト</a><var>
      </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<div>
    <div class="container jumbotron">

      <table>
      <?php foreach($values as $v){ ?>
        <tr>
          <td><?=h($v["name"])?></td>
          <td><?=h($v["email"])?></td>
          <td><?=h($v["book_name"])?></td>
          <td><?=h($v["point"])?></td>
          <td><?=h($v["comment"])?></td>
          <td><a id='updatebutton' href="detail.php?id=<?=h($v["id"])?>">更新</a></td>
          <?php 
          if($_SESSION["kanri_flg"]=="1"){
            // echo ($_SESSION["kanri_flg"]);
            echo ("<td><a id='deletebutton' href='javascript:deleteralart()'>削除</a></td>");
            // echo ("<td><a id='deletebutton' href='delete.php?id=". h($v["id"]) ." '>[削除]</a></td>");
            // <td><a href="delete.php?id=<?=h($v["id"])">[削除]</a></td> 
           } ?>
        </tr>
      <?php } ?>
      </table>

  </div>
</div>
<!-- Main[End] -->

<!-- <script>
  const a = '<?php echo $json; ?>';
  console.log(JSON.parse(a));
</script> -->

<script>
function deleteralart(){
  let result = confirm('削除しますか');
if(result){
  location.href = 'delete.php?id=<?php echo h($v["id"]); ?>';//JSでページへ飛ばす処理。echo必須

  console.log('削除しました');
}else{
  console.log('削除をとりやめました');
}
}

</script> 
</body>
</html>
