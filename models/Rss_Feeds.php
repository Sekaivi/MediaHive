<?php
class Rss_Feeds extends Model
{

    public function get_all_Feeds()
    {
        try {
            $sql = "SELECT * FROM rssfeeds";
            $rqt = $this->cnxDB->prepare($sql);
            $rqt->execute();
            $data = $rqt->fetchAll();
        } catch (PDOException $e) {
            echo "Erreur PDO: " . $e->getMessage();
        }
        return $data;
    }

    public function get_RSS_Feeds($ids)
    {
        try {
            $article_ids = implode(',', array_fill(0, count($ids), '?'));
            $sql = "SELECT * FROM rssfeeds WHERE feedID IN ($article_ids)";
            $rqt = $this->cnxDB->prepare($sql);
            $rqt->execute($ids);
            $data = $rqt->fetchAll();
        } catch (PDOException $e) {
            echo "Erreur PDO: " . $e->getMessage();
        }
        return $data;
    }

    public function get_RSS_Feeds_from($ids)
    {
        try {
            // Create a string with the correct number of placeholders for the 'IN' clause
            $placeholders = implode(',', array_fill(0, count($ids), '?'));

            // Prepare the SQL query with placeholders
            $sql = "SELECT * FROM rssfeeds WHERE feedID IN ($placeholders)";
            $rqt = $this->cnxDB->prepare($sql);

            // Execute the query by passing the $ids array
            $rqt->execute($ids);

            // Fetch all results
            $data = $rqt->fetchAll();
        } catch (PDOException $e) {
            echo "Erreur PDO: " . $e->getMessage();
        }

        return $data;
    }


    public function get_cat_RSS_Feeds($id)
    {
        $lang = $_SESSION['lang'];
        try {
            $sql = "SELECT * FROM rssfeeds WHERE category = :feed ORDER BY language";
            $rqt = $this->cnxDB->prepare($sql);
            $rqt->execute([
                'feed' => $id
            ]);
            $data = $rqt->fetchAll();
        } catch (PDOException $e) {
            echo "Erreur PDO: " . $e->getMessage();
        }
        return $data;
    }

}

