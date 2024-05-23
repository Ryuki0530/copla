<?php
   global $pdo; // グローバルスコープのPDOオブジェクトを使用する
   global $postArray; // グローバルスコープの配列を宣言

   function getPosts(){
    global $pdo, $postArray;
    try {
        $sql = "SELECT `postID`,`userID`,`genre`,`body`,`pic`,`location`,`datetime`,`fav` FROM `posts` ORDER BY `datetime` DESC;";
        $postArray = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

        foreach ($postArray as &$Post) {
            $userID = $Post['userID'];
            $sql2 = "SELECT `idName` FROM `users` WHERE `userID` = :userID";
            $userStmt = $pdo->prepare($sql2);
            $userStmt->execute(['userID' => $userID]);
            $idName = $userStmt->fetchColumn();
            $Post['idName'] = $idName;
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
    }

    function viewPosts(){
        global $postArray;
        foreach ($postArray as $Post): ?>
            <article>
                <hr>
                <div class="wrapper">
                    <div class="nameArea">
                        <p class="username">
                            <?php
                                //$url = 'userpage.php?user_ID=' . $comment["userID"]; 
                                //echo "　" . '<a href="'.$url.'">'.$comment["userName"].'</a>';
                                echo($Post["idName"]);
                            ?>
                        </p>
                        <font size="2px">
                            <time><?php //echo $comment["postDate"]; ?></time>
                            <time><?php echo $Post["datetime"]; ?></time>
                        </font>
                    </div>
                    <p class="comment">
                        <?php echo($Post["body"]);?>
                    </p>
                </div>
                <hr>
            </article>
            <?php
        endforeach;
    }

    
?>

