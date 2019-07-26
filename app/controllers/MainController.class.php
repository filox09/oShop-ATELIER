<?php

class MainController
{
  public function home()
  {
    $this->show('home');
  }

  public function legalMentions()
  {
    $this->show('legal-mentions');
  }

  public function show($viewName, $viewVars = [])
  {
    // $viewVars sera disponible dans toutes les views incluses

    // on inclue le header
    include __DIR__.'/../views/header.tpl.php';

    // puis la view demandée
    include __DIR__.'/../views/'.$viewName.'.tpl.php';

    // et enfin le footer
    include __DIR__.'/../views/footer.tpl.php';
  }


}