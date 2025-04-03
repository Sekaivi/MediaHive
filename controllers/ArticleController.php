<?php
class ArticleController extends BaseController {

    private $rssModel ;
    private $articleModel ;

    public function __construct($cnxDB)
    {
        parent::__construct();
        $this->rssModel = new Rss_Feeds($cnxDB) ;
        $this->articleModel = new Article($cnxDB) ;
    }

    public function index() {
        $data = $this->t->getAll();
        $ids = [1, 2];
        $rssFeeds = $this->rssModel->get_RSS_Feeds($ids) ;
        $articles = $this->articleModel->rss_articles($rssFeeds) ;
        $trendingArticles = $this->articleModel->get_trending_articles() ;
        foreach($trendingArticles as &$article){
            $id = $article['articleID'] ;
            $keywords = $this->articleModel->article_keyword_list($id) ;
            $article['keywords'] = $keywords ;
        }
        $data['trendingArticles'] = $trendingArticles ;
        $keyword_list = $this->articleModel->keywords_list() ;
        $data['articles'] = $articles ;
        $data['keyword_list'] = $keyword_list ;
        View::render('home', $data);
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
        return;
    }

    public function handleLike(){
        $articleID = $_POST['articleID'] ;
        $user = $_SESSION['user_id'] ;
        $result = $this->articleModel->like_article($articleID , $user) ;
        if($result){
            echo json_encode([
                "success" => true
            ]);
            return;
        } else {
            echo json_encode(["success" => false]);
            return;
        }
    }

    public function handleBookmark() {
        $articleID = $_POST['articleID'] ;
        $user = $_SESSION['user_id'] ;
        $result = $this->articleModel->bookmark_article($articleID , $user) ;
        if($result){
            echo json_encode([
                "success" => true
            ]);
            return;
        } else {
            echo json_encode(["success" => false]);
            return;
        }
    }

    public function updateKeywords(){
        $keywordID = $_POST['keywordID'] ;
        $articleID = $_POST['articleID'] ;
        $userID = $_SESSION['user_id'] ;
        $result = $this->articleModel->update_keywords($articleID , $keywordID , $userID) ;
        if($result == 'DELETE'){
            echo json_encode([
                "success" => true,
                'action' => $result
            ]);
        }else if($result == 'INSERT'){
            echo json_encode([
                "success" => true,
                'action' => $result
            ]);
        }else{
            echo json_encode([
                "success" => false,
                'error' => $result
            ]);
        }
        return ;
    }

}
