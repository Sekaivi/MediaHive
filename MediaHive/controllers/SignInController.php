<?php

class SignInController extends BaseController
{
    private $userModel;

    public function __construct($cnxDB)
    {
        parent::__construct();
        $this->userModel = new User($cnxDB);
    }

    public function signin_form()
    {
        if(isset($_SESSION['logged_in'])){
            header("Location:" . BASE_URL . "/profile");
            exit;
        }
        $data = $this->t->getAll();
        View::render('signinForm', $data);
        return;
    }

    public function handleConnexion()
    {
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        if (empty($email) || empty($password)) {
            $_SESSION['error'] = true;
            header("Location:" . BASE_URL . "/signin");
            exit;
        }
        $user = $this->userModel->get_user_email($email);
        if ($user && (password_verify($password, $user['password']))) {
            $_SESSION['user_id'] = $user['userID'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['logged_in'] = true;
            header("Location:" . BASE_URL . "/profile");
            exit;
        } else {
            $_SESSION['error'] = true;
            header("Location:" . BASE_URL . "/signin");
            exit;
        }
    }

}

?>