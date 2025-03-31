<?php
class ArticleController {
    public function index() {
        require_once 'app/models/ArticleModel.php';
        $model = new ArticleModel();
        $articles = $model->getArticles();
        require_once 'app/views/home.php';
    }
}

