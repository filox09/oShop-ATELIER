<?php

class CartController
{
  public function index()
  {
    $this->show('cart');
  }

  public function addToCart()
  {
    // 1 - ajouter au panier
    //TODO

    // 2 - rediriger vers la page panier
    header('Location: /panier');
  }

  public function updateCart()
  {
    // 1 - modifier le panier
    //TODO

    // 2 - rediriger vers la page panier
    header('Location: /panier');
  }

  public function deleteFromCart(Type $var = null)
  {
    // 1 - supprimer du panier
    //TODO

    // 2 - rediriger vers la page panier
    header('Location: /panier');
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