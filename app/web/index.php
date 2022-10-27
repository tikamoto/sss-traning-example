<?php
require_once __DIR__ . "/../vendor/autoload.php";

App\Config::set("APP_ROOT_DIR",  __DIR__ . "/../src/");
App\Config::set("DB_HOST",       getenv("DB_HOST") ?: "");
App\Config::set("DB_NAME",       getenv("DB_NAME") ?: "");
App\Config::set("DB_USER",       getenv("DB_USER") ?: "");
App\Config::set("DB_PASSWORD",   getenv("DB_PASSWORD") ?: "");

(new App\Infra\Http\Router())
    ->get  ("/",              App\Controller\IndexController::class,                   "index")
    ->get  ("/login",         App\Controller\AuthController::class,                    "index")
    ->post ("/login",         App\Controller\AuthController::class,                    "login")
    ->get  ("/logout",        App\Controller\AuthController::class,                    "logout")
    ->get  ("/user/create",   App\Controller\UserRegistrationController::class,        "index")
    ->post ("/user/create",   App\Controller\UserRegistrationController::class,        "create")
    ->get  ("/user/update",   App\Controller\MyPage\UserAlterationController::class,   "index")
    ->post ("/user/update",   App\Controller\MyPage\UserAlterationController::class,   "update")
    ->post ("/user/delete",   App\Controller\MyPage\UserAlterationController::class,   "delete")
    ->get  ("/task/create",   App\Controller\MyPage\TaskRegistrationController::class, "index")
    ->post ("/task/create",   App\Controller\MyPage\TaskRegistrationController::class, "create")
    ->post ("/task/complete", App\Controller\MyPage\TaskRegistrationController::class, "complete")
    ->get  ("/task/update",   App\Controller\MyPage\TaskAlterationController::class,   "index")
    ->post ("/task/update",   App\Controller\MyPage\TaskAlterationController::class,   "update")
    ->post ("/task/delete",   App\Controller\MyPage\TaskAlterationController::class,   "delete")
    ->error(401, App\Controller\ErrorController::class, "e401")
    ->error(403, App\Controller\ErrorController::class, "e403")
    ->error(404, App\Controller\ErrorController::class, "e404")
    ->error(500, App\Controller\ErrorController::class, "e405")
    ->respond();