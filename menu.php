<?php
defined('_EXCEPTIONAL') or die("Go through the front door please.");
?>
<?php
//this is the menu across the top
?>

<nav class="navbar navbar-default navbar-fixed-top navbar-inverse" role="navigation">
  <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="?action=about">Exceptional Emails</a>
  </div>

  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav">
<?php
global $userRef;
if($userRef){
              echo '<li><a href="?action=dashboard">Dashboard</a></li>';
              echo '<li><a href="?action=expected">Expected</a></li>';
              echo '<li><a href="?action=received">Received</a></li>';
              echo '<li><a href="?action=logout">Logout</a></li>';
}else{
              echo '<li><a href="?action=about">Login</a></li>';
              echo '<li><a href="?action=register">Register</a></li>';
}
?>
            </ul>
  </div><!-- /.navbar-collapse -->
</nav>