<?php
require_once __DIR__ . '/../apk/connectDB.php';
require_once __DIR__ . '/../etc/Settings.php';

function searchPosts() {
    global $pdo, $postArray;

    $genreeName = ['NULL', 'その他', '授業', '部活・サークル', '研究室', '就活', 'イベント', '記事'];
    $query = isset($_GET['q']) ? trim($_GET['q']) : '';
    $offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 20;

    try {
        if (!$pdo) {
            throw new Exception("Database connection failed");
        }

        if ($query !== '') {
            $sql = "SELECT `postID`, `userID`, `genre`, `body`, `pic`, `location`, `datetime`, `fav`, `title`
                    FROM `posts`
                    WHERE `title` LIKE :query OR `body` LIKE :query
                    ORDER BY `datetime` DESC
                    LIMIT :offset, :limit";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':query', '%' . $query . '%', PDO::PARAM_STR);
        } else {
            $sql = "SELECT `postID`, `userID`, `genre`, `body`, `pic`, `location`, `datetime`, `fav`, `title`
                    FROM `posts`
                    ORDER BY `datetime` DESC
                    LIMIT :offset, :limit";
            $stmt = $pdo->prepare($sql);
        }

        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
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

            $sql4 = "SELECT `repID`, `userID`, `body`, `datetime` FROM `replies` WHERE `postID` = :postID ORDER BY `datetime` ASC";
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
            <article>
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
                    <p class="comment">' . $Post["body"] . '</p>
                    <p class="likes">いいね: ' . $Post["likeCount"] . '</p>
                    <button class="likePostButton" data-post-id="' . $Post["postID"] . '">いいね</button>
                    <br>
            ';

            $count = 0;
            foreach ($Post['replies'] as $Reply) {
                if ($count == 1) {
                    echo '<div class="repAt' . $Post["postID"] . '" style="display: none;">';
                }
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
                    <button class="likeReplyButton" data-reply-id="' . $Reply["repID"] . '">いいね</button>
                </div>
                <br>';

                $count++;
            }

            if ($count > 1) {
                $OtherRepNum = $count - 1;
                echo '</div><div class="repOpenerAt' . $Post["postID"] . '"><br>他' . $OtherRepNum . '件の返信<br>';
                echo '<button class="moreReplyButton" data-post-id="' . $Post["postID"] . '">Show more</button></div>';
            }

            echo '
                <div class="reply-form">
                    <form class="replyForm" data-post-id="' . $Post["postID"] . '">
                        <br><textarea class="replyTextArea" name="replyBody" style="width: 88%; height: 50%; box-sizing: border-box; font-size: 200%" maxlength="300"></textarea>
                        <input class="submitButton" type="submit" value="返信" style="font-size: 100%">
                    </form>
                </div>
            </article><br>
            ';
        }
    } catch (Exception $e) {
        error_log("Error fetching posts: " . $e->getMessage());
    }
}

searchPosts();
?>