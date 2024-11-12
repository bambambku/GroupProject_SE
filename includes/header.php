<?php 
  $CSSpath = __DIR__ . "/../CSS/styles-desktop.css";
  str_replace("\\", "/", $CSSpath);
  var_dump($CSSpath);
  str_replace("includes", "/CSS/styles-desktop.css", $CSSpath);
  var_dump($CSSpath);
  ?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="<?php echo $CSSpath;?>" type="text/css" rel="stylesheet">
  <?php var_dump(__DIR__);?>

  <script defer src="/js/script.js"></script>
  
  <?php 
    require __DIR__ . "/config.php";
  ?>

</head>


<!-- <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../CSS/style-desktop.css" media="screen and (min-width: 1025px)"> -->