<?php

require_once __DIR__.'/../db/db-info.php';


class Controller
{

    protected $bdd;
    protected $twig;
    protected $router;
    protected $blog;

    public function __construct($twig, $blog, Router $router)
    {
        $this->twig   = $twig;
        $this->bdd    = new PDO(
            "mysql:host=".HOST.";port=".PORT.";dbname=".DB,
            USER,
            PWD,
            array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_PERSISTENT => true)
        );
        $this->blog   = $blog;
        $this->router = $router;
    }

    //affichage des articles
    public function articles()
    {
        $articles = $this->getAllArticles();

        echo $this->twig->render('list.html.twig', array('articles' => $articles));
    }

    //récupération de tous les articles
    public function getAllArticles()
    {
        $articles = [];
        foreach ($this->bdd->query('SELECT * FROM blog') as $row) {
            $row['tags'] = $this->getTags($row['id']);
            array_push($articles, $row);
        }

        return $articles;
    }

    //récupération d'un article par l'id
    public function getArticle($id, $feedback = null)
    {
        $queryArticle = $this->bdd->prepare('SELECT * FROM blog WHERE id = :id');
        if ( ! $queryArticle->execute(array(':id' => $id))) {
            return false;
        }
        $article = $queryArticle->fetch(\PDO::FETCH_ASSOC);

        $queryComments = $this->bdd->prepare('SELECT * FROM comments  WHERE id_article =:id');
        if ( ! $queryComments->execute(array(':id' => $id))) {
            return false;
        }
        $comments = $queryComments->fetchAll(\PDO::FETCH_ASSOC);

        echo $this->twig->render(
            'single.html.twig',
            array(
                'article'  => $article,
                'comments' => $comments,
                'tags'     => $this->getTags($id),
                'feedback' => $feedback,
                'blogURL'  => $this->blog,
            )
        );
    }

    //récupération de la liste de tag (pour charger le multiple select dans le formulaire)
    public function getAllTags()
    {
        $queryTags = $this->bdd->prepare('SELECT * FROM tags');
        if ( ! $queryTags->execute()) {
            return false;
        }

        return $listTags = $queryTags->fetchAll(\PDO::FETCH_ASSOC);
    }

    //récupération des tags correspodant à un article avec son id
    public function getTags($id_article)
    {
        $queryTags = $this->bdd->prepare(
            'SELECT name FROM tags AS T INNER JOIN blog_tags AS J ON T.id = J.id_tag INNER JOIN blog AS B ON B.id = J.id_article WHERE B.id =:id'
        );
        if ( ! $queryTags->execute(array(':id' => $id_article))) {
            return false;
        }

        return $tags = $queryTags->fetchAll(\PDO::FETCH_ASSOC);
    }

    //retourne true si l'utilisater est connecté, false si il ne l'est pas
    public function isConnected()
    {
        if ( ! empty($_SESSION['user']) AND isset($_SESSION['user'])) {
            return true;
        } else {
            return false;
        }
    }

}