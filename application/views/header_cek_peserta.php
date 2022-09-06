<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0′">
    <!-- <meta content=’width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0′ name=’viewport’ /> -->
    <meta name="description" content="<?php echo $des ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#0134d4">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags-->
    <!-- Title-->
    <title><?php echo $title ?></title>
    <!-- Fonts-->
    <link href="https://fonts.googleapis.com/css2?family=Commissioner:wght@100;200;300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet">
    <!-- Favicon-->
    <link rel="icon" href="https://lpkpd.org/assets/img/pkpd_favicon.png">
    <link rel="apple-touch-icon" href="https://lpkpd.org/assets/img/pkpd_favicon.png">
    <link rel="apple-touch-icon" sizes="152x152" href="https://lpkpd.org/assets/img/pkpd_favicon.png">
    <link rel="apple-touch-icon" sizes="167x167" href="https://lpkpd.org/assets/img/pkpd_favicon.png">
    <link rel="apple-touch-icon" sizes="180x180" href="https://lpkpd.org/assets/img/pkpd_favicon.png">
    <!-- CSS Libraries-->
    <link rel="stylesheet" href="<?php echo base_url('assets/affan') ?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url('assets/affan') ?>/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url('assets/affan') ?>/css/dataTables.bootstrap4.min.css">
    <!-- Core Stylesheet-->
    <link rel="stylesheet" href="<?php echo base_url('assets/affan') ?>/style.css">
    <!-- Web App Manifest-->
</head>
<body>
    <!-- Preloader-->
    <div class="preloader d-flex align-items-center justify-content-center" id="preloader">
      <div class="spinner-grow text-primary" role="status">
        <div class="sr-only">Loading...</div>
    </div>
</div>
<!-- Internet Connection Status-->
<!-- <div class="internet-connection-status" id="internetStatus"></div> -->
<div id="setting-popup-overlay"></div>
<!-- Setting Popup Card-->
<div class="card setting-popup-card shadow-lg" id="settingCard">
  <div class="card-body">           
    <div class="container">
      <div class="setting-heading d-flex align-items-center justify-content-between mb-3">
        <p class="mb-0">Settings</p><a class="btn-close" id="settingCardClose" href="#"></a>
    </div>
    
    <div class="single-setting-panel">
        <div class="form-check form-switch mb-2">
          <input class="form-check-input" type="checkbox" id="darkSwitch">
          <label class="form-check-label" for="darkSwitch">Dark mode</label>
      </div>
  </div>
  <div class="single-setting-panel">
    <div class="form-check form-switch">
      <input class="form-check-input" type="checkbox" id="rtlSwitch">
      <label class="form-check-label" for="rtlSwitch">RTL mode</label>
  </div>
</div>
</div>
</div>
</div>
<!-- Header Area-->
<div class="header-area" id="headerArea">
  <div class="container">
    <!-- Header Content-->
    <div class="header-content position-relative d-flex align-items-center justify-content-between">
        <div class="logo-wrapper"><a href="JavaScript:void(0)"><img src="<?php echo base_url("assets/affan/") ?>img/core-img/logo.png" alt=""></a>
        </div>
        <!-- Back Button-->
        <!-- <div class="back-button"> -->
            <!-- <a href="elements.html"><svg width="32" height="32" viewBox="0 0 16 16" class="bi bi-arrow-left-short" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
            </svg></a> -->
            <!-- </div> -->
            <!-- Page Title-->
            <div class="page-heading">
                <h6 class="mb-0 "><?php echo $title ?></h6>
            </div>
            <!-- Settings-->
            <div class="setting-wrapper"><a class="setting-trigger-btn" id="settingTriggerBtn" href="#"><svg width="20" height="20" viewBox="0 0 16 16" class="bi bi-gear" fill="url(#gradientSettings)" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <linearGradient spreadMethod="pad" id="gradientSettings" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0" style="stop-color: #0134d4; stop-opacity:1;"/>
                        <stop offset="100%" style="stop-color: #28a745; stop-opacity:1;"/>
                    </linearGradient>
                </defs>
                <path fill-rule="evenodd" d="M8.837 1.626c-.246-.835-1.428-.835-1.674 0l-.094.319A1.873 1.873 0 0 1 4.377 3.06l-.292-.16c-.764-.415-1.6.42-1.184 1.185l.159.292a1.873 1.873 0 0 1-1.115 2.692l-.319.094c-.835.246-.835 1.428 0 1.674l.319.094a1.873 1.873 0 0 1 1.115 2.693l-.16.291c-.415.764.42 1.6 1.185 1.184l.292-.159a1.873 1.873 0 0 1 2.692 1.116l.094.318c.246.835 1.428.835 1.674 0l.094-.319a1.873 1.873 0 0 1 2.693-1.115l.291.16c.764.415 1.6-.42 1.184-1.185l-.159-.291a1.873 1.873 0 0 1 1.116-2.693l.318-.094c.835-.246.835-1.428 0-1.674l-.319-.094a1.873 1.873 0 0 1-1.115-2.692l.16-.292c.415-.764-.42-1.6-1.185-1.184l-.291.159A1.873 1.873 0 0 1 8.93 1.945l-.094-.319zm-2.633-.283c.527-1.79 3.065-1.79 3.592 0l.094.319a.873.873 0 0 0 1.255.52l.292-.16c1.64-.892 3.434.901 2.54 2.541l-.159.292a.873.873 0 0 0 .52 1.255l.319.094c1.79.527 1.79 3.065 0 3.592l-.319.094a.873.873 0 0 0-.52 1.255l.16.292c.893 1.64-.902 3.434-2.541 2.54l-.292-.159a.873.873 0 0 0-1.255.52l-.094.319c-.527 1.79-3.065 1.79-3.592 0l-.094-.319a.873.873 0 0 0-1.255-.52l-.292.16c-1.64.893-3.433-.902-2.54-2.541l.159-.292a.873.873 0 0 0-.52-1.255l-.319-.094c-1.79-.527-1.79-3.065 0-3.592l.319-.094a.873.873 0 0 0 .52-1.255l-.16-.292c-.892-1.64.902-3.433 2.541-2.54l.292.159a.873.873 0 0 0 1.255-.52l.094-.319z"/>
                <path fill-rule="evenodd" d="M8 5.754a2.246 2.246 0 1 0 0 4.492 2.246 2.246 0 0 0 0-4.492zM4.754 8a3.246 3.246 0 1 1 6.492 0 3.246 3.246 0 0 1-6.492 0z"/>
            </svg><span></span></a></div>
        </div>
    </div>
</div>
<div class="page-content-wrapper py-3">
  <div class="container">
    <!-- Element Heading-->
    <?php if ($e_heading <> "") {?>
        <div class="element-heading">
          <h6><?php echo $e_heading ?></h6>
      </div>
    <?php } ?>
   
</div>