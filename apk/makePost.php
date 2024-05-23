<?php
    function makeTubuyaki(){
        global $pdo; // グローバルスコープのPDOオブジェクトを使用する
        $userID="00RD000";
        $genre=1;
        $comment = trim($_POST["comment"]);
        // バリデーションチェック
        if (empty($comment)) {
            echo '<script>alert("投稿内容を入力してください。")</script>';
        } else {
            // エスケープ処理
            $comment = htmlspecialchars($comment, ENT_QUOTES, 'UTF-8');

            $postDate = date("Y-m-d H:i:s");
            try {
                $stmt = $pdo->prepare("INSERT INTO `posts` (`userID`,`genre`,`body`,`datetime`) VALUES (:userID,:genre,:comment,:postDate)");
                if (!$stmt) {
                    throw new Exception("Prepare failed: " . implode(" ", $pdo->errorInfo()));
                }

                $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);
                $stmt->bindParam(':genre', $genre, PDO::PARAM_INT);
                $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
                $stmt->bindParam(':postDate', $postDate, PDO::PARAM_STR);

                $stmt->execute();

                // リダイレクト処理
                header("Location: {$_SERVER['PHP_SELF']}");
                exit();

            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    }
?>
