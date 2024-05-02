<?php
//XSS対応（ echoする場所で使用！それ以外はNG ）
function h($str){
    return htmlspecialchars($str, ENT_QUOTES);
}

//DB接続関数：db_conn()
function db_conn(){
    try {
      // Password:MAMP='root',XAMPP=''
      $db_name = "php_form_login"; //データベース名
      $db_id = "root"; //アカウント名
      $db_pw =""; //パスワード
      $db_host = "localhost"; //DBホスト
      return new PDO('mysql:dbname='.$db_name.';charset=utf8;host='.$db_host,$db_id,$db_pw);



    } catch (PDOException $e) {
      exit('DB_CONECT:'.$e->getMessage());
    }
    }


//SQLエラー関数：sql_error($stmt)
function sql_error($stmt){
    $error = $stmt->errorInfo();
    exit("SQL_ERROR:".$error[2]);
  }



//リダイレクト関数: redirect($file_name)
function redirect($file_name){
    //５．read.phpへリダイレクト
  header("Location: "."$file_name");
  exit();
  }

  //SessionCheck(スケルトン)
function sschk(){
  if(!isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"]!=session_id()){
    exit("Login Error");
 }else{
    session_regenerate_id(true);//SESSION KEYを入れ替える関数
    $_SESSION["chk_ssid"] = session_id();
 }
}

