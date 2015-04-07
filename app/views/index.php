<!DOCTYPE HTML>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> 
<html class="no-js" lang="es"  ng-app="Polites"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1; maximum-scale=1; minimum-scale=1; user-scalable=0;">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <link rel="stylesheet" href="css/main.css">
        <!--jQuery-->
        <!--<script src="js/vendor/jquery-1.11.1.min.js"></script>-->
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

        <!--Bootstrap-->
        <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.2.0/css/bootstrap-theme.min.css"> -->
        <!--<link rel="stylesheet" href="css/bootstrap.min.css">-->
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0-rc2/css/bootstrap-glyphicons.css">
        <!--<link rel="stylesheet" href="css/bootstrap-glyphicons.css">-->
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet">
        <!--<link rel="stylesheet" href="css/font-awesome.min.css">-->
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
        <!--<script src="js/vendor/bootstrap.js"></script>-->

         <!--Angular-->
        <script src="app/lib/angular/angular.js"></script>
        <script src="app/lib/angular/angular-ui-router.min.js"></script>
        <script src="app/lib/angular/angular.js"></script>
        <!--<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.12/angular.min.js"></script>-->

        <!--Summernote-->
        <link rel="stylesheet" href="app/lib/summernote/summernote.css">
        <link rel="stylesheet" href="app/lib/summernote/summernote-bs3.css">
        <script src="app/lib/summernote/angular-summernote.js"></script>
        <script src="app/lib/summernote/summernote.js"></script>
        
        <style>
            .border{
                border: 1px #265a88 solid;
            }

        </style>
        <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.10.4/typeahead.bundle.min.js"></script>-->
        
        <!--Bootstrap-tagsinput-->
        <link rel="stylesheet" href="app/lib/bootstrap-tagsinput/src/bootstrap-tagsinput.css">
        <script src="app/lib/bootstrap-tagsinput/src/bootstrap-tagsinput.js"></script>   
        <script src="app/lib/bootstrap-tagsinput/src/bsTagsInput.js"></script>        
        <script src="app/lib/bootstrap-tagsinput/dist/typeahead.min.js"></script>
        
    </head>

    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <nav id="nav" class="navbar navbar-inverse navbar-fixed-top" ui-view="header"></nav>
        <div class="container marketing" anchor="top">
            <!-- Example row of columns -->
            <div class="row">
              <div class="col-sm-8 col-md-8 col-lg-8">  
                    <div ui-view="main" autoscroll="false"></div>       
              </div>
              <div class="col-sm-4 col-md-4 col-lg-4 right">
                  <div ui-view="sidebar" autoscroll="false"></div>
              </div>
            </div>
            <hr>
        </div> <!-- /container --> 
        <footer id="footer" class="vspace20">
          <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <h5>About Us</h5>
                    <blockquote>This is a set of free responsive template free to download and to use to create your own website.<br />
                      The package contains varius tipologies of layouts.
                    </blockquote>
                </div> 

                <div class="col-lg-4">
                    <h5>Location and Contacts</h5>
                    <p><i class="glyphicon glyphicon-map-marker"></i>&nbsp;I do not Know Avenue, A City</p>
                    <p><i class="glyphicon glyphicon-phone"></i>&nbsp;Phone: 234 739.126.72</p>
                    <p><i class="glyphicon glyphicon-print"></i>&nbsp;Fax: 213 123.12.090</p>
                    <p><i class="glyphicon glyphicon-envelope"></i>&nbsp;Email: info@mydomain.com</p>
                    <p><i class="glyphicon glyphicon-globe"></i>&nbsp;Web: http://www.mydomain.com</p>
                </div>

                <div class="col-lg-4">
                  <h5>Newsletter</h5>
                  <p>Write you email to subscribe to our Newsletter service. Thanks!</p>
                  <form class="form-newsletter">
                    <div class="input-append">
                      <input type="email" class="col-lg-2" placeholder="your email">
                      <button type="submit" class="btn">Subscribe</button>
                    </div>
                  </form>

                  <h5>Follow Us on Socials</h5>
                  <p>
                    <a href="#"><img src="img/socials/facebook.png" alt="" /></a>
                    <a href="#"><img src="img/socials/twitter.png" alt="" /></a>
                    <a href="#"><img src="img/socials/youtube.png" alt="" /></a>
                  </p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                   <p>&copy; Company 2015.&nbsp;<a href="#">Privacy</a>&nbsp;&amp;&nbsp;<a href="#">Terms and Conditions</a></p>
                </div>
                <div class="col-lg-2 offset4">
                    <a href="http://www.responsivewebmobile.com" target="_blank">credits by Responsive Web Mobile</a>
                </div>
            </div>
          </div>
          <div class="scroll-top-wrapper " scroll-mode scrollto="top">
              <span class="scroll-top-inner">
                  <i class="fa fa-2x fa-arrow-circle-up"></i>
              </span>
          </div>
          <!--<div><img src="images/icon_gototop.png" class="icon-gototop pull-right"></div>-->
        </footer>
       <!--<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.1.min.js"><\/script>')</script>-->
        
        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
            (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
            function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
            e=o.createElement(i);r=o.getElementsByTagName(i)[0];
            e.src='//www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
            ga('create','UA-XXXXX-X','auto');ga('send','pageview');
        </script>
        <script src="js/main.js"></script>
        <script src="app/js/holder.js"></script>
        <script src="app/js/app.js"></script>
        <script src="app/js/controllers.js"></script>
        <script src="app/js/service.js"></script>
        <script src="app/js/webservice.js"></script>
        <script src="app/js/directives.js"></script>
        <script src="js/jquery.timeago.js"></script>
        <script src="app/lib/angular/angular-timeago.js"></script>
        <script src="app/lib/angular/i18n/angular-locale_es-ar.js"> </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/rainbow/1.2.0/js/rainbow.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/rainbow/1.2.0/js/language/generic.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/rainbow/1.2.0/js/language/html.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/rainbow/1.2.0/js/language/javascript.js"></script>
    </body>
</html>
