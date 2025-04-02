<?php
class ArticleController extends BaseController {

    private $rssModel ;
    public function __construct($cnxDB)
    {
        parent::__construct();
        $this->rssModel = new Rss_Feeds($cnxDB) ;
    }

    public function index() {
        $data = $this->t->getAll();
        $ids = [1, 2];
        $rssFeeds = $this->rssModel->get_RSS_Feeds($ids) ;
        $articles = $this->rssModel->get_articles($rssFeeds) ;
        $data['articles'] = $articles ;
        View::render('home', $data);
        return;
    }
}
