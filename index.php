<?php
    ob_start();
    session_start();
    // session_destroy();

    require_once "models/DataBase.php";

    $defaultController = "Landing";

    $availableControllers = array_map(function ($file) {
        return basename($file, ".php");
    }, glob("controllers/*.php"));

    $requestedController = isset($_REQUEST['c']) ? $_REQUEST['c'] : $defaultController;

    if (!in_array($requestedController, $availableControllers, true)) {
        $requestedController = $defaultController;
    }

    $controller = $requestedController;
    $route_controller = "controllers/" . $controller . ".php";

    if (file_exists($route_controller)) {
        $view = $controller;
        require_once $route_controller;
        $controller = new $controller;
        $action = isset($_REQUEST['a']) ? $_REQUEST['a'] : 'main';

        if ($view === 'Landing' || $view === 'Login') {
            require_once "views/company/header.view.php";
            call_user_func(array($controller, $action));
            require_once "views/company/footer.view.php";
        } elseif (!empty($_SESSION['session'])) {
            require_once "models/User.php";
            $profile = unserialize($_SESSION['profile']);
            $session = $_SESSION['session'];
            require_once "views/roles/" . $session . "/header.view.php";
            call_user_func(array($controller, $action));
            require_once "views/roles/" . $session . "/footer.view.php";
        } else {
            header("Location:?");
        }
    } else {
        header("Location:?");
    }

    ob_end_flush();
?>