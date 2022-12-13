<!DOCTYPE html>
<html class="wide wow-animation" lang="en">
  <head>
    <title>Herber</title>
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <!-- Stylesheets-->
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Poppins:300,400,500">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/fonts.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
     .section_container{
      padding:10px; margin:10px; border-radius: 10px;
    }
    .section_container.cesta_container{
      background-color: rgb(173, 173, 173);
    }
    .section_container.productos_container{
      background-color: rgb(115, 145, 170);
    }
    .cProductoContainer{
      margin-bottom:40px;
    }



    </style>
    <!--[if lt IE 10]>
    <div style="background: #212121; padding: 10px 0; box-shadow: 3px 3px 5px 0 rgba(0,0,0,.3); clear: both; text-align:center; position: relative; z-index:1;"><a href="http://windows.microsoft.com/en-US/internet-explorer/"><img src="images/ie8-panel/warning_bar_0000_us.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today."></a></div>
    <script src="js/html5shiv.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <h1>Herber productos Bio</h1>
    <section class="section_container cesta_container">
      <h2>Cesta</h2>
      <?php echo $the_basket; ?>
    </section>
    <section class="section_container productos_container">
      <h2>Productos</h2>
      <?php echo $the_products; ?>
    </section>
  </body>
</html>