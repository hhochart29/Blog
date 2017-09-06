<?php
//Autoloader pour TWIG
require_once __DIR__.'/vendor/autoload.php';
//Autoloader des différentes controllers
require_once('Autoloader.php');
Autoloader::register();

//Afin de garder les messages d'erreurs en mémoire
session_start();


class Router
{
    protected $loader;
    protected $blog;

    public function __construct()
    {
        $this->loader = new Twig_Loader_Filesystem('templates'); // Dossier contenant les templates
        $this->twig   = new Twig_Environment(
            $this->loader, array(
                'cache' => false,
            )
        );
        $this->blog   = dirname(getenv("SCRIPT_NAME"));

    }

    //Routing
    public function main()
    {

        $controller           = new Controller($this->twig, $this->blog, $this);
        $controller_connected = new ControllerConnected($this->twig, $this->blog, $this);
        $controller_connexion = new ControllerConnexion($this->twig, $this->blog, $this);

        $this->getHeader($controller);

        $url = '';
        if (isset($_GET['url'])) {
            $url      = $_GET['url'];
            $page     = array_shift(explode('/', $url));
            $urlparts = explode('/', $url);
        }
        switch ($page) {
            case '':
                $controller->articles();
                break;
            case 'connexion':
                $controller_connexion->connexion();
                break;
            case 'deconnexion':
                $controller_connexion->logout();
                $this->redirect('/');
                break;
            case 'login':
                $controller_connexion->login();
                break;
            case 'add':
                if ($controller_connexion->isConnected()) {
                    echo $this->twig->render(
                        'add.html.twig',
                        array('tags' => $controller->getAllTags(), 'blogURL' => $this->blog)
                    );
                } else {
                    $feedback = 'Vous devez être connecté pour publier un article';
                    $this->redirect('/', $feedback);
                }
                break;
            case 'upload':
                $controller_connected->addArticle();
                break;
            case 'addcomment':
                $controller_connected->addComment($urlparts['1']);
                break;
            case 'articles':
                if (isset($urlparts['1'])) {
                    $controller->getArticle($urlparts['1']);
                }
                break;
            case 'admin':
                $controller_connected->admin();
                break;
            case 'delete':
                if (isset($urlparts['1'])) {
                    $controller_connected->delete($urlparts['1']);
                }
            default:
                echo $this->twig->render('404.html.twig');
                break;
        }
        $this->getFooter();
    }

    //chargement des templates
    private function getHeader(Controller $controller)
    {
        echo $this->twig->render(
            'header.html.twig',
            array(
                'blogURL'   => $this->blog,
                'feedback'  => $_SESSION['feedback'],
                'connected' => $controller->isConnected(),
                'user'      => $_SESSION['user'],
            )
        );
    }

    private function getFooter()
    {
        if (isset($_SESSION['feedback'])) {
            unset($_SESSION['feedback']);
        }
        echo $this->twig->render('footer.html.twig');
    }

    public function redirect($url, $feedback = null)
    {
        if ($feedback != null) {
            $_SESSION["feedback"] = $feedback;
        }
        header("HTTP/1.1 303 See Other");
        header("Location: ".$this->blog.$url);
        exit();
    }

}

$routeur = new Router();
$routeur->main();