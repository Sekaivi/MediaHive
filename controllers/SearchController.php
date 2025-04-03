<?php

class SearchController extends BaseController
{

    private $articleModel;
    private $rssModel;
    public function __construct($cnxDB)
    {
        parent::__construct();
        $this->articleModel = new Article($cnxDB);
        $this->rssModel = new Rss_Feeds($cnxDB);
    }

    public function popular_keywords_list()
    {
        $result = $this->articleModel->popular_keywords_list();
        if ($result) {
            echo json_encode([
                "success" => true,
                'keywords' => $result
            ]);
        } else {
            echo json_encode([
                "success" => false
            ]);
        }
        return;
    }

    public function search_suggestions_list()
    {
        $query = $_POST['query'] ?? '';
        $result = $this->articleModel->suggest_articles($query);
        if ($result) {
            echo json_encode([
                "success" => true,
                'articles' => $result
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "error" => $result
            ]);
        }
        return;
    }

    public function get_articles_category($category)
    {
        if ($category < 1 || $category > 9) {
            header("Location: " . BASE_URL . "/");
            exit;
        }
        $lang = $_SESSION['lang'] ;
        $data = $this->t->getAll();
        $feedList = $this->rssModel->get_cat_RSS_Feeds($category);
        $cleanedFeeds = [] ;
        foreach($feedList as &$feed){
            if($feed['language'] == $lang && count($cleanedFeeds)<3){
                $cleanedFeeds[] = $feed ;
            }
        }
        $articles = $this->articleModel->rss_articles($cleanedFeeds);
        foreach ($articles as &$article) {
            $id = $article['articleID'];
            $keywords = $this->articleModel->article_keyword_list($id);
            $article['keywords'] = $keywords;
        }
        $keyword_list = $this->articleModel->keywords_list();
        $data['articles'] = $articles;
        $data['keyword_list'] = $keyword_list;
        $data['category'] = $category ;
        $data['selectedFeeds'] = $cleanedFeeds;
        $data['feedList'] = $feedList ;
        View::render('category', $data);
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                var loadScreen = document.getElementById("loading-screen");
                if(loadScreen) {
                    loadScreen.style.display = "none";
                }
            });
          </script>';
        return;
        

    }

    public function update_articles_category($category){
        if ($category < 1 || $category > 9) {
            header("Location: " . BASE_URL . "/");
            exit;
        }
        $data = $this->t->getAll();
        $feeds = $_POST['feeds'] ;
        $feeds = $this->rssModel->get_RSS_Feeds_from($feeds) ;
        $feedList = $this->rssModel->get_cat_RSS_Feeds($category);
        $articles = $this->articleModel->rss_articles($feeds);
        foreach ($articles as &$article) {
            $id = $article['articleID'];
            $keywords = $this->articleModel->article_keyword_list($id);
            $article['keywords'] = $keywords;
        }
        $keyword_list = $this->articleModel->keywords_list();
        $data['articles'] = $articles;
        $data['keyword_list'] = $keyword_list;
        $data['category'] = $category ;
        $data['feedList'] = $feedList;
        $data['selectedFeeds'] = $feeds ;
        View::render('category', $data);
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                var loadScreen = document.getElementById("loading-screen");
                if(loadScreen) {
                    loadScreen.style.display = "none";
                }
            });
          </script>';
        return;
    }

}

?>