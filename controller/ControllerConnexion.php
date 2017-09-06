<?php


class ControllerConnexion extends Controller
{

    public function __construct($twig, $blog, Router $router)
    {
        parent::__construct($twig, $blog, $router);
    }

    //affichage de la page de connexion
    public function connexion()
    {
        echo $this->twig->render('login.html.twig', array('blogURL' => $this->blog));
    }

    //récupération des infos de connexion et gestion des messages d'erreurs / lancement de isValid();
    public function login()
    {
        if ((isset($_POST['user']) && ! empty($_POST['user'])) && (isset($_POST['password']) && ! empty($_POST['password']))) {
            $user     = addslashes($_POST['user']);
            $password = addslashes($_POST['password']);

            if ($this->isValid($user, $password) == true) {
                $_SESSION['user'] = $user;
                $this->router->redirect('/');
            } else {
                $feedback = "L'utilisateur ou le mot de passe est incorrect";
                $this->router->redirect('/connexion', $feedback);
            }
        } else {
            $feedback = "Vous n'avez pas saisi tous les champs";
            $this->router->redirect('/connexion', $feedback);
        }
    }

    //destruction de la variable permettant la mise en mémoire de la connexion
    public function logout()
    {
        if (isset($_SESSION['user'])) {
            unset($_SESSION['user']);
        }
        $this->router->redirect('/');
    }

    //vérification de la valité des informations rentrées lors de la connexion
    public function isValid($user, $password)
    {
        $queryUser = $this->bdd->prepare('SELECT * FROM user WHERE name=:name AND password=:password');
        if ( ! $queryUser->execute(array(':name' => $user, ':password' => $password))) {
            return false;
        }
        if ($queryUser->rowCount() == 1) {
            return true;
        } else {
            return false;
        }
    }

}