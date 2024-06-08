DB初期化用

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2024-06-07 05:10:18
-- サーバのバージョン： 10.4.32-MariaDB
-- PHP のバージョン: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `copla_db`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `posts`
--

CREATE TABLE `posts` (
  `postID` int(11) NOT NULL,
  `userID` varchar(7) NOT NULL,
  `genre` int(11) NOT NULL,
  `body` varchar(300) NOT NULL,
  `pic` varchar(50) NOT NULL,
  `location` varchar(50) NOT NULL,
  `datetime` datetime NOT NULL,
  `fav` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `post_likes`
--

CREATE TABLE `post_likes` (
  `likeID` int(11) NOT NULL,
  `postID` int(11) NOT NULL,
  `userID` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `replies`
--

CREATE TABLE `replies` (
  `repID` int(11) NOT NULL,
  `postID` int(11) NOT NULL,
  `userID` varchar(7) NOT NULL,
  `body` varchar(300) NOT NULL,
  `pic` varchar(30) NOT NULL,
  `location` varchar(50) NOT NULL,
  `datetime` datetime NOT NULL,
  `fav` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `reply_likes`
--

CREATE TABLE `reply_likes` (
  `likeID` int(11) NOT NULL,
  `repID` int(11) NOT NULL,
  `userID` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `userID` varchar(7) NOT NULL,
  `password` varchar(255) NOT NULL,
  `userName` varchar(20) NOT NULL,
  `idName` varchar(30) NOT NULL,
  `birthday` date NOT NULL,
  `ini` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`postID`),
  ADD KEY `userID` (`userID`);

--
-- テーブルのインデックス `post_likes`
--
ALTER TABLE `post_likes`
  ADD PRIMARY KEY (`likeID`),
  ADD UNIQUE KEY `unique_like` (`postID`,`userID`);

--
-- テーブルのインデックス `replies`
--
ALTER TABLE `replies`
  ADD PRIMARY KEY (`repID`);

--
-- テーブルのインデックス `reply_likes`
--
ALTER TABLE `reply_likes`
  ADD PRIMARY KEY (`likeID`),
  ADD UNIQUE KEY `unique_like` (`repID`,`userID`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `posts`
--
ALTER TABLE `posts`
  MODIFY `postID` int(11) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `post_likes`
--
ALTER TABLE `post_likes`
  MODIFY `likeID` int(11) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `replies`
--
ALTER TABLE `replies`
  MODIFY `repID` int(11) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `reply_likes`
--
ALTER TABLE `reply_likes`
  MODIFY `likeID` int(11) NOT NULL AUTO_INCREMENT;

--
-- ダンプしたテーブルの制約
--

--
-- テーブルの制約 `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;




etc/dbinfo.php内にデータベースのエンドポイント、データべ―ス名、ユーザー名、パスワードを入力