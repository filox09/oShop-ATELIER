<?php

class ErrorController
{

  public function notFound()
  {
    http_response_code(404);
    $this->show('404');
  }

  public function systemError()
  {
    http_response_code(500);
    $this->show('500');
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