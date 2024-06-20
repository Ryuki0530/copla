<?php
require_once __DIR__ . '/../apk/connectDB.php';
require_once __DIR__ . '/../etc/Settings.php';

session_start();

function singlePost() {
    global $pdo;

    $genreeName =  ['NULL','その他','授業','部活・サークル','研究室','就活','イベント','記事'];

    $iD = isset($_GET['iD']) ? (int)$_GET['iD'] : 0;

    try {
        if (!$pdo) {
            throw new Exception("Database connection failed");
        }

        // 投稿を取得するクエリ
        $sql = "SELECT `postID`, `userID`, `genre`, `body`, `pic`, `location`, `datetime`, `fav`,`title` FROM `posts` WHERE `postID` = :iD";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':iD', $iD, PDO::PARAM_INT);
        $stmt->execute();
        $post = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($post) {
            $userID = $post['userID'];
            // 投稿者の名前を取得するクエリ
            $sql2 = "SELECT `idName` FROM `users` WHERE `userID` = :userID";
            $userStmt = $pdo->prepare($sql2);
            $userStmt->execute(['userID' => $userID]);
            $idName = $userStmt->fetchColumn();
            $post['idName'] = $idName;

            // いいね数を取得するクエリ
            $sql3 = "SELECT COUNT(*) as likeCount FROM `post_likes` WHERE `postID` = :postID";
            $likeStmt = $pdo->prepare($sql3);
            $likeStmt->execute(['postID' => $iD]);
            $likeCount = $likeStmt->fetchColumn();
            $post['likeCount'] = $likeCount;

            // 返信を取得するクエリ
            $sql4 = "SELECT `repID`, `userID`, `body`, `datetime` FROM `replies` WHERE `postID` = :postID ORDER BY `datetime` ASC";
            $replyStmt = $pdo->prepare($sql4);
            $replyStmt->execute(['postID' => $iD]);
            $replies = $replyStmt->fetchAll(PDO::FETCH_ASSOC);

            $post['replies'] = array();

            foreach ($replies as $reply) {
                $replyUserID = $reply['userID'];
                // 返信者の名前を取得するクエリ
                $sql5 = "SELECT `idName` FROM `users` WHERE `userID` = :userID";
                $replyUserStmt = $pdo->prepare($sql5);
                $replyUserStmt->execute(['userID' => $replyUserID]);
                $replyIDName = $replyUserStmt->fetchColumn();
                $reply['idName'] = $replyIDName;

                // 返信のいいね数を取得するクエリ
                $sql6 = "SELECT COUNT(*) as likeCount FROM `reply_likes` WHERE `repID` = :repID";
                $replyLikeStmt = $pdo->prepare($sql6);
                $replyLikeStmt->execute(['repID' => $reply['repID']]);
                $replyLikeCount = $replyLikeStmt->fetchColumn();
                $reply['likeCount'] = $replyLikeCount;

                $post['replies'][] = $reply;
            }
        }

        if ($post) {
            echo '
            <br>
            <article>
                <div class="wrapper">
                    <div class="nameArea">
                        <p class="genre">' . $genreeName[$post["genre"]] . '</p>
                        <p class="username">' . $post["idName"] . '</p>
                        <font size="2px">
                            <time>' . $post["datetime"] . '</time>
                        </font>
                    </div>
            ';

            if ($post["genre"] == 7) {
                echo '<h1>' . $post["title"] . '</h1><br>';
            }

            echo '
                    <p class="comment">' . $post["body"] . '</p></font>';

            if ($post["pic"] != '') {
                echo '<img src="../../../userImages/post/' . $post["pic"] . '" alt="" title="" width="96%" height="65%">';
            }

            echo '<br>
            <button class="likePostButton" data-post-id="' . $post["postID"] . '">♡</button>   
            : ' . $post["likeCount"] . '
            ';

            echo '
            <div class="reply-form">
                <form class="replyForm" data-post-id="' . $post["postID"] . '">
                    <br><textarea class="replyTextArea" name="replyBody" style="width: 88%; height: 10%; box-sizing: border-box; font-size: 200%" maxlength="300"></textarea>
                    <input class="submitButton" type="submit" value="返信" style="font-size: 100%">
                </form><hr>
            ';
            
            if (empty($post['replies'])) {
                echo "まだ返信はありません。";
            }

            foreach ($post['replies'] as $reply) {
                echo '
                <div class="reply">
                    <div class="nameArea">
                        <p class="username">' . $reply["idName"] . '</p>
                        <font size="2px">
                            <time>' . $reply["datetime"] . '</time>
                        </font>
                    </div>
                    <p class="comment">' . $reply["body"] . '</p>
                    <p class="likes">いいね: ' . $reply["likeCount"] . '</p>
                    <input type="hidden" id="postIdOf' . $reply["repID"] . '" name="postId" value="' . $post["postID"] . '">';
                    
                    $stmt = $pdo->prepare("SELECT COUNT(*) FROM `reply_likes` WHERE `repID` = :rid AND `userID` = :usid");
                    $stmt->bindParam(':rid',$reply["repID"],PDO::PARAM_INT);
                    $stmt->bindParam(':usid',$_SESSION["userID"],PDO::PARAM_INT);
                    $stmt->execute();
                    $favCount = $stmt->fetchColumn();

                    echo'<button class="likeReplyButton" data-reply-id="' . $reply["repID"] . '">♡</button>: ' . $reply["likeCount"] . '</p>';   
                   

               echo'</div>
                <br>';
            }

            echo '
                <div class="reply-form">
                    <form class="replyForm" data-post-id="' . $post["postID"] . '">
                        <br><textarea class="replyTextArea" name="replyBody" style="width: 88%; height: 50%; box-sizing: border-box; font-size: 200%" maxlength="300"></textarea>
                        <input class="submitButton" type="submit" value="返信" style="font-size: 100%">
                    </form>
                </div>
            </article>
            ';
        }
    } catch (Exception $e) {
        error_log("Error fetching post: " . $e->getMessage());
    }
}

singlePost();
?>
