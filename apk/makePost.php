<?php
session_start();
require_once __DIR__ . '/../apk/connectDB.php';
require_once __DIR__ . '/../etc/Settings.php';

session_regenerate_id(true);

function makeTubuyaki() {
    global $pdo;
    $userID = $_SESSION['userID'];
    $genre = trim($_POST["category"]);
    $comment = trim($_POST["comment"]);
    $title = trim($_POST["title"]);
    $response = array();
    //保存する画像の名前
    $fileNewName;
    $exiPic = false;

    // ファイルの存在とアップロード有無のチェック
    if (isset($_FILES['pic']) && is_uploaded_file($_FILES['pic']['tmp_name'])) {
        //エラー検出
        if ($_FILES['pic']['error'] === UPLOAD_ERR_OK) {
            // ファイル名を取得
            $tmp_name = $_FILES["pic"]["tmp_name"];
            $fileName = $_FILES['pic']['name'];
            $fileNewName = date("YmdHis") . "-" . $fileName;
            $upload = '../../userImages/post/' . $fileNewName;

            // ディレクトリが存在しない場合は作成
            if (!is_dir('../../userImages/post')) {
                mkdir('../../userImages/post', 0777, true);
            }

            // ファイルを移動
            if (move_uploaded_file($tmp_name, $upload)) {
                $exiPic = true;
            } else {
                $response['error'] = "ファイルのアップロードに失敗しました。エラーコード: " . $_FILES['pic']['error'];
                echo json_encode($response);    
            }
                        
        } else {
            $response['error'] = "ファイルのアップロードに失敗しました。エラーコード: " . $_FILES['pic']['error'];
            echo json_encode($response);
            return;
        }
    } else {
        $exiPic = false;
    }

    // 無記入拒否
    $blank = false;
    if ($genre == 7 && empty($title)) { $blank = true; }
    if (empty($comment)) { $blank = true; }

    if ($blank) {
        $response['error'] = "投稿内容を入力してください。";
    } else {
        $comment = htmlspecialchars($comment, ENT_QUOTES, 'UTF-8');
        $postDate = date("Y-m-d H:i:s");
        try {
            if(!$exiPic){
                if ($genre == 7) {
                    $stmt = $pdo->prepare("INSERT INTO `posts` (`userID`,`genre`,`body`,`datetime`,`title`) VALUES (:userID,:genre,:comment,:postDate,:title)");
                } else {
                    $stmt = $pdo->prepare("INSERT INTO `posts` (`userID`,`genre`,`body`,`datetime`) VALUES (:userID,:genre,:comment,:postDate)");    
                }
            }
            if($exiPic){
                if ($genre == 7) {
                    $stmt = $pdo->prepare("INSERT INTO `posts` (`userID`,`genre`,`body`,`pic`,`datetime`,`title`) VALUES (:userID,:genre,:comment,:pic,:postDate,:title)");
                } else {
                    $stmt = $pdo->prepare("INSERT INTO `posts` (`userID`,`genre`,`body`,`pic`,`datetime`) VALUES (:userID,:genre,:comment,:pic,:postDate)");    
                }
            }
            

            if (!$stmt) {
                throw new Exception("Prepare failed: " . implode(" ", $pdo->errorInfo()));
            }

            $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);
            $stmt->bindParam(':genre', $genre, PDO::PARAM_INT);
            $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
            $stmt->bindParam(':postDate', $postDate, PDO::PARAM_STR);
            if ($genre == 7) {
                $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            }
            if($exiPic){
                $stmt->bindParam(':pic',$fileNewName, PDO::PARAM_STR);
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

if (isset($_SESSION["userID"])) {
    makeTubuyaki();
} else {
    echo json_encode(array('error' => "投稿するためにはログインしてください。"));
}
?>
