<?php

class ProfileController extends BaseController
{
    private $userModel;
    private $feeds;

    public function __construct($cnxDB)
    {
        parent::__construct();
        $this->userModel = new User($cnxDB);
        $this->feeds = new Rss_Feeds($cnxDB);
    }

    public function display_profile()
    {
        $data = $this->t->getAll();
        $user = $this->userModel->get_user_id($_SESSION['user_id']);
        $data['user'] = $user;
        $data['rssFeeds'] = $this->feeds->get_all_Feeds();
        $data['setPrefs'] = $this->userModel->preferences($user['userID']);
        $data['currentBookmarks'] = $this->userModel->bookmarks($user["userID"]);
        View::render('profilePage', $data);
        return;
    }

    public function update_profile()
    {
        if (isset($_POST) && !empty($_POST)) {
            $username = $_POST['username'] ?? null;
            $email = $_POST['email'] ?? null;
            $profilePicture = $_POST['profilePicture'] ?? null;
            $bio = $_POST['bio'] ?? null;
            $user_id = $_SESSION['user_id'];
            $user = [
                'username' => $username,
                'email' => $email,
                'profilePicture' => $profilePicture,
                'bio' => $bio,
                'user_id' => $user_id
            ];
            $result = $this->userModel->update_user($user);
            header('Content-Type: application/json');
            if ($result['success']) {
                echo json_encode([
                    "success" => true,
                    'user' => $user
                ]);
            }
        }
        unset($_POST);
    }


    public function update_preferences()
    {
        if (isset($_POST) && !empty($_POST)) {
            $feedID = $_POST['feedID'];
            $feedName = $_POST['feedName'];
            $user_id = $_SESSION['user_id'];
            $result = $this->userModel->update_preferences($user_id, $feedID);
            header('Content-Type: application/json');
            if ($result['success']) {
                echo json_encode([
                    "success" => true,
                    'feedName' => $feedName,
                    'prefID' => $result['prefID'] ?? ''
                ]);
                return;
            } else {
                echo json_encode($result);
                return;
            }
            // PENSER A AJOUTER UNE MAMNIERE D'ENLEVER UN FEED
        }
        unset($_POST);
    }

    public function remove_preference(){
        $feedID = $_POST['prefID'] ;
        $result = $this->userModel->remove_preference($feedID);
        header('Content-Type: application/json');
            if ($result['success']) {
                echo json_encode([
                    "success" => true
                ]);
                return;
            } else {
                echo json_encode($result);
                return;
            }
    }

}

?>