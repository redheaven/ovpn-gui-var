<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />

    <title>Server List</title>

    <link rel="stylesheet" href="vendor/bootstrap/dist/css/bootstrap.min.css" type="text/css" />
    <link rel="stylesheet" href="vendor/x-editable/dist/bootstrap3-editable/css/bootstrap-editable.css" type="text/css" />
    <link rel="stylesheet" href="vendor/bootstrap-table/dist/bootstrap-table.min.css" type="text/css" />
    <link rel="stylesheet" href="vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css" type="text/css" />
    <link rel="stylesheet" href="vendor/bootstrap-table/dist/extensions/filter-control/bootstrap-table-filter-control.css" type="text/css" />
    <link rel="stylesheet" href="css/index.css" type="text/css" />

    <link rel="icon" type="image/png" href="css/icon.png">
  </head>
  <body class='container-fluid'>
      <nav class="navbar navbar-default">
        <div class="row col-md-12">
          <div class="col-md-6">
            </div>
            <div class="col-md-6">
              <a class="navbar-text navbar-right" href="index.php?logout" title="Logout"><button class="btn btn-danger">Logout <span class="glyphicon glyphicon-off" aria-hidden="true"></span></button></a>
              <a class="navbar-text navbar-right" href="index.php?configuration" title="Configuration"><button class="btn btn-default">Configurations</button></a>
              <a class="navbar-text navbar-right" href="index.php?authenticator" title="google-authenticator"><button class="btn btn-default">Setup Google Authentication</button></a>
            </p>
          </div>
        </div>
      </nav>

  <?php
      require(dirname(__FILE__) . '/include/html/grids2.php');
  ?>
</body>
</html?\?