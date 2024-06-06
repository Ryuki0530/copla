<?php
require_once __DIR__ . '/../apk/connectDB.php';
require_once __DIR__ . '/../etc/Settings.php';

function getPosts() {
    global $pdo, $postArray;
    try {
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

            // 各投稿に対する返信を取得
            $postID = $Post['postID'];
            $sql3 = "SELECT `repID`, `userID`, `body`, `datetime` FROM `replies` WHERE `postID` = :postID ORDER BY `datetime` ASC;";
            $replyStmt = $pdo->prepare($sql3);
            $replyStmt->execute(['postID' => $postID]);
            $replies = $replyStmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($replies as &$Reply) {
                $replyUserID = $Reply['userID'];
                $sql4 = "SELECT `idName` FROM `users` WHERE `userID` = :userID";
                $replyUserStmt = $pdo->prepare($sql4);
                $replyUserStmt->execute(['userID' => $replyUserID]);
                $replyIDName = $replyUserStmt->fetchColumn();
                $Reply['idName'] = $replyIDName;
            }

            $Post['replies'] = $replies;
        }

        foreach ($postArray as $Post) {
            $gen;
            if($Post['genre']==0)$gen="このメッセージ出るのはおかしい。";
            if($Post['genre']==1)$gen="その他";
            if($Post['genre']==2)$gen="授業";
            if($Post['genre']==3)$gen="部活";
            if($Post['genre']==4)$gen="研究室";
            if($Post['genre']==5)$gen="就活";
            if($Post['genre']==6)$gen="イベント";
            echo '
            <article>
                <div class="wrapper">
                    <div class="nameArea">
                        <p class="username">' . $Post["idName"] . '</p>
                        <font size="2px">
                            <time>' . $Post["datetime"] . '</time>
                        </font>
                        '.$gen.'
                    </div>
                    <p class="comment">' . $Post["body"] . '</p>
                    <br><hr>';

            foreach ($Post['replies'] as $Reply) {
                echo '
                <div class="reply">
                    <div class="nameArea">
                        <p class="username">' . $Reply["idName"] . '</p>
                        <font size="2px">
                            <time>' . $Reply["datetime"] . '</time>
                        </font>
                    </div>
                    <p class="comment">' . $Reply["body"] . '</p>
                </div>
                <br>';
            }

           if(!($Post['genre']==1)){ echo '
                <div class="reply-form">
                    <form class="replyForm" data-post-id="' . $Post["postID"] . '">
                        <textarea class="replyTextArea" name="replyBody" style="width: 88%; height: 50%; box-sizing: border-box; font-size: 200%" maxlength="300"></textarea>
                        <input class="submitButton" type="submit" value="返信" style="font-size: 100%">
                    </form><br>
                </div>
            </article>';
           }
           echo"</div><br>";
        }

    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

getPosts();
?>
