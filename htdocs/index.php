<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <title>Navbar</title>
</head>

<?php

require_once '../htdocs/process/config.php';
include 'header.php';
?>

<body>


  <section>

    <section class="mt-5 pt-5">

        <!-----*** LOGIN ***----->
        <div class="container logincontainer">
          <div class="row justify-content-center">
            <div id="form" class="col-lg-6 col-md-12 col-sm-12">
              <form action="/process/login.php" method="POST" class="login">
                <h2>Entrez un pseudo pour créer ou vous connecter</h2>
      
                <div class="form-group">
                  <label for="pseudo"><b>* Pseudo</b></label>
                  <input type="text" class="form-control" name="pseudo" id="pseudo" placeholder="Pseudo" required>
                </div>
      
                <div class="text-center">
                  <button type="submit" class="btn btn-primary">LOGIN</button>
                </div>
      
              </form>
            </div>
          </div>
        </div>
      
      </section>

  <!-- Bootstrap JS -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>