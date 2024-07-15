<!DOCTYPE html>
<html lang="ja">
<head>
<link rel="stylesheet" href="./../body/Home/css/stylesheet2.css">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta
	http-equiv="refresh"
	content="20;URL=<?php print $_SERVER['PHP_SELF']."?ld=".uniqid() ?>"
>
<title>広報用ページ</title>

</head>
<body>
 <div class="wrapper">
<h1>情報デザイン総合演習　第4班　学内SNSサービス　<font color = "GREEN">Copla</font><h1>
</div>
<h3>最新の投稿</h3>
<h3>
<?php
require_once __DIR__ . '/../apk/connectDB.php';
require_once __DIR__ . '/../etc/Settings.php';

session_start();

function singlePost($Of) {
    global $pdo;

    $genreeName =  ['NULL','その他','授業','部活・サークル','研究室','就活','イベント','記事'];

   

    try {
        if (!$pdo) {
            throw new Exception("Database connection failed");
        }

        // 投稿を取得するクエリ
        $sql = "SELECT `postID`, `userID`, `genre`, `body`, `pic`, `location`, `datetime`, `fav`,`title` FROM `posts` ORDER BY `datetime` DESC LIMIT 1 OFFSET :of";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':of', $Of, PDO::PARAM_INT);
        $stmt->execute();
        $post = $stmt->fetch(PDO::FETCH_ASSOC);
        $iD = $post['postID'];
 

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

            echo '<p class="comment pre-tag" style="white-space:pre-wrap;">' . $post["body"] . '</p>';

            if ($post["pic"] != '') {
                echo '<img src="../../../userImages/post/' . $post["pic"] . '" alt="" title="" width="40%" height="40%">';
            }


            $stmt = $pdo->prepare("SELECT COUNT(*) FROM `post_likes` WHERE `postID` = :pid AND `userID` = :usid");
            $stmt->bindParam(':pid',$post["postID"],PDO::PARAM_INT);
            $stmt->bindParam(':usid',$_SESSION["userID"],PDO::PARAM_INT);
            $stmt->execute();
            $favCount0 = $stmt->fetchColumn();

            //if($favCount0 == 0){
              
            /*}else{
                echo'<br>
               <img src=".././resource/いいね済み.png" width="35" >
                : ' . $post["likeCount"] . '
                ';    
            }*/
            
            
           

           echo("</div><br>");
        }
    } catch (Exception $e) {
        error_log("Error fetching post: " . $e->getMessage());
    }
}

singlePost(0);
singlePost(1);
?>
最終更新<?php print date("y/m/d H:i:s"); ?>
</body>
<style>
body {
    width: 100%;
    height: 100%;
    background:linear-gradient(45deg, #b7b8e6,#ffffff,#bfffb9);/*グラデーションを定義*/
    background-size: 200% 400%;/*サイズを大きくひきのばす*/
    animation: bggradient 10s ease infinite;
  }
</style>

</html>
<script>
function setHashTag() {


        console.log("HashFunction");

        // まだハッシュタグ化していない要素を取得
        const elements = document.querySelectorAll("p.pre-tag");

        // console.log(elements);

        elements.forEach(element =>{
            // ハッシュタグ化したことを記録
            // element.classList.remove('pre-tag');

            // console.log(element);

            // element.innerHTML = element.innerHTML.replace(/#(\S+)/g, '<a href="#$1" class="tag">#$1</a>');


            // コールバックで
            // aタグがついていない単語のみリンク適応
            element.innerHTML = element.innerHTML.replace(/#(\S+)/g, function(match, p1, offset, string) {
                const before = string.slice(0, offset);
                const after = string.slice(offset + match.length);

                // console.log(`match = ${ match }, p1 = ${ p1 }, offset = ${ offset }, string = ${ string}`);
                // console.log(`before = ${ before }, after = ${ after}`);

                // もしaタグで囲まれていない場合
                if (!after.endsWith('</span>')) { // && !after.startsWith('<a')) {
                    // return `<a href="#${ p1 }" class="tag">${ match }</a>`;
                    return `<span class="tag">${ match }</span>`;
                }
                return match;
            });


            // element.innerHTML = element.innerHTML.replace(/#(\S+)/g, '<a onclick="searchPosts(\'$1\');" class="tag">#$1</a>');

        });   


        // 恐らくajaxで追加読み込みした投稿の位置は
        // ブラウザバックで、追加投稿が読み込まれていないためエラーになるかも
        // 最初に表示される上位20件については、問題なく起動する
        scrollTo(0, scrollPosition);
        scrollPosition = null;
    }
setHashTag();
</script>
