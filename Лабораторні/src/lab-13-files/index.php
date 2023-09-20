<?php
require_once ("config.php");
if (empty($_SESSION['user_id']))
{
    header("location: /login.php");
    exit;
}

if (!empty($_POST['comment']))
{
    $stmt = $dbConn->prepare("INSERT INTO comments(`user_id`, `comment`) VALUES (:user_id, :comment)");
    $stmt->execute(array(
        'user_id' => $_SESSION['user_id'],
        'comment' => $_POST['comment']
    ));
}
$stmt = $dbConn->prepare("SELECT * FROM comments ORDER BY id DESC");
$stmt->execute();
$comments = $stmt->fetchAll();
?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Коментарі</title>
    <style>
        #comments-header{ text-align: center;}
        #comments-form{border: 1px dotted black; width: 50%; padding-left: 20px;}
        #comments-form textarea{width: 70%; min-height: 100px;}
        #comments-panel{border: 1px dashed black; width: 50%; padding-left: 20px; margin-top: 20px;}
        .comment-date{font-style: italic}
    </style>
</head>
<body>
    <div id="comments-header">
        <h1>Коментарі</h1>
    </div>
    <div id="comments-form">
        <h3>Будь-ласка, залиште свій кометар</h3>
        <form method="POST">
            <div>
                    <textarea name="comment"></textarea>
            </div>
            <div>
                <br>
                <input type="submit" name="submit" value="Відправити">
            </div>
        </form>
    </div>
    <div id="comments-panel">
        <h3>Коментарі:</h3>
        <?php foreach ($comments as $comment): ?>
        <p <?php if ($comment['user_id'] == $_SESSION['user_id']) echo 'style="font-weight: bold;"';
?>><?php echo $comment['comment']; ?> <span class="comment-date">(<?php echo $comment['created_at']; ?>)</span></p>
        <?php
endforeach; ?>
    </div>
</body>
</html>
