<?php
class ArticleModel {
    private $rssUrls = [
        "cinema"     => "https://www.allocine.fr/rss/news.xml",
        "jeux-video" => "https://www.jeuxvideo.com/rss/rss.xml",
        "anime"      => "https://news.google.com/rss/search?tbm=nws&q=manga&oq=manga&scoring=n&hl=fr&gl=FR&ceid=FR:fr",
        "comics"     => "https://www.comicbookmovie.com/rss/",
    ];

    public function getArticles($category = 'all') {
        $articles = [];
        $urls = $category === 'all' ? array_values($this->rssUrls) : [$this->rssUrls[$category]];
        foreach ($urls as $url) {
            $data = @file_get_contents($url);
            if ($data) {
                $xml = simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA);
                if ($xml) {
                    foreach ($xml->channel->item as $item) {
                        // Gérer les namespaces pour media:content
                        $namespaces = $item->getNameSpaces(true);
                        $media = isset($namespaces['media']) ? $item->children($namespaces['media']) : null;

                        // Récupérer l'image depuis <enclosure> ou <media:content>
                        if (isset($item->enclosure['url'])) {
                            $image = (string)$item->enclosure['url'];
                        } elseif ($media && isset($media->content)) {
                            $image = (string)$media->content->attributes()->url;
                        } else {
                            $image = "https://via.placeholder.com/320x180";
                        }

                        $articles[] = [
                            'title'       => (string)$item->title,
                            'link'        => (string)$item->link,
                            'description' => (string)$item->description,
                            'image'       => $image,
                            'keywords'    => [] // Initialement vide
                        ];
                    }
                }
            }
        }
        return $articles;
    }
}

