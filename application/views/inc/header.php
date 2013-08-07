<?php
/**
 * @var $title string
 */

?>



<?php echo doctype('html5'); ?>
<html lang="en">
<head>

  <title><? echo _e($title,'', ' | '); ?></title>

  <link type="text/css" rel="stylesheet" href="<?=base_url()?>css/bootstrap.min.css" />
  <link type="text/css" rel="stylesheet" href="<?=base_url()?>css/bootstrap-glyphicons.css" />
  <link type="text/css" rel="stylesheet" href="<?=base_url()?>css/flick/jquery-ui-1.10.2.min.css" />
  <link type="text/css" rel="stylesheet" href="<?=base_url()?>css/style.css" />

  <script src="<?=base_url()?>js/jquery-1.10.2.min.js"></script>
  <script src="<?=base_url()?>js/jquery-ui-1.10.3.min.js"></script>
  <script src="<?=base_url()?>js/bootstrap.min.js"></script>
  <script src="<?=base_url()?>js/ajax.js"></script>
  <script src="<?=base_url()?>js/scripts.js"></script>


</head>

<body class="<?php echo _e($class) ?>">

<div class="navbar navbar-inverse navbar-fixed-top">
  <div class="container">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".nav-collapse">
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="<?php echo base_url()?>">Application Name</a>
    <div class="nav-collapse collapse">
      <ul class="nav navbar-nav">
        <li class="active"><a href="<?php echo base_url()?>/#">Page 1</a></li>
        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Dropdown<span class="caret"></span> </a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo base_url()?>#">Dropdown 1</a> </li>
            <li><a href="<?php echo base_url()?>#">Dropdown 2</a> </li>
          </ul>
        </li>
      </ul>
    </div><!--/.nav-collapse -->
  </div>
</div>


<div class="container">

  <div class="content">

    <div class="page">

