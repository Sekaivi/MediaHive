<?php

class SignOutController extends BaseController
{


    public function handle_signout()
    {
        if (!isset($_SESSION['logged_in'])) {
            header("Location:" . BASE_URL . "/signin");
            exit;
        }
        $_SESSION = [];
        session_destroy();
        header("Location:" . BASE_URL . "/");
        exit;
    }

}

?>