<?php
session_start();
require_once __DIR__ . '/../apk/connectDB.php';
require_once __DIR__ . '/../etc/Settings.php';

session_regenerate_id(true);

function makeTubuyaki(){
    global $pdo;
    $userID=$_SESSION['userID'];
    $genre=trim($_POST["category"]);
    $comment = trim($_POST["comment"]);
    $title = trim($_POST["title"]);
    
    $response = array();
    //$response['error'] = $title;

    //無記入拒否
    $blank = false;
    if($genre==7 && empty($title)){$blank = true;}
    if(empty($comment)){$blank = true;}

    if ($blank) {
        $response['error'] = "投稿内容を入力してください。";
    } else {
        $comment = htmlspecialchars($comment, ENT_QUOTES, 'UTF-8');
        $postDate = date("Y-m-d H:i:s");
        try {
            if($genre ==7){
                $stmt = $pdo->prepare("INSERT INTO `posts` (`userID`,`genre`,`body`,`datetime`,`title`) VALUES (:userID,:genre,:comment,:postDate,:title)");
            }else{
                $stmt = $pdo->prepare("INSERT INTO `posts` (`userID`,`genre`,`body`,`datetime`) VALUES (:userID,:genre,:comment,:postDate)");    
            }
            

            if (!$stmt) {
                throw new Exception("Prepare failed: " . implode(" ", $pdo->errorInfo()));
            }

            $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);
            $stmt->bindParam(':genre', $genre, PDO::PARAM_INT);
            $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
            $stmt->bindParam(':postDate', $postDate, PDO::PARAM_STR);
            if($genre == 7){
                $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            }

            $stmt->execute();

            // 投稿成功時はコメントを返す
            $response['success'] = $comment;

        } catch (PDOException $e) {
            $response['error'] = "Error: " . $e->getMessage();
        } catch (Exception $e) {
            $response['error'] = "Error: " . $e->getMessage();
        }
    }

    echo json_encode($response);
}

if(isset($_SESSION["userID"])){
    makeTubuyaki();
}else{
    echo json_encode(array('error' => "投稿するためにはログインしてください。"));
}
?>
