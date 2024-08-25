<?php
include 'functions.php';
if (empty($_SESSION['login']))
  header("location:login.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="icon" href="favicon.ico" />
  <title>Source Code Metode WP</title>
  <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/css/general.css" rel="stylesheet" />
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
</head>

<body>
  <nav class="navbar navbar-default navbar-static-top" style="background-color: #87CEEB;color: #00000">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="?">KKN-T</a>
      </div>
      <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav">
           <li><a href="?m=kriteria"><span class="glyphicon glyphicon-th-large"></span> Kriteria</a></li>
           <li><a href="?m=subkriteria"><span class="glyphicon glyphicon-list"></span> SubKriteria</a></li>
           <li><a href="?m=alternatif"><span class="glyphicon glyphicon-user"></span> Calon Penerima</a></li>    
           <li><a href="?m=rel_alternatif"><span class="glyphicon glyphicon-star"></span> Nilai Calon Penerima</a></li>
           <li><a href="?m=hitung"><span class="glyphicon glyphicon-calendar"></span> Perhitungan</a></li>    
           <li><a href="?m=password"><span class="glyphicon glyphicon-lock"></span> Password</a></li>
           <li><a href="aksi.php?act=logout"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li> 
        </ul>
        <div class="navbar-text"></div>
      </div>
      <!--/.nav-collapse -->
    </div>
  </nav>
  <div class="container">
    <?php
    if (file_exists($mod . '.php'))
      include $mod . '.php';
    else
      include 'home.php';
    ?>
  </div>
  <footer class="footer bg-primary">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <p>Copyright &copy; KKN-TEMATIK FMIPA UHO 2024 KEL. KENDARI </p>
        </div>
        <div class="col-md-6">
          <p class="text-right"><em></em></p>
        </div>
      </div>
    </div>
  </footer>
  <script type="text/javascript">
    $(document).ready(function() {
      $(document).on('focus', ':input', function() {
        $(this).attr('autocomplete', 'off');
      });
    });
  </script>
</body>

</html>
