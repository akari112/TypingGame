<?php
 ini_set("display_errors", "On");
// データベース接続
$dsn = 'mysql:dbname=tech;host=localhost;charset=utf8mb4';
$user = 'root';
$password = 'root';

try {
  $db = new PDO($dsn, $user, $password);
  $sql = "CREATE TABLE IF NOT EXISTS info"
  ." ("
  . "id INT AUTO_INCREMENT PRIMARY KEY,"
  . "name VARCHAR(200),"
  . "email VARCHAR(200),"
  . "content TEXT,"
  . "created DATETIME"
  .");";
  $stmt = $db->query($sql);

}catch(PDOException $e){
  echo 'DB接続エラー:'. $e->getMessage();
}
?>