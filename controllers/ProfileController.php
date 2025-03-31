<?php

class ProfileController extends BaseController
{
    private $userModel;

    public function __construct($cnxDB)
    {
        parent::__construct();
        $this->userModel = new User($cnxDB);
    }

    public function display_profile(){
        $data = $this->t->getAll();
        $user = $this->userModel->get_user_id($_SESSION['user_id']) ;
        $data['user'] = $user ;
        View::render('profilePage', $data);
        return;
    }

}

?>