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
  <link type="text/css" rel="stylesheet" href="<?=base_url()?>css/flick/jquery-ui-1.10.2.min.css" />
  <link type="text/css" rel="stylesheet" href="<?=base_url()?>css/style.css" />
</head>

<body class="<?php echo _e($class) ?>">

<div class="container">

  <header>

    <div class="masthead">
      <ul class="nav nav-pills pull-right">
        <li class="active"><a href="#">Home</a></li>
        <li><a href="#">About</a></li>
        <li><a href="#">Contact</a></li>
      </ul>
      <h3 class="muted">USA Gymnastics</h3>

    </div> <!-- /.masterhead -->

  </header>

  <div class="content">

    <div class="page">

