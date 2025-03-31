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
<<<<<<< HEAD
        
        View::render('home', $data);
        return;
    }
}
=======
        $articles = $this->articleModel->getArticles("cinema");
        $data[] = $articles ;
        View::render('home', $data);
        return;
    }
}

>>>>>>> 38c97c2a7c21885c6f0ca7ab019c19a977e8285c
