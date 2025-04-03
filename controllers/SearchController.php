<?php

class SearchController extends BaseController
{

    private $articleModel;
    public function __construct($cnxDB)
    {
        parent::__construct();
        $this->articleModel = new Article($cnxDB);
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
        if ($category < 9 && $category > 0) {
            
            $categories = 'test';
            echo 'test' . $category;
        }
        else{
            header("Location:" . BASE_URL . "/");
            exit;
        }
        
        // reucpere l'ID, suggere des feed selon l'id, et BOUM resultats. + des filtres... ? idk genre popularité, récents... ? XD
        // appeler la méthode get article qui les save et tout

    }

}

?>