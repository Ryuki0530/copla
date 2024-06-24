<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (!isset($_SESSION['userID'])) {
    header("Location: center.html");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="./css/stylesheet2.css">
    <meta charset="utf-8">
    <title>Copla マイページ</title>
</head>
<br><br>
<body bgcolor="white">

    <div class="wrapper">
    <h1>マイページ<h1>
    </div>
    <br>

    <div class="wrapper">
        <h1>シンボルネーム</h1>
        <!-- ドロップダウンで選択式 -->
        <!-- 上の句テーブル　助詞テーブル　下の句テーブル -->
        <!-- ランダムボタンも用意 -->
        <!-- ワードは新しいテーブルを用意 -->
        <div class="sub-name">
            <div class="sub-select">
                フロント
                <select>
                    <option>ガラス</option>
                </select>
            </div>
            <div class="sub-select">
                ミドル
                <select>
                    <option>の</option>
                </select>
            </div>
            <div class="sub-select">
                リア
                <select>
                    <option>ドリブル</option>
                </select>
            </div>
        </div>
    </div>
    <br>

    <div class="wrapper">
    <h2>ACHIEVEMENT</h2>
    <hr>
    <!-- タスクテーブルを新たに作成 -->
    <!-- タスク名(テキスト),難易度(1-5の数値), 詳細文(テキスト), 
        報酬(コイン以外の報酬も考慮してテキスト),  
        日付(達成日を格納するため, 達成するまでは非表示),
        フラグ(達成したかどうか)
    -->
    <div class="one-task clear-task">
        <div class="task-title">
            <!-- 難易度の星の数は JSの{ }記法で動的にやりたい -->
            <h2>
                いいね
                <img src="../resource/level_star.png" alt="" class="level">
                2
            </h2>
            <p class="detail">人の投稿に「いいね」しよう</p>
            <button class="clear">報酬を受け取る</button>
        </div>
        <hr>
        <div class="task-details">
            <p class="rewoard">報酬: コイン</p>
            <p class="date">達成日: 2024-06-18</p>
        </div>
    </div>
    <div class="one-task clear-task">
        <div class="task-title">
            <!-- 難易度の星の数は JSの{ }記法で動的にやりたい -->
            <h2>
                はじめてのポスト
                <img src="../resource/level_star.png" alt="" class="level">
                2
            </h2>
            <p class="detail">1ジャンルで3投稿しよう</p>
            <button class="clear">報酬を受け取る</button>
        </div>
        <hr>
        <div class="task-details">
            <p class="rewoard">報酬: 30コイン</p>
            <p class="date">達成日: 2024-06-24</p>
        </div>
    </div>
    <div class="one-task">
        <div class="task-title">
            <!-- 難易度の星の数は JSの{ }記法で動的にやりたい -->
            <h2>
                フォトシェア
                <img src="../resource/level_star.png" alt="" class="level">
                2
            </h2>
            <p class="detail">写真を投稿しよう</p>
            <button class="">報酬を受け取る</button>
        </div>
        <hr>
        <div class="task-details">
            <p class="rewoard">報酬: 50コイン</p>
            <p class="date no-comp-day">達成日: 2024-06-24</p>
        </div>
    </div>
    <div class="one-task lock">
        <div class="task-title">
            <!-- 難易度の星の数は JSの{ }記法で動的にやりたい -->
            <img src="../resource/lock.png" alt="">
        </div>
        <hr>
        <div class="task-details">
        </div>
    </div>
</body>
</html>
