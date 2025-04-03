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
                "success" => false ,
                "error" => $result
            ]);
        }
        return;
    }

    public function get_articles_category($category){
        // check if category exists and then shows
        $categories = 
        echo 'test'.$category ;
    }

}

?>