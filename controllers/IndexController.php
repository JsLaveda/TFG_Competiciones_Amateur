<?php
class IndexController {
    public function index() {
        $view = new View();
        $view->show('index.php');
    }
}
