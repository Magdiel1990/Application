<?php
//Raíz de directorio
define("root", "/application/");

//Url requerida
$uri = parse_url($_SERVER["REQUEST_URI"])['path']; 

//Parámetros que vienen con la url
$param = isset(parse_url($_SERVER["REQUEST_URI"])['query']) ? parse_url($_SERVER["REQUEST_URI"])['query'] : "";

//Si no hay parámetros
if($param == "") {
    $routes = [
    root => "controllers/index.controller.php" ,    
    root. "login" => "controllers/login.controller.php"/*,
    root. "logout" => "controllers/logout.controller.php",
    root. "random" => "controllers/random.controller.php",
    root. "create" => "controllers/create.controller.php",
    root. "custom-inclusive" => "controllers/custom-recipe-inclusive.controller.php",
    root. "custom-exclusive" => "controllers/custom-recipe-exclusive.controller.php",
    root. "profile" => "controllers/profile.controller.php",
    root. "ingredients" => "controllers/ingredients.controller.php",
    root. "add-recipe" => "controllers/add-recipe.controller.php",
    root. "categories" => "controllers/categories.controller.php",
    root. "user" => "controllers/users.controller.php", 
    root. "email" => "controllers/email.controller.php",
    root. "signup" => "controllers/signup.controller.php",
    root. "recovery" => "controllers/recovery.controller.php",
    root. "error404" => "controllers/404.controller.php",
    root. "terms-and-conditions" => "controllers/terms.controller.php",   
    root. "not-found" => "controllers/notfound.controller.php",
    root. "notifications" => "controllers/notification.controller.php",
    root. "recycle" => "controllers/recycle.controller.php",
    root. "reactivate-account" => "controllers/reactivate-account.controller.php",
    root. "reactivate" => "controllers/reactivate.controller.php",
    root. "settings" => "controllers/settings.controller.php",
    root. "update" => "controllers/update.controller.php",
    root. "diet" => "controllers/diet.controller.php"  */
    ];
//Si hay parámetros
} else {
    $routes = [    /*
    root. "recipes" => "controllers/recipes.controller.php",
    root. "random" => "controllers/random.controller.php",
    root. "delete" => "controllers/delete.controller.php",
    root. "reset" => "controllers/reset.controller.php",
    root. "edit" => "controllers/edit.controller.php",
    root. "create" => "controllers/create.controller.php",
    root. "update" => "controllers/update.controller.php",
    root. "share" => "controllers/share.controller.php",
    root. "user-recipes" => "controllers/recipes-list.controller.php",
    root. "reset-password" => "controllers/reset-password.controller.php",
    root. "recovery-page" => "controllers/recovery-page.controller.php",
    root. "password-change" => "controllers/pass-change.controller.php",
    root. "email_confirm" => "controllers/email_confirm.controller.php"      */
    ];
}

//Si la Url existe se llama al controlador
if(array_key_exists($uri, $routes)) {
    require $routes[$uri];
//Si no existe se llama a error 404
} else {
    http_response_code(404);
    require "views/error/404.php";
}
?>