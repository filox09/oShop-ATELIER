<?php

// Nouveauté composer : on peut require toutes les dépendances d'un seul coup
require __DIR__.'/../vendor/autoload.php';
// var_dump($_SERVER);
// dump($_SERVER); // on peut se servir de cette fonction car on l'a installé grace à composer, et require grace à autoload !

// Ce fichier est le point d'entrée de toute l'application

// 1 - récupérer l'url visé (rappel : .htaccess renvoie toutes les requêtes ici, et crée une varable $_GET['url'])
$currentUrl = (isset($_GET['url'])) ? $_GET['url'] : '/';

// 2 - inclure les controllers
require __DIR__.'/../app/controllers/MainController.class.php';
require __DIR__.'/../app/controllers/ProductController.class.php';
require __DIR__.'/../app/controllers/CartController.class.php';
require __DIR__.'/../app/controllers/ErrorController.class.php';


// 3 - faire le routage ! c'est à dire appeler la bonne méthode sur le bon controller en fonction de l'url ciblée

/** Version routage à la main => trop limité ! */
// switch ($currentUrl) {
//   case '/':
//     $controller = new MainController();
//     $controller->home();
//     break;
  
//   case '/mentions-legales':
//     $controller = new MainController();
//     $controller->legalMentions();
//     break;

//   case '/produit/[id]':
//     $controller = new ProductController();
//     $controller->productDetails();
//     break;
  
//   default:
//     $controller = new ErrorController();
//     $controller->notFound();
//     break;
// }

/** Version Altorouter ! */
// on ne sait pas gérer les url dynamiques (type /produit/[id]) à la main, on va donc utiliser AltoRouter, qui sait faire ça !

$router = new AltoRouter();

// on rensienge l'option basePath comme indiqué dans la doc
// cf. http://altorouter.com/usage/rewrite-requests.html

$router->setBasePath($_SERVER['BASE_URI']);

// première étape : mapper les routes
$router->map('GET', '/', 'MainController#home');
$router->map('GET', '/mentions-legales', 'MainController#legalMentions');
$router->map('GET', '/produits/categorie/[i:id]', 'ProductController#listProductsByCategory');
$router->map('GET', '/produit/[i:id]', 'ProductController#productDetails');
$router->map('GET', '/panier', 'CartController#index');
$router->map('POST', '/panier/ajout', 'CartController#addToCart' );
$router->map('POST', '/panier/modif', 'CartController#updateCart' );
$router->map('POST', '/panier/suppr', 'CartController#deleteFromCart');

// deuxième étape : matching et dispatch
$match = $router->match();
// dump($match);

// $match vaut : 
// - soit un tableau avec les détails de la route, si elle existe (i.e. elle a été mappé)
// - soit false si la route n'existe pas

// premier cas "facile" : $match est false => 404
if ($match == false) {
  $controller = new ErrorController();
  $controller->notFound();
} else {
  // deuxième cas : la route existe => il faut appeler la méthode qui correspond

  // dans $match, on a les clefs : 
  // "target" , qui contient `NomDuController#nomDeLaMéthode`
  // "params" , qui contient les paramètres dynamiques de l'url
  // "name" , qui correspond au nom de la route (pour l'instant on s'en sert pas)

  $dispatchArray = explode('#', $match['target'] );
  // dump($dispatchArray);

  // on peut donc déduire le nom du controlleur visé, et de la méthode
  $controllerName = $dispatchArray[0];
  $methodName = $dispatchArray[1];

  // $controllerName contient donc le nom du controller visé
  // en utilisant la syntaxe suivante, PHP va remplacer $controllerName par sa valeur (par exemple MainController), ce qui va donner `$controller = new MainController()` :tada: 
  $controller = new $controllerName();

  // et ici, meme chose : php va d'abord remplacer $methodName par sa valeur, ce qui donnera par exemple $controller->home();
  $controller->$methodName();

}