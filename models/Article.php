<?php

class Article extends Model
{
    public function rss_articles($rssFeeds)
    {
        $articles = [];
        foreach ($rssFeeds as $feed) {
            $data = @file_get_contents($feed['feedURL']);
            if ($data) {
                $xml = simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA);
                if ($xml) {
                    foreach ($xml->channel->item as $item) {
                        // Gérer les namespaces pour media:content
                        $namespaces = $item->getNameSpaces(true);
                        $media = isset($namespaces['media']) ? $item->children($namespaces['media']) : null;

                        // Récupérer l'image depuis <enclosure> ou <media:content>
                        if (isset($item->enclosure['url'])) {
                            $image = (string) $item->enclosure['url'];
                        } elseif ($media && isset($media->content)) {
                            $image = (string) $media->content->attributes()->url;
                        } else {
                            $image = "https://via.placeholder.com/320x180";
                        }

                        $articles[] = [
                            'title' => (string) $item->title,
                            'link' => (string) $item->link,
                            'description' => (string) $item->description,
                            'image' => $image,
                            'sourceID' => $feed['feedID']
                        ];
                    }
                }
            }
        }
        if ($articles) {
            $this->save_articles($articles);
            return $this->get_articles();
        } else {
            return false;
        }
    }

    private function save_articles($articles)
    {
        // enregistrer et les renvoyer
        try {
            $sql_delete = "DELETE articles
            FROM articles
            LEFT JOIN bookmarks ON articles.articleID = bookmarks.articleID
            LEFT JOIN article_keywords ON articles.articleID = article_keywords.articleID
            LEFT JOIN article_likes ON articles.articleID = article_likes.articleID
            LEFT JOIN teamspicks ON articles.articleID = teamspicks.articleID
            WHERE bookmarks.articleID IS NULL
            AND article_keywords.articleID IS NULL
            AND article_likes.articleID IS NULL
            AND teamspicks.articleID IS NULL";
            $rqt_delete = $this->cnxDB->prepare($sql_delete);
            $rqt_delete->execute();

            foreach ($articles as $article) {
                $sql = "INSERT INTO articles (sourceID, URL, title, description, image) 
                VALUES (:source , :url, :title , :description , :image) 
                ON DUPLICATE KEY UPDATE 
                sourceID = VALUES(sourceID), 
                URL = VALUES(URL), 
                description = VALUES(description), 
                image = VALUES(image)";

                $rqt = $this->cnxDB->prepare($sql);

                $result = $rqt->execute([
                    'source' => $article['sourceID'],
                    'url' => $article['link'],
                    'title' => $article['title'],
                    'description' => $article['description'],
                    'image' => $article['image']
                ]);
            }

            return $result;
        } catch (PDOException $e) {
            echo "PDO error: " . $e->getMessage();
        }
    }

    public function get_articles()
    {
        try {
            $sql = "SELECT articles.*, f.feedName, k.*
            FROM articles
            JOIN rssFeeds AS f ON f.feedID = articles.sourceID
            LEFT JOIN article_keywords AS ak ON articles.articleID = ak.articleID
            LEFT JOIN keywords AS k ON k.keywordID = ak.keywordID;
            ";
            $rqt = $this->cnxDB->prepare($sql);
            $rqt->execute();
            $data = $rqt->fetchAll();
        } catch (PDOException $e) {
            echo "PDO ERROR: " . $e->getMessage();
        }
        return $data;
    }

    public function get_trending_articles()
    {
        try {
            $sql = "SELECT a.*, f.feedName, COUNT(al.articleID) AS popularity 
        FROM articles a
        JOIN rssFeeds AS f ON f.feedID = a.sourceID
        LEFT JOIN article_likes al ON a.articleID = al.articleID
        GROUP BY a.articleID, f.feedName
        ORDER BY popularity DESC 
        LIMIT 4;";

            $rqt = $this->cnxDB->prepare($sql);
            $rqt->execute();
            $data = $rqt->fetchAll();
        } catch (PDOException $e) {
            echo "PDO ERROR: " . $e->getMessage();
        }
        return $data;
    }

    public function like_article($articleID, $userID)
    {
        try {
            $sql_check = "SELECT COUNT(*) FROM article_likes WHERE articleID = :articleID AND userID = :userID";
            $rqt_check = $this->cnxDB->prepare($sql_check);
            $rqt_check->execute([
                'articleID' => $articleID,
                'userID' => $userID
            ]);
            $count = $rqt_check->fetchColumn();

            // If the article is already liked by the user, delete the like
            if ($count > 0) {
                $sql_delete = "DELETE FROM article_likes WHERE articleID = :articleID AND userID = :userID";
                $rqt_delete = $this->cnxDB->prepare($sql_delete);
                $rqt_delete->execute([
                    'articleID' => $articleID,
                    'userID' => $userID
                ]);
                return "Like removed";

            } else {
                $sql_insert = "INSERT INTO article_likes (articleID, userID) VALUES (:articleID, :userID)";
                $rqt_insert = $this->cnxDB->prepare($sql_insert);
                $result = $rqt_insert->execute([
                    'articleID' => $articleID,
                    'userID' => $userID
                ]);
            }

        } catch (PDOException $e) {
            // Handle any errors that occur during the database operations
            echo "PDO error: " . $e->getMessage();
            return "Error handling like";
        }
        return $result;
    }

    public function bookmark_article($articleID, $userID)
    {
        try {
            $sql_check = "SELECT COUNT(*) FROM bookmarks WHERE articleID = :articleID AND userID = :userID";
            $rqt_check = $this->cnxDB->prepare($sql_check);
            $rqt_check->execute([
                'articleID' => $articleID,
                'userID' => $userID
            ]);
            $count = $rqt_check->fetchColumn();

            // If the article is already liked by the user, delete the like
            if ($count > 0) {
                $sql_delete = "DELETE FROM bookmarks WHERE articleID = :articleID AND userID = :userID";
                $rqt_delete = $this->cnxDB->prepare($sql_delete);
                $rqt_delete->execute([
                    'articleID' => $articleID,
                    'userID' => $userID
                ]);
                return "bookmark removed";

            } else {
                $sql_insert = "INSERT INTO bookmarks (articleID, userID) VALUES (:articleID, :userID)";
                $rqt_insert = $this->cnxDB->prepare($sql_insert);
                $result = $rqt_insert->execute([
                    'articleID' => $articleID,
                    'userID' => $userID
                ]);
            }

        } catch (PDOException $e) {
            // Handle any errors that occur during the database operations
            echo "PDO error: " . $e->getMessage();
            return "Error handling like";
        }
        return $result;
    }

    public function suggest_articles($query)
    {
        try {
            $query = "%" . $query . "%";
            // only select title ? since we don't need the rest
            $sql = "SELECT a.*, COUNT(al.articleID) AS likes 
                FROM articles a
                LEFT JOIN article_likes al ON a.articleID = al.articleID
                WHERE a.title LIKE :searchTitle OR a.description LIKE :searchDesc
                GROUP BY a.articleID
                ORDER BY likes DESC
                LIMIT 10";
            $rqt = $this->cnxDB->prepare($sql);

            $rqt->execute([
                'searchTitle'=>$query ,
                'searchDesc'=>$query
        ]);
            $data = $rqt->fetchAll();
        } catch (PDOException $e) {
            return "PDO ERROR: " . $e->getMessage();
        }
        return $data;
    }


    public function keywords_list()
    {
        try {
            $sql = "SELECT * FROM keywords ORDER BY keywordName ASC";
            $rqt = $this->cnxDB->prepare($sql);
            $rqt->execute();
            $data = $rqt->fetchAll();
        } catch (PDOException $e) {
            echo "PDO ERROR: " . $e->getMessage();
        }
        return $data;
    }

    public function popular_keywords_list()
    {
        try {
            $sql = "SELECT k.*, COUNT(ak.articleID) AS popularity
            FROM keywords k 
            LEFT JOIN article_keywords ak ON k.keywordID = ak.keywordID
            GROUP BY k.keywordID
            ORDER BY popularity DESC 
            LIMIT 10;";
            $rqt = $this->cnxDB->prepare($sql);
            $rqt->execute();
            $data = $rqt->fetchAll();
        } catch (PDOException $e) {
            echo "PDO ERROR: " . $e->getMessage();
        }
        return $data;
    }

    public function article_keyword_list($article)
    {
        try {
            $sql = "SELECT k.keywordName , k.keywordID 
            FROM keywords k JOIN article_keywords ak ON k.keywordID = ak.keywordID WHERE ak.articleID = :article";
            $rqt = $this->cnxDB->prepare($sql);
            $rqt->execute(['article' => $article]);
            $data = $rqt->fetchAll();
        } catch (PDOException $e) {
            echo "PDO ERROR: " . $e->getMessage();
        }
        return $data;
    }

    public function update_keywords($article, $keyword, $user)
    {
        try {
            $sql_check = "SELECT COUNT(*) FROM article_keywords WHERE articleID = :article AND userID = :user 
                          AND keywordID = :keyword";
            $rqt_check = $this->cnxDB->prepare($sql_check);
            $rqt_check->execute([
                'article' => $article,
                'user' => $user,
                'keyword' => $keyword
            ]);
            $count = $rqt_check->fetchColumn();

            if ($count > 0) {
                // If the reference exists, delete it
                $sql_delete = "DELETE FROM article_keywords WHERE articleID = :article AND userID = :user 
                               AND keywordID = :keyword";
                $rqt_delete = $this->cnxDB->prepare($sql_delete);
                $rqt_delete->execute([
                    'article' => $article,
                    'user' => $user,
                    'keyword' => $keyword
                ]);
                return "DELETE";
            } else {
                // Insert the new keyword
                $sql_insert = "INSERT INTO article_keywords (articleID, userID, keywordID) VALUES (:article, :user, :keyword)";
                $rqt_insert = $this->cnxDB->prepare($sql_insert);
                $success = $rqt_insert->execute([
                    'article' => $article,
                    'user' => $user,
                    'keyword' => $keyword
                ]);

                return $success ? "INSERT" : "ERROR";
            }
        } catch (PDOException $e) {
            return "ERROR: " . $e->getMessage();
        }

    }

}

?>