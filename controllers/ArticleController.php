<?php
class ArticleController extends BaseController {

    private $articleModel ;
    public function __construct($cnxDB)
    {
        parent::__construct();
        $this->articleModel = new Article($cnxDB) ;
    }

    public function index() {
        $data = $this->t->getAll();
        $articles = $this->articleModel->getArticles("cinema");
        $data[] = $articles ;
        View::render('home', $data);
        return;
    }
}

