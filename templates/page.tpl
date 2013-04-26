<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>{$PAGE_TITLE}</title>
	{$CSS_FILES}
	{$JS_FILES}
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{$DESCRIPTION}">
    <meta name="author" content="{$AUTHOR}">

    <!-- Le styles -->
    
    <link href="{$BOOTSRAPPATH}css/bootstrap.css" rel="stylesheet">
    <link href="{$BOOTSRAPPATH}css/bootstrap-responsive.css" rel="stylesheet">
    <link href="{$BOOTSRAPPATH}css/bootstrap.css" rel="stylesheet">
    <link href="{$BOOTSRAPPATH}css/bootstrap-responsive.css" rel="stylesheet">
    <link href="{$BOOTSRAPPATH}css/docs.css" rel="stylesheet">
    <link href="{$BOOTSRAPPATH}js/google-code-prettify/prettify.css" rel="stylesheet">

	<style>
      body {
        padding-top: 40px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
	<style type="text/css">
		{$CSS_CODE}
	</style>
  </head>

    <body>
	<div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="#">{$PROJEKTNAME}</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="active"><a href="#">HOME</a></li>
              <li><a href="#about">ABOUT</a></li>
              <li><a href="#contact">ONTRACT</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
	<!-- Subhead
================================================== -->
<header class="jumbotron subhead">
  <div class="container">
    <h1>{$SUBHEADBIG}</h1>
    <p class="lead">{$SUBHEADSMALL}
  </div>
</header>
    <!-- Docs nav
    ================================================== -->	

<div class="container">
    <div class="row">
      <div class="span3 bs-docs-sidebar">
        <ul class="nav nav-list bs-docs-sidenav">
          <li class="active"><a href="#lv80overall"><i class="icon-chevron-right"></i> Chars Lv 80 Overall</a></li>
          <li><a href="#lv80overall"><i class="icon-chevron-right"></i> Chars Lv 80 Overall</a></li>
          <li><a href="#lv80overall"><i class="icon-chevron-right"></i> Chars Lv 80 Overall</a></li>
          <li><a href="#lv80overall"><i class="icon-chevron-right"></i> Chars Lv 80 Overall</a></li>
          
        </ul>
      </div>
      <div class="span9">
	

        <!-- Overview
        ================================================== -->
	{include file="{$TEMPLATEFILE}"}
	</div>
</div>

    <!-- Footer
    ================================================== -->
    <footer class="footer">
      <div class="container">
        <p>FOOTER</P>
        <p>FOOTER</p>
        <ul class="footer-links">
          <li><a href="#">LINK1</a></li>
          <li class="muted">&middot;</li>
          <li><a href="#">Link2</a></li>
          <li class="muted">&middot;</li>
          <li><a href="#">LInk3</a></li>
        </ul>
      </div>
    </footer>

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
	{$ENDSCRIPT}
    <script src="{$BOOTSRAPPATH}js/jquery.js"></script>
    <script src="{$BOOTSRAPPATH}js/bootstrap-transition.js"></script>
    <script src="{$BOOTSRAPPATH}js/bootstrap-alert.js"></script>
    <script src="{$BOOTSRAPPATH}js/bootstrap-modal.js"></script>
    <script src="{$BOOTSRAPPATH}js/bootstrap-dropdown.js"></script>
    <script src="{$BOOTSRAPPATH}js/bootstrap-scrollspy.js"></script>
    <script src="{$BOOTSRAPPATH}js/bootstrap-tab.js"></script>
    <script src="{$BOOTSRAPPATH}js/bootstrap-tooltip.js"></script>
    <script src="{$BOOTSRAPPATH}js/bootstrap-popover.js"></script>
    <script src="{$BOOTSRAPPATH}js/bootstrap-button.js"></script>
    <script src="{$BOOTSRAPPATH}js/bootstrap-collapse.js"></script>
    <script src="{$BOOTSRAPPATH}js/bootstrap-carousel.js"></script>
    <script src="{$BOOTSRAPPATH}js/bootstrap-typeahead.js"></script>

  </body>
</html>