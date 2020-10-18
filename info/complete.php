<?php
require('.db.php');
session_start();
header('X-FRAME-OPTIONS:DENY');
ini_set("display_errors",1);
error_reporting(E_ALL);

if(isset($_SESSION['token'], $_POST['token']) && $_POST['token'] === $_SESSION['token']){
  unset($_SESSION['token']);
  $name = $_SESSION['name'];
  $mail = $_SESSION['mail'];
  $content = $_SESSION['content'];

  $db->query('SET NAMES utf8');
  $stmt = $db->prepare('INSERT INTO info SET name=?, email=?, content=?, created=NOW()');
  $stmt->execute(array(
    $name,
    $mail,
    $content
  ));

  $_SESSION = [];

  if(ini_get("session.use_cookies")){
    $params = session_get_cookie_params();
    setcookie(session_name(),'',time() - 42000,
    $params["path"],$params["domain"],
    $params["secure"],$params["httponly"]
    );
  }
  session_destroy();
} else {
  header('Location: info.php');
  exit();
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" charset="utf-8">
  <title>PGL Typing Game</title>
  <meta name="description" content="プログラミング言語のリファレンスのタイピングゲームです。ゲーム感覚でプログラミングの練習しましょう。">

  <link rel="stylesheet" href="../hp.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

</head>

<body>
  <div class="top">
    <nav class="navbar navbar-expand-md fixed-top navbar-dark bg-primary">
      <a class="navbar-brand" href="../hp.html">PGL TypingGame</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="../hp.html">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../hp.html#rule">ルール</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              ゲーム
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a href="../game-html/html.html" class="dropdown-item">HTML</a>
              <a href="../game-html/css.html" class="dropdown-item">CSS</a>
              <a href="../game-html/js.html" class="dropdown-item">JavaScript</a>
              <a href="../game-html/php.html" class="dropdown-item">PHP</a>
              <a href="" class="dropdown-item disabled">Python(Coming soon)</a>
              <a href="#" class="dropdown-item disabled">Java(Coming soon)</a>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="info.html">お問い合わせ</a>
          </li>
        </ul>
      </div>
    </nav>
  </div>

  <div class="container">
    <br><br><br>
    <h1 class="border-bottom">送信完了</h1><br>
    <p>ありがとうございました。送信を受け付けました。</p>
    <p>3日以内をめどにご返信いたしますので、しばらくお待ちください。</p><br>
    <div class="text-center mb-4">
        <a href="info.php" class="btn btn-primary">戻る</a><br>
    </div>
  </div>

  <footer>
    &copy; 2020 PGL Typing Game
  </footer>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
 <script src="game/game.js"></script>
<script defer src="https://use.fontawesome.com/releases/v5.7.2/js/all.js"></script>
</body>
</html>