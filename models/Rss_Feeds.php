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


}

