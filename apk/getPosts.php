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

            // 各投稿に対するいいねの数を取得
            $postID = $Post['postID'];
            $sql3 = "SELECT COUNT(*) as likeCount FROM `post_likes` WHERE `postID` = :postID";
            $likeStmt = $pdo->prepare($sql3);
            $likeStmt->execute(['postID' => $postID]);
            $likeCount = $likeStmt->fetchColumn();
            $Post['likeCount'] = $likeCount;

            // 各投稿に対する返信を取得
            $sql4 = "SELECT `repID`, `userID`, `body`, `datetime` FROM `replies` WHERE `postID` = :postID ORDER BY `datetime` DESC;";
            $replyStmt = $pdo->prepare($sql4);
            $replyStmt->execute(['postID' => $postID]);
            $replies = $replyStmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($replies as &$Reply) {
                $replyUserID = $Reply['userID'];
                $sql5 = "SELECT `idName` FROM `users` WHERE `userID` = :userID";
                $replyUserStmt = $pdo->prepare($sql5);
                $replyUserStmt->execute(['userID' => $replyUserID]);
                $replyIDName = $replyUserStmt->fetchColumn();
                $Reply['idName'] = $replyIDName;

                // 各返信に対するいいねの数を取得
                $repID = $Reply['repID'];
                $sql6 = "SELECT COUNT(*) as likeCount FROM `reply_likes` WHERE `repID` = :repID";
                $replyLikeStmt = $pdo->prepare($sql6);
                $replyLikeStmt->execute(['repID' => $repID]);
                $replyLikeCount = $replyLikeStmt->fetchColumn();
                $Reply['likeCount'] = $replyLikeCount;
            }

            $Post['replies'] = $replies;
        }

        foreach ($postArray as $Post) {
            echo '
            <article>
                <div class="wrapper">
                    <div class="nameArea">
                        <p class="username">' . $Post["idName"] . '</p>
                        <font size="2px">
                            <time>' . $Post["datetime"] . '</time>
                        </font>
                    </div>
                    <p class="comment">' . $Post["body"] . '</p>
                    <p class="likes">いいね: ' . $Post["likeCount"] . '</p>
                    <button class="likePostButton" data-post-id="' . $Post["postID"] . '">いいね</button>
                
                <br>';

            foreach ($Post['replies'] as $Reply) {
               echo "<hr>"; 
                //echo  "repID:".$Reply["repID"] ;
                echo  '
                <div class="reply">
                    <div class="nameArea">
                        <p class="username">' . $Reply["idName"] . '</p>
                        <font size="2px">
                            <time>' . $Reply["datetime"] . '</time>
                        </font>
                    </div>
                    <p class="comment">' . $Reply["body"] . '</p>
                    <p class="likes">いいね: ' . $Reply["likeCount"] . '</p>
                    <button class="likeReplyButton" data-reply-id="' . $Reply["repID"] . '">いいね</button>
                </div>
                <br>';
            }

            echo '
                <div class="reply-form">
                <form class="replyForm" data-post-id="' . $Post["postID"] . '">
                <textarea class="replyTextArea" name="replyBody" style="width: 88%; height: 50%; box-sizing: border-box; font-size: 200%" maxlength="300"></textarea>
                <input class="submitButton" type="submit" value="返信" style="font-size: 100%">
            </form><br>
            </div>
            </article><br>';
            
        }

    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

getPosts();
?>
