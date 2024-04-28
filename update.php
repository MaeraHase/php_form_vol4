<?php
session_start();
//PHP:コード記述/修正の流れ
//1. insert.phpの処理をマルっとコピー。
//   POSTデータ受信 → DB接続 → SQL実行 → 前ページへ戻る
//1-1. POSTデータ取得
$id        = $_POST["id"];
$name      = $_POST["name"];
$email     = $_POST["email"];
$book_name = $_POST["book_name"];
$point     = $_POST["point"];
$comment   = $_POST["comment"];


//1-2. DB接続します
include("funcs.php"); //外部ファイル読み込み
sschk();//ログインしないとアクセスできないようにする
$pdo = db_conn();


//1-３．データ登録SQL作成
$sql = "UPDATE php_form SET name=:name,email=:email,book_name=:book_name,point=:point,comment=:comment WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':name',   $name,   PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':email',  $email,  PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':book_name', $book_name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':point', $point, PDO::PARAM_STR);
$stmt->bindValue(':comment', $comment, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute(); //実行


//1-４．データ登録処理後
if($status==false){
//     //*** function化する！*****************
sql_error($stmt);
}else{
//     //*** function化する！*****************
redirect("select.php");
}

//2. $id = POST["id"]を追加


//3. SQL修正
//   "UPDATE テーブル名 SET 変更したいカラムを並べる WHERE 条件"
//   bindValueにも「id」の項目を追加


//4. header関数"Location"を「select.php」に変更
?>