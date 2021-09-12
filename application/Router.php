<?php

$this->router->add('home', '/', 'HomeController:index');
$this->router->add('news_single', '/news/(id:int)', 'HomeController:news');
