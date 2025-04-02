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

    public function get_articles($rssFeeds)
{
    $articles = [];
    foreach ($rssFeeds as $feed) {
        $data = @file_get_contents($feed['feedURL']);
        if ($data) {
            $xml = simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA);
            if ($xml) {
                foreach ($xml->channel->item as $item) {
                    // Gestion des namespaces pour media:content
                    $namespaces = $item->getNameSpaces(true);
                    $media = isset($namespaces['media']) ? $item->children($namespaces['media']) : null;

                    // Récupération de l'image depuis <enclosure> ou <media:content>
                    if (isset($item->enclosure['url'])) {
                        $image = (string) $item->enclosure['url'];
                    } elseif ($media && isset($media->content)) {
                        $image = (string) $media->content->attributes()->url;
                    } else {
                        $image = "https://via.placeholder.com/320x180";
                    }

                    $articles[] = [
                        'title'       => (string) $item->title,
                        'link'        => (string) $item->link,
                        'description' => (string) $item->description,
                        'image'       => $image,
                        'keywords'    => [] // Initialement vide
                    ];
                }
            }
        }
    }
    // Une fois les articles récupérés, on insère un script pour masquer l'écran de chargement.
    // Ce script s'exécutera lorsque le DOM sera complètement chargé.
    echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                var loadScreen = document.getElementById("loading-screen");
                if(loadScreen) {
                    loadScreen.style.display = "none";
                }
            });
          </script>';
    return $articles;
}


}

