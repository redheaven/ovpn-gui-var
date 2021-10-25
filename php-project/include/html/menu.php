<div class="col-md-6 col-md-offset-3">
  <nav class="navbar navbar-default">

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li <?php if(isset($_GET['configuration'])) echo 'class="active"'; ?>><a href="index.php?configuration">Configurations</a></li>
         <li <?php if(isset($_GET['authenticator'])) echo 'class="active"'; ?>><a href="index.php?authenticator">Setup Google Authentication</a></li>
        <li <?php if(isset($_GET['admin'])) echo 'class="active"'; ?>><a href="index.php?admin">Administrator</a></li>
        <li <?php if(isset($_GET['serverlist'])) echo 'class="active"'; ?>><a href="index.php?serverlist">Server List</a></li>



      </ul>
    </div>

  </nav>
</div>
