<<<<<<< HEAD
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

    public function preferences($user_id){
        
    }

}

=======
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

}

>>>>>>> 38c97c2a7c21885c6f0ca7ab019c19a977e8285c
?>