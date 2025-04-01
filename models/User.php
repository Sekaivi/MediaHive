<?php

class User extends Model
{

    public function get_users()
    {
        try {
            $sql = "SELECT * FROM users";
            $rqt = $this->cnxDB->prepare($sql);
            $rqt->execute();
            $data = $rqt->fetchAll();
        } catch (PDOException $e) {
            echo "Erreur PDO: " . $e->getMessage();
        }
        return $data;
    }

    public function get_user_id($id)
    {
        try {
            $sql = "SELECT * FROM users where userID = :id";
            $rqt = $this->cnxDB->prepare($sql);
            $rqt->execute(["id" => $id]);
            $data = $rqt->fetch();
        } catch (PDOException $e) {
            echo "PDO error: " . $e->getMessage();
        }
        return $data;
    }

    public function get_user_email($email)
    {
        try {
            $sql = "SELECT * FROM users where email = :email";
            $rqt = $this->cnxDB->prepare($sql);
            $rqt->execute(["email" => $email]);
            $data = $rqt->fetch();
        } catch (PDOException $e) {
            echo "PDO error: " . $e->getMessage();
        }
        return $data;
    }

    public function register_user($username, $email, $password)
    {
        try {
            $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
            $rqt = $this->cnxDB->prepare($sql);
            $rqt->execute(["username" => $username, "email" => $email, "password" => $password]);
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $_SESSION['error'] = true;
            } else {
                echo "PDO error: " . $e->getMessage(); //  for debug 
            }
            header("Location:" . BASE_URL . "/signup");
            exit();
        }
    }

    public function preferences($user_id)
    {
        try {
            $sql = "SELECT f.feedName FROM preferences p JOIN rssfeeds f 
            ON p.rss_feed = f.feedID WHERE p.userID = :id ;";
            $rqt = $this->cnxDB->prepare($sql);
            $rqt->execute(["id" => $user_id]);
            $data = $rqt->fetchAll();
        } catch (PDOException $e) {
            echo "PDO error: " . $e->getMessage();
        }
        return $data;
    }

    public function bookmarks($user_id)
    {
        try {
            $sql = "SELECT a.* FROM bookmarks b JOIN articles a ON b.articleID = a.articleID WHERE b.userID = :id;";
            $rqt = $this->cnxDB->prepare($sql);
            $rqt->execute(["id" => $user_id]);
            $data = $rqt->fetchAll();
        } catch (PDOException $e) {
            echo "PDO error: " . $e->getMessage();
        }
        return $data;
    }

    public function update_user($user)
    {
        try {
            $sql = "UPDATE users SET username = :username , email = :email , profilePicture = :profilePicture , bio = :bio
            WHERE userID = :user_id ";
            $rqt = $this->cnxDB->prepare($sql);
            $success = $rqt->execute($user);
            return [
                'success' => $success,
                'message' => $success ? "Profile updated successfully" : "No changes made"
            ];
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => "PDO error: " . $e->getMessage()
            ];
        }
    }

    public function update_preferences($user_id , $feedID)
    {
        try {
            $sql = "INSERT INTO preferences (userID, rss_feed) VALUES (:user, :feed);";
            $rqt = $this->cnxDB->prepare($sql);
            $success = $rqt->execute([
                'user'=>$user_id,
                'feed'=>$feedID
            ]);
            return [
                'success' => $success,
                'message' => $success ? "Preferences updated" : "No changes made"
            ];
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => "PDO error: " . $e->getMessage()
            ];
        }
    }

}

?>