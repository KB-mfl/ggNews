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
    <link rel="stylesheet" href="css/global.css">
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
        <div class="content"></div>
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
            jump();
        });
    }

    function jump() {
        console.log('in jump()');
        var curTab = document.querySelector('.active');
        switch (curTab.attributes['id'].value) {
            case 'sidebar-recommend':
                view.innerHTML = recommend();
                break;
            default:
                break;
        }
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
</html>