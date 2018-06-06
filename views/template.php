<?php
/**
 * Created by PhpStorm.
 * User: liaosiqun
 * Date: 2018/6/5
 * Time: 12:00
 */
?>

<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <meta name="description" content="overview &amp; stats" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <link type="" rel="shortcut icon" href="/assets/images/task.ico" />
    <?php
    echo Asset::css([
        '//cdn.amazeui.org/amazeui/2.7.2/css/amazeui.min.css'
    ]);
    ?>
    <title><?= $title ?></title>
</head>
<body>
    <?= isset($content) ? $content : '暂无主体'?>

<?php
    echo \Asset::render('css-files');
    echo \Asset::render('before-script');
    echo \Asset::render('js-files');
    echo \Asset::render('after-script');
?>
</body>
</html>