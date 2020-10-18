<?php
session_start();
header('X-FRAME-OPTIONS:DENY');
ini_set("display_errors",1);
error_reporting(E_ALL);

if(isset($_SESSION)){
  $name = $_SESSION['name'];
  $mail = $_SESSION['mail'];
  $content = $_SESSION['content'];
}

  $token = bin2hex(random_bytes(32));
  $_SESSION['token'] = $token;

function sanitize_br($str){
  return nl2br(htmlspecialchars($str, ENT_QUOTES, 'UTF-8'));
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
            <a class="nav-link active" href="info.php">お問い合わせ</a>
          </li>
        </ul>
      </div>
    </nav>
  </div>
  <br><br><br><br>

  <div class="container">
    <h1 class="border-bottom">確認画面</h1><br>

    <form action="complete.php" method='post'>
      <input type="hidden" name='token' value='<?php echo $token;?>'>

          <p class="con-title">氏名</p>
          <p><?php echo $name;?></p>
          <p class="con-title">メールアドレス</p>
          <p ><?php echo $mail;?></p>
          <p class="con-title">お問い合わせ内容</p>
          <p ><?php echo sanitize_br($content);?></p>
          <br>

      <div class="form-group row">
        <div class="offset-2 col-8">
          <input type="submit" name="submit" class="btn btn-primary btn-block submi" value="お問い合わせ内容を送信する"　onClick="return check();"></input>
        </div>
      </div>
    </form>

    <div class="text-center mb-4">
        <a href="info.php?re=rewrite" class="btn btn-primary offset-2 col-8 btn-block submi">書き直す</a>
    </div>
    
  </div>

  <footer>
    &copy; 2020 PGL Typing Game
  </footer>






<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
 
<!-- 外部ライブラリ -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
 
<!-- 自サイトJavaScript -->
<script src="game/game.js"></script>

<script defer src="https://use.fontawesome.com/releases/v5.7.2/js/all.js"></script>
</body>

</html>