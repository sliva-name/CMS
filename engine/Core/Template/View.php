<?php


namespace Engine\Core\Template;


use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

class View
{

    /**
     * @var FilesystemLoader
     */
    private $loader;
    /**
     * @var Environment
     */
    private $twig;

    public function __construct()
    {
        $this->loader = new FilesystemLoader( ROOT_DIR . '\content\themes\default');
        $this->twig = new Environment($this->loader, [
            'cache' => ROOT_DIR . '\content\themes',
            'debug' => true
        ]);
    }

    /**
     * @param $template
     * @param array $vars
     */
    public function render($template, $vars = [])
    {
        try
        {
           echo $this->twig->render ($template .'.tpl', $vars);
        }
        catch (LoaderError | RuntimeError | SyntaxError $e)
        {
            exit($e->getMessage ());
        }
    }

}