<?php
class Article extends Model {
    private $rssUrls = [ // try to make this work with DB
        "cinema"     => "https://www.allocine.fr/rss/news.xml",
        "jeux-video" => "https://www.jeuxvideo.com/rss/rss.xml",
        "anime"      => "https://news.google.com/rss/search?tbm=nws&q=manga&oq=manga&scoring=n&hl=fr&gl=FR&ceid=FR:fr",
        "comics"     => "https://www.comicbookmovie.com/rss/",
    ];

    public function get_articles(){
        
    }

}

