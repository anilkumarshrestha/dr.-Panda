<header>


<!-- Fixed navbar -->
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
    <a class="navbar-brand" href="/">Swastha</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse pull-right">
          <form method="post" class="navbar-form navbar-left" action="search.php">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-default" action="search.php"><span class="glyphicon glyphicon-search"></span></button>
                    </span>
                </div>
          </form>
          <ul class="nav navbar-nav">
            
            <li class=""><a href="/">Home</a></li>
            <li><a href="about.php">About</a></li>
            
            <?php
                if(isset($_SESSION["doctor"])){
               ?> 
                <li role="presentation" class=""><a href="logout.php">Logout</a></li>

            <?php } elseif ($_SESSION["patient"]){
            ?>
                <li role="presentation" class=""><a href="logout.php">Logout</a></li>
            <?php
            } 
            else {
            ?>
                <li role="presentation" class=""><a href="login.php">Login</a></li>
                <li role="presentation"><a href="register.php">Register</a></li>
                
            <?php
            }
            ?>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>



</header>


