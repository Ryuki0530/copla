<?php
require_once __DIR__ . '/../apk/connectDB.php';
require_once __DIR__ . '/../etc/Settings.php';
session_start();

function getPosts() {
    global $pdo, $postArray;

    $genreeName =  ['NULL','その他','授業','部活・サークル','研究室','就活','イベント','記事'];

    $offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 20;
    $genre = isset($_GET['genre']) && $_GET['genre'] !== '' ? (int)$_GET['genre'] : null;

    try {
        if (!$pdo) {
            throw new Exception("Database connection failed");
        }


        if ($genre !== null) {
            $sql = "SELECT `postID`, `userID`, `genre`, `body`, `pic`, `location`, `datetime`, `fav`,`title` FROM `posts` WHERE `genre` = :genre ORDER BY `datetime` DESC LIMIT :offset, :limit";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':genre', $genre, PDO::PARAM_INT);
        } else {
            $sql = "SELECT `postID`, `userID`, `genre`, `body`, `pic`, `location`, `datetime`, `fav`,`title` FROM `posts` ORDER BY `datetime` DESC LIMIT :offset, :limit";
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

        //返信生成
        foreach ($postArray as $Post) {

            echo'
            
            ';
        }
    } catch (Exception $e) {
        error_log("Error fetching posts: " . $e->getMessage());
    }

}

getPosts();
?>
