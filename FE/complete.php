<?php
    $username = htmlspecialchars($_POST['username'], ENT_QUOTES|ENT_HTML5, "UTF-8");
    $password = htmlspecialchars($_POST['password'], ENT_QUOTES|ENT_HTML5, "UTF-8");
    $repassword = htmlspecialchars($_POST['repassword'], ENT_QUOTES|ENT_HTML5, "UTF-8");

    #フォームが全て入力されているかチェックする
   if ($username === '' || $password === '' || $repassword === '' || $password !== $repassword)  {
       header('Location: error.html');
       exit();
   } 
    # connect mysql PDO
    $dsn = 'mysql:dbname=user;host=localhost';
    $user = 'root';
    $dbpassword = 'Pa$$w0rd';
    /* ソルトを加えてハッシュ化 */
    $salt = substr(base_convert(hash('sha256', uniqid()), 16, 36), 0, 20);
    $hashpassword = hash('sha256', $_POST["password"].$salt);

    $pdo = new PDO($dsn, $user, $dbpassword);
    $sql = $pdo->prepare("INSERT into form (username, password) values (:username, :password)");

    # bindPramで:nameなどを変数$nameに設定、PARAM_でデータ型を指定
    $sql->bindParam( ':username', $username, PDO::PARAM_STR);
    $sql->bindParam( ':password', $hashpassword, PDO::PARAM_STR);

    $res = $sql->execute();
    $pdo = null;

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet" type="text/css" media="all">
    <title>Flash Explorer 登録完了</title>
</head>
<body>
    <div class="completeflex">
        <h2>ようこそ<?= $username ?>さん</h2>
        <p>登録完了しました。</p>
    </div>
</body>
</html>