<?php
require_once __DIR__ . '/../apk/connectDB.php';
require_once __DIR__ . '/../etc/Settings.php';

function singlePost() {
    global $pdo, $postArray;

    $genreeName =  ['NULL','その他','授業','部活・サークル','研究室','就活','イベント','記事'];

    $iD = $_GET['iD'];
    

    try {
        if (!$pdo) {
            throw new Exception("Database connection failed");
        }


       
        $sql = "SELECT `postID`, `userID`, `genre`, `body`, `pic`, `location`, `datetime`, `fav`,`title` FROM `posts` WHERE `postID`=:iD";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':iD', $iD, PDO::PARAM_INT);
        
        $stmt->execute();
        $postArray = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($postArray as &$Post) {
            $userID = $Post['userID'];
            $sql2 = "SELECT `idName` FROM `users` WHERE `userID` = :userID";
            $userStmt = $pdo->prepare($sql2);
            $userStmt->execute(['userID' => $userID]);
            $idName = $userStmt->fetchColumn();
            $Post['idName'] = $idName;

            $postID = $Post['postID'];
            $sql3 = "SELECT COUNT(*) as likeCount FROM `post_likes` WHERE `postID` = :postID";
            $likeStmt = $pdo->prepare($sql3);
            $likeStmt->execute(['postID' => $postID]);
            $likeCount = $likeStmt->fetchColumn();
            $Post['likeCount'] = $likeCount;

            $sql4 = "SELECT `repID`, `userID`, `body`, `datetime` FROM `replies` WHERE `postID` = :postID ORDER BY `datetime` ASC;";
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
            <br>
            <article>
            <a href = "post.html?iD='.$Post["postID"].'"style = "text-decoration: none;"><font color="#000000">
                <div class="wrapper">
                    <div class="nameArea">
                        <p class="genre">' . $genreeName[$Post["genre"]] . '</p>
                        <p class="username">' . $Post["idName"] . '</p>
                        <font size="2px">
                            <time>' . $Post["datetime"] . '</time>
                        </font>
                    </div>
            ';

            if ($Post["genre"] == 7) {
                echo '<h1>' . $Post["title"] . '</h1><br>';
            }

            echo '
                    <p class="comment">' . $Post["body"] . '</p></font></a>';

            if(!$Post["pic"]==''){
                echo'<img src="../../../userImages/post/'.$Post["pic"].'" alt="" title="" width="96%" height="65%">';
            }

            echo'<br>
            <button class="likePostButton" data-post-id="' . $Post["postID"] . '">♡</button>   
            : ' . $Post["likeCount"] . '
            ';

       
            foreach ($Post['replies'] as $Reply) {
                echo "<hr>";
                echo ($Reply["repID"]);
                echo '
                <div class="reply">
                    <div class="nameArea">
                        <p class="username">' . $Reply["idName"] . '</p>
                        <font size="2px">
                            <time>' . $Reply["datetime"] . '</time>
                        </font>
                    </div>
                    <p class="comment">' . $Reply["body"] . '</p>
                    <p class="likes">いいね: ' . $Reply["likeCount"] . '</p>
                    <input type="hidden" id="postIdOf' . $Reply["repID"] . '" name="postId" value="'.$Post["postID"].'">
                    <button class="likeReplyButton" data-reply-id="' . $Reply["repID"] . '">いいね</button>
                </div>
                <br>';
            }           

            echo '
                <div class="reply-form">
                    <form class="replyForm" data-post-id="' . $Post["postID"] . '">
                        <br><textarea class="replyTextArea" name="replyBody" style="width: 88%; height: 50%; box-sizing: border-box; font-size: 200%" maxlength="300"></textarea>
                        <input class="submitButton" type="submit" value="返信" style="font-size: 100%">
                    </form>
                </div>
            </article>
            ';
        }
        
            
        
    } catch (Exception $e) {
        error_log("Error fetching posts: " . $e->getMessage());
    }
}

singlePost();
?>
