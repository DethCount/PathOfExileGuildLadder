<?php

$cache = json_decode(file_get_contents(__DIR__ . '/../cache/data.php'));

if (count($cache) <= 0) {
    echo 'No entries found !<br/>';
    exit;
}

echo <<<HTML
<!DOCTYPE html>
<html>
  <head>
    <title>Path of Exile : Statistiques</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
  </head>
  <body>
HTML;

echo <<<MENU
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="#">Path of Exile</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="active"><a href="#">Home</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
MENU;

echo <<<CONTENT
<div class="container" style="margin-top: 50px;">
    <h1>Classement de la guilde</h1>
    <ul>
CONTENT;

foreach ($cache as $userName => $characters) {
    echo '<li>';
    echo '<span class="username">' . htmlentities($userName) . '</span>';
    echo '<ul>';
    foreach ($characters as $classement => $data) {
        $dead = !!$data->dead;
        echo '<li>' . ($dead ? '<s>#' . $classement . '</s>' : '#' . $classement) . ' => ' . $data->character->name . '(' . $data->character->class . ' lvl ' . $data->character->level . ') => ' . $data->character->experience . ' xp</li>';
    }
    echo '</ul>';
}
echo '</ul>';

echo <<<CONTENTEND
</div>
CONTENTEND;

echo <<<FOOTER
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>
FOOTER;
