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

  <script src="<?=base_url()?>js/jquery-1.9.1.min.js"></script>
  <script src="<?=base_url()?>js/jquery-ui-1.10.2.min.js"></script>
  <script src="<?=base_url()?>js/bootstrap.min.js"></script>
  <script src="<?=base_url()?>js/ajax.js"></script>
  <script src="<?=base_url()?>js/scripts.js"></script>


</head>

<body class="<?php echo _e($class) ?>">

<div class="container">

  <header>

    <div class="masthead">

      <h3 class="muted">App</h3>

    </div> <!-- /.masterhead -->

  </header>

  <div class="content">

    <div class="page">

