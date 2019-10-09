  <nav class="navbar navbar-expand-md navbar-light bg-light mb-4">
  <a class="navbar-brand" href="#"><?php echo "$cfg->sitename";?></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarCollapse">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">Месяцы <span class="sr-only">(current)</span></a>
      </li>
     <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Справочники</a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="index.php?content_page=drivers">Водители</a>
          <a class="dropdown-item" href="index.php?content_page=brigadirs">Бригадиры</a>
        </div>        
      </li>
     <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Отчеты</a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="index.php?content_page=report_sales">Прибыль таксопарка за период</a>
        </div>
      </li>      
    </ul>
  </div>
</nav>