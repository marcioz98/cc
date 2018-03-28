<?php

function addBaseCSS(){
  echo '<link href="css/base.css" type="text/css" rel="stylesheet"/>
';
}

function addMaterialize(){
  echo '<!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">

    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>

    <!-- MaterializeIcons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
';
}

function addHeader($pagetitle){
  echo '<div class="section header">
          <div class="row">
            <div class="col s12">
              <h4 class="header-title">CC - ' . $pagetitle . '</h4>
            </div>
          </div>
        </div>';
}

function addFooter(){
  echo '<div class="section footer">
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
';
}

?>