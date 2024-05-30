<?php
// デバッグ用エラーレポートを有効にする
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);


require_once __DIR__ . '/../apk/connectDB.php';
require_once __DIR__ . '/../etc/Settings.php';


function getPosts(){
    global $pdo, $postArray;
    try {
        // データベース接続確認
        if (!$pdo) {
            throw new Exception("Database connection failed");
        }

        $sql = "SELECT `postID`, `userID`, `genre`, `body`, `pic`, `location`, `datetime`, `fav` FROM `posts` ORDER BY `datetime` DESC;";
        $postArray = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

        foreach ($postArray as &$Post) {
            $userID = $Post['userID'];
            $sql2 = "SELECT `idName` FROM `users` WHERE `userID` = :userID";
            $userStmt = $pdo->prepare($sql2);
            $userStmt->execute(['userID' => $userID]);
            $idName = $userStmt->fetchColumn();
            $Post['idName'] = $idName;
        }

        // 投稿内容をHTML形式で返す
        foreach ($postArray as $Post) {
            echo '
            <article>
                <div class="wrapper">
                    <div class="nameArea">
                        <p class="username">
                            ' . $Post["idName"] . '
                        </p>
                        <font size="2px">
                            <time>'
                            . $Post["datetime"] .
                            '</time>
                        </font>
                    </div>
                    <p class="comment">
                        '.$Post["body"] .'
                    </p>
                </div>
                <br>
            </article>';
        }

    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

// getPosts()関数を呼び出す
getPosts();
?>
