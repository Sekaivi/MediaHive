<?php

class SignUpController extends BaseController
{
    private $userModel;

    public function __construct($cnxDB)
    {
        parent::__construct();
        $this->userModel = new User($cnxDB);
    }

    public function signup_form()
    {
        if(isset($_SESSION['logged_in'])){
            header("Location:" . BASE_URL . "/profile");
            exit;
        }
        $data = $this->t->getAll();
        View::render('signupForm', $data);
        return;
    }

    public function handleSignup()
    {
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        if (empty($email) || empty($username) || empty($password)) {
            $_SESSION['error'] = true;
            header("Location:" . BASE_URL . "/signup");
            exit;
        }
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $this->userModel->register_user($username, $email, $hashedPassword);

        if (isset($_SESSION['error'])) {
            header("Location:" . BASE_URL . "/signup");
            exit();
        }

        // on success:
        header("Location:" . BASE_URL . "/signin");
        exit();

    }


}

?>