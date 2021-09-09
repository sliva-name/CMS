<?php


namespace Cms\Controller;


use Engine\Application\Common;

class HomeController extends CmsController
{

    public function index()
    {
        $mas = [
            'name' => 'maik',
            'rout' => Common::getUrl ()
        ];
        $this->view->render('index', $mas);
    }
    public function news($id)
    {
        echo "news $id";
    }

}