<?php

class ProfileController extends BaseController
{
    private $userModel;
    private $feeds ;

    public function __construct($cnxDB)
    {
        parent::__construct();
        $this->userModel = new User($cnxDB);
        $this->feeds = new Rss_Feeds($cnxDB) ;
    }

    public function display_profile(){
        $data = $this->t->getAll();
        $user = $this->userModel->get_user_id($_SESSION['user_id']) ;
        $data['user'] = $user ;
        $data['rssFeeds'] = $this->feeds->get_all_Feeds() ;
        View::render('profilePage', $data);
        return;
    }

}

?>