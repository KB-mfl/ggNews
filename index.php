<?php
date_default_timezone_set('PRC');
$hostname = 'localhost';
$database = 'ggNews';
$user = 'root';
$pwd = 'root';

try {
    $conn = new PDO('mysql:host='.$hostname.';dbname='.$database,$user,$pwd);
    $conn->exec('SET NAMES UTF8');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully";
}
catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

$sql = $conn->prepare('SELECT * FROM news WHERE `deleted_time` IS NULL;');
$sql->execute();
$news = $sql->fetchall(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous"> -->
    <title>ggNews</title>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <a class="logo">GGnews</a>
            <ul>
                <li>推荐</li>
                <li>热点</li>
                <li>图片</li>
                <li>科技</li>
                <li>娱乐</li>
                <li>游戏</li>
            </ul>
        </div>
        <div class="content">
            <div class="search">
                <input placeholder="Search here">
                <button>Search</button>
            </div>
            <div class="carousel">
                <img src="resourses/carousel01.jpeg" width="600" height="300">
            </div>
            <div class="news-list">
                <?php
                foreach ($news as $item) { ?>
                <div class="item">
                    <p class="title"><?php echo $item['title']; ?></p>
                    <div class="info">
                        <span><?php echo $item['author']; ?></span>
                        <span><?php echo $item['created_time']; ?></span>
                    </div>
                    <hr>
                </div>
                <?php
                } ?>
            </div>
        </div>
    </div>
</body>
<style>
    .logo {
        font-size: 24px;
    }
    .container {
        display: block;
        width: 1080px;
        min-height: 1500px;
    }
    .sidebar {
        float: left;
        width: 110px;
        margin-right: 50px;
        text-align: center;
    }
    .sidebar ul {
        padding: 0;
    }
    .sidebar li {
        list-style-type: none;
        display: inline-block;
        width: 110px;
        height: 40px;
        line-height: 40px;
        border-radius: 5px;
        transition: background 200ms, color 200ms;
    }
    .sidebar li:hover {
        background: #3cafe9;
        cursor: pointer;
        color: #ffffff;
    }
    .content {
        float: left;
        width: 600px;
        height: 100%;
    }
    .search {
        text-align: center;
    }
    .search input {
        width: 500px;
        height: 26px;
        line-height: 26px;
        padding: 0;
        font-size: 16px;
        outline: 0 none;
    }
    .search button {
        width: 80px;
        height: 28px;
        line-height: 28px;
        color: #3cafe9;
        background-color: #ffffff;
        box-shadow: 0px 0px 2px 2px #62bfee;
        border: 0;
        border-radius: 2px;
        outline: 0 none;
        transition: background-color 120ms, color 120ms, box-shadow 120ms;
    }
    .search button:hover {
        cursor: pointer;
        color: #ffffff;
        background-color: #3cafe9;
    }
    .carousel {
        margin-top: 30px;
    }
    .item .title {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 12px;
        transition: color 200ms;
    }
    .item .title:hover {
        cursor: pointer;
        color: #3081aa;
    }
    .item .info span {
        margin-right: 6px;
        color: gray;
    }
    .item hr {
        border: 0;
        height: 0;
        border-top: 1px solid rgba(0, 0, 0, 0.1);
        border-bottom: 1px solid rgba(255, 255, 255, 0.3);
    }
</style>
</html>