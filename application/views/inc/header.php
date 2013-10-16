<?php
/**
 * @var $title string
 */

?>
<?php echo doctype('html5'); ?>
<html lang="en">
<head>

  <title><?php echo _e($title); ?></title>

  <?php
    /* IF YOU WANT TO USE LOCAL VERSIONS
    <link type="text/css" rel="stylesheet" href="<?php echo base_url()?>css/bootstrap.min.css" />
    <link type="text/css" rel="stylesheet" href="<?php echo base_url()?>css/bootstrap-glyphicons.css" />
    */
  ?>

  <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
  <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
  <!-- Bootswatch Theme -->
  <link href="http://netdna.bootstrapcdn.com/bootswatch/3.0.0/cerulean/bootstrap.min.css" rel="stylesheet">

  <link type="text/css" rel="stylesheet" href="<?php echo base_url()?>css/flick/jquery-ui-1.10.2.min.css" />
  <link type="text/css" rel="stylesheet" href="<?php echo base_url()?>css/style.css" />

  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>

  <?php
    /* Local Versions
      <script src="<?php echo base_url()?>js/jquery-1.10.2.min.js"></script>
      <script src="<?php echo base_url()?>js/jquery-ui-1.10.3.min.js"></script>
      <script src="<?php echo base_url()?>js/bootstrap.min.js"></script>
    */
  ?>

</head>

<body class="<?php echo _e($class) ?>">

<div class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php echo base_url()?>">Project name</a>
    </div>
    <div class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Page</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
          </ul>
        </li>
        <li><a href="#contact">Contact</a></li>
      </ul>
    </div><!--/.nav-collapse -->
  </div>
</div>

<div class="container">

  <div class="content">

    <div class="page">

