<?php session_start(); ?>
<?php include('utils/utils.php'); ?>
<?php resetAuth(); ?>

<!DOCTYPE html>

<html>

  <head>
    <title>Login - CC</title>

    <!-- MaterializeIcons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">

    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>


    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>'


    <link href="css/base.css" type="text/css" rel="stylesheet"/>

  </head>

  <body>

    <div class="row">
      <div class="col s12">
        <h1 class="login-title center-align">CC - <a href="https://github.com/marconivr/marconicc">marconicc</a>, but <i>stronger</i></h1>
      </div>
    </div>

    <div class="container">

      <div class="row">
        <form class="col s12 login-form" action="./utils/auth.php" method="post">
          <h4 class="center-align">Login</h4>
          <div class="row">
            <div class="input-field col s12 m6 offset-m3">
              <i class="material-icons prefix">account_circle</i>
              <input placeholder="Inserisci nome utente" id="username" name="username" type="text" class="validate">
              <label for="username">Nome Utente</label>
            </div>
            <div class="input-field col s12 m6 offset-m3">
                <i class="material-icons prefix">security</i>
              <input placeholder="Inserisci password" id="password" name="password" type="password" class="validate">
              <label for="password">Password</label>
            </div>
            <div class="input-field col s12 m6 offset-m3 center-align">
              <button class="btn waves-effect waves-light" type="submit" name="action">
                Log in
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <div class="section footer">
      <div class="row">
        <div class="col s12 m4 center-align">
          <h5>Development Team</h5>
          <ul>
            <li>Alessandro Marchioro - 5CI 17/18</li>

            <li>Daniele Fava - 5CI 17/18</li>

            <li>Damiano Visentini - 5CI 17/18</li>

            <li>Mattia Carra - 5CI 17/18</li>

            <li>Leonardo Bonomi - 5CI 17/18</li>
          </ul>
        </div>
        <div class="col s12 m4 center-align">
          <h5>ITI Marconi, Verona</h5>
          P.le R. Guardini 1<br>
          Verona, IT 37138<br>
          Tel: +39 045 8101428<br>
          Fax: +39 045 573497<br>
          Mail: vrtf03000v@pec.istruzione.it<br>
          Site: marconiverona.gov.it<br>
        </div>
        <div class="col s12 m4 center-align">
          <h5>Altri Progetti</h5>
          <a href="https://campus.marconivr.it">Campus</a><br>
          <a href="">EDUS</a><br>
          <a href="">FantaMarconi</a><br>
          <a href="">OpenData</a><br>
          <a href="https://www.marconiverona.gov.it/portal/">Portale</a><br>
          <a href="http://apps.marconivr.it/poldo/">Poldo</a><br>
          <a href="http://www.anobii.com/marconivr/books">Biblioteca 2.0</a><br>
        </div>
      </div>
    </div>

  </body>
</html>
