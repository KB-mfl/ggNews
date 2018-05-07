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

function getRecommend($conn) {
    $sql = $conn->prepare('SELECT * FROM news WHERE `deleted_time` IS NULL;');
    $sql->execute();
    return $sql->fetchall(PDO::FETCH_ASSOC);
}

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
                <li id="sidebar-recommend" class="tab">推荐</li>
                <li id="sidebar-hot" class="tab">热点</li>
                <li id="sidebar-image" class="tab">图片</li>
                <li id="sidebar-science" class="tab">科技</li>
                <li id="sidebar-entertainment" class="tab">娱乐</li>
                <li id="sidebar-game" class="tab">游戏</li>
            </ul>
        </div>
        <div class="search">
            <input placeholder="Search here">
            <button>Search</button>
        </div>
        <div class="content">
            <!-- <div class="carousel">
                <img src="resourses/carousel01.jpeg">
            </div>
            <div class="news-list">
                <?php
                foreach ($news as $item) { ?>
                <div class="item">
                    <p class="title"><?php echo $item["title"]; ?></p>
                    <div class="info">
                        <span><?php echo $item["author"]; ?></span>
                        <span><?php echo $item["created_time"]; ?></span>
                    </div>
                    <hr>
                </div>
                <?php
                } ?>
            </div> -->
        </div>
    </div>
</body>
<script>
    var sidebar = document.querySelector('.sidebar');
    var tabs = document.querySelectorAll('.tab');
    tabs[0].className += ' active';

    var view = document.querySelector('.content');
    view.innerHTML = recommend();
    for (var i = 0; i < tabs.length; i++) {
        tabs[i].addEventListener('click', function() {
            var curTab = document.querySelector('.active');
            curTab.className = curTab.className.replace('active', '');
            this.className += ' active';
        });
    }

    function recommend() {
        var news = <?php echo json_encode(getRecommend($conn)); ?>;
        console.log(news);

        var HTML = 
             '<div class="carousel">'
            +    '<img src="resourses/carousel01.jpeg">'
            +'</div>'
            +'<div class="news-list">';

        for (var i = 0; i < news.length; i++) {
            HTML +=
                 '<div class="item">'
                +    '<p class="title">'
                +        news[i].title
                +    '</p>'
                +    '<div class="info">'
                +        '<span>'
                +            news[i].author
                +        '</span>'
                +        '<span>'
                +            news[i].created_time
                +        '</span>'
                +    '</div>'
                +    '<hr>'
                +'</div>';
        }
        HTML += '</div></div>';

        console.log(HTML);
        return HTML;
    }
</script>
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
    .sidebar .tab {
        list-style-type: none;
        display: inline-block;
        width: 110px;
        height: 40px;
        line-height: 40px;
        border-radius: 5px;
        margin-bottom: 5px;
        transition: background 200ms, color 200ms;
    }
    .sidebar .tab:hover, .sidebar .active {
        background: #3cafe9;
        cursor: pointer;
        color: #ffffff;
    }
    .content {
        float: left;
        width: 660px;
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
    .carousel img {
        width: 660px;
        height: 320px;
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