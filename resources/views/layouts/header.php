<!DOCTYPE html>
<html>
   <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
 
    <title>BlueOwl</title>
    
    <link href="<?= asset('css/bootstrap.css') ?>" rel="stylesheet">
    <link href="<?= asset('css/style.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Muli:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
   
  </head>
<body>

<header>
 <div class="container">
  <div class="row">
   <div class="col-md-2 col-sm-3">
    <a href="#"><img class="img-responsive logo" src="<?= asset('images/logo.png') ?>"></a>
   </div><!-- col end here -->
      
   <div class="col-md-10 col-sm-9">
    <div class="admin-btn"><a href="<?= asset('logout') ?>"><img class="img-responsive" src="<?= asset('images/logout-img.png') ?>"> <h4>Shawn Edwards <span>Logout <i class="fa fa-chevron-right"></i></span></h4></a></div>
   </div><!-- col end here -->
  </div><!-- row end here -->
 </div><!-- container end here -->
</header><!-- header end here -->


<div class="admin-section">
 <div class="container"> 
  <div class="row">   
   <div class="col-md-2 col-sm-3">
    <ul class="nav nav-tabs js-example tab-txt" role="tablist">
     <a href="#"><img class="img-responsive logo1" src="<?= asset('images/logo.png') ?>"></a>
     <li class="active"><a href="<?= asset('vendors') ?>"><img class="img-responsive" src="<?= asset('images/icon.png') ?>"> Vendors</a></li>
     <li><a href="<?= asset('transactions') ?>" r><img class="img-responsive" src="<?= asset('images/icon-1.png') ?>"> Transactions</a></li>
     <li><a href="<?= asset('settings') ?>" ><img class="img-responsive" src="<?= asset('images/icon-2.png') ?>"> Settings</a></li>
    </ul><!-- ul end here -->
   </div><!-- col end here -->
