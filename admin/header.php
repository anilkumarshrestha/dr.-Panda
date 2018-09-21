<header>
  <nav id="myNavbar" class="navbar navbar-default navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="container">
      <div class="navbar-header">
        <div class="navbar-header">
               <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
                   <span class="sr-only">Toggle navigation</span>
                   <span class="icon-bar"></span>
                   <span class="icon-bar"></span>
                   <span class="icon-bar"></span>
               </button>
      <div class="container">
      <div class="navbar-header">
        <a class="navbar-brand" href="index.php">Admin Home</a>
        <a class="navbar-brand" href="/">September9</a>
    </div>
      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <form method="post" class="navbar-form navbar-left" action="search.php">
                <div class="input-group">
                    <input type="text" name="product" class="form-control" placeholder="Search">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
                    </span>
                </div>
          </form>

        <?php
        if ($loggedin != 1) {
        ?>
        <ul class="nav navbar-nav navbar-right">
          <li ><a href="../login.php" >Log In</a></li>
          <li><a href="../register.php" >Register</a></li>
          <?php
          } else  { ?>
              <ul class ="nav navbar-nav navbar-right" >
              <li><p class="text-success"><?php {echo 'Welcome, '.$name.'';} ?></p></li>
              <li>
               <a  href="index.php?logout">Logout</a>
              </li>
          <?php
        }
          ?>
        </ul>
  </div>
  </div>
</div>
</nav>
</header>
