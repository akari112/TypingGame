<?php
session_start();
header('X-FRAME-OPTIONS:DENY');
ini_set("display_errors",1);
error_reporting(E_ALL);

$errors = [];

if(isset($_POST['submit'])){
  $name = htmlspecialchars($_POST['name'],ENT_QUOTES);
  $mail = htmlspecialchars($_POST['mail'],ENT_QUOTES);
  $content = htmlspecialchars($_POST['content'],ENT_QUOTES);

  if($name == ""){
    $errors['name'] = 'blank';
  }
  if($mail == ""){
    $errors['mail'] = 'blank';
  }
  if($content == ""){
    $errors['content'] = 'blank';
  }
  if(mb_strlen($content) > 200){
    $errors['content'] = 'length';
  }
  if(count($errors) == 0){
    $_SESSION['name'] = $name;
    $_SESSION['mail'] = $mail;
    $_SESSION['content'] = $content;

    header('Location: check.php');
    exit();
  }
}

if(isset($_GET['re']) && $_GET['re'] === 'rewrite'){
  $name = $_SESSION['name'];
  $mail = $_SESSION['mail'];
  $content = $_SESSION['content'];
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" charset="utf-8">
  <title>PGL Typing Game|お問い合わせ</title>
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
              <a href="#" class="dropdown-item disabled">Python(Coming soon)</a>
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

  <div class="main">
    <br>
    <br>
    <br>
    <h1 class="border-bottom">お問い合わせ</h1><br>
    <p>お問い合わせの内容は、受付日から3日以内をめどにご返信いたします。</p><br>
    <form action="" method="post" name="al_form">
        <div class="form-group row">
            <label for="name" class="offset-1 col-3 col-form-label">氏名</label>
            <div class="col-7">
                <input placeholder="例: 田中太郎" id="name" type="text" class="form-control" name="name" value="<?php if(isset($name)){echo $name;}?>">
            </div>
        </div>
        <div>
        <p class="erorr"><?php if(!empty($errors['name']) && $errors['name'] === 'blank'){echo '*氏名が記入されていません。';}?></p>
        </div>

        <div class="form-group row">
            <label for="mail" class="offset-1 col-3 col-form-label">メール</label>
            <div class="col-7">
                <input placeholder="例: example@com" id="mail" type="email" class="form-control" name="mail" value="<?php if(isset($mail)){echo $mail;}?>">
            </div>
        </div>
        <p class="erorr"><?php if(!empty($errors['mail']) && $errors['mail'] === 'blank'){echo '*メールアドレスが記入されていません。';}?></p>

        <div class="form-group row">
            <label for="content" class="offset-1 col-3 col-form-label">内容</label>
            <div class="col-7">
                <textarea placeholder="200文字以内でお問い合わせ内容をご記入ください" id="content"  cols="60" rows="7" class="form-control fact" name="content"><?php if(isset($content)){echo $content;}?></textarea>
            </div>
        </div><br>
        <p class="erorr"><?php if(!empty($errors['content']) && $errors['content'] === 'blank'){echo '*お問い合わせ内容が記入されていません。';}?></p>
        <p class="erorr"><?php if(!empty($errors['content']) && $errors['content'] === 'length'){echo '*お問い合わせ内容の文字数が200文字を超えています';}?></p>

        <div class="form-group row">
            <div class="offset-2 col-8">
                <input type="submit" name="submit" class="btn btn-primary btn-block submi" value="お問い合わせ内容を確認する"　onClick="return check();"></input>
            </div>
        </div>
    </form>
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