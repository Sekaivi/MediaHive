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
        
        View::render('home', $data);
        return;
    }
}
