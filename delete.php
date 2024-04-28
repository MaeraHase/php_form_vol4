<?php
session_start();
//1. POSTデータ取得
$id = $_GET["id"];

//2. DB接続します
include("funcs.php");
sschk(); //ログインしないとアクセスできないようにする
$pdo = db_conn();
var_dump($id);
//３．データ登録SQL作成
$stmt = $pdo->prepare("DELETE FROM php_form WHERE id=:id");
$stmt->bindValue(':id', $id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute(); //実行

//４．データ登録処理後
if($status==false){
  sql_error($stmt);
}else{
  redirect("select.php");
}
?>
