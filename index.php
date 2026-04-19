<?php
    ob_start();
    session_start();
    // session_destroy();

    require_once "models/DataBase.php";

    $controllerRequest = isset($_REQUEST['c']) ? $_REQUEST['c'] : "Landing";
    $action = isset($_REQUEST['a']) ? $_REQUEST['a'] : 'main';

    $allowedControllers = [
        "Landing" => "Landing",
        "Login" => "Login",
        "User" => "User",
        "Category" => "Category",
        "Product" => "Product",
        "Sale" => "Sale",
        "Purchase" => "Purchase",
        "Dashboard" => "Dashboard"
    ];

    if (!array_key_exists($controllerRequest, $allowedControllers)) {
        $controllerRequest = "Landing";
    }

    $controllerName = $allowedControllers[$controllerRequest];
    $route_controller = "controllers/" . $controllerName . ".php";

    if (file_exists($route_controller)) {
        $view = $controllerName;
        require_once $route_controller;
        $controller = new $controllerName;

        if ($view === 'Landing' || $view === 'Login') {
            require_once "views/company/header.view.php";
            call_user_func([$controller, $action]);
            require_once "views/company/footer.view.php";
        } elseif (!empty($_SESSION['session'])) {
            require_once "models/User.php";
            $profile = unserialize($_SESSION['profile']);
            $session = $_SESSION['session'];
            require_once "views/roles/" . $session . "/header.view.php";
            call_user_func([$controller, $action]);
            require_once "views/roles/" . $session . "/footer.view.php";
        } else {
            header("Location:?");
        }
    } else {
        header("Location:?");
    }

    ob_end_flush();
?>