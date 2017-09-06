<?php

class ControllerConnected extends Controller
{

    public function __construct($twig, $blog, Router $router)
    {
        parent::__construct($twig, $blog, $router);
    }

    //gestion de l'uploader d'article avec tags + photo
    public function addArticle()
    {
        if ($this->isConnected()) {
            //Ajout de l'article en base de donnée + ajout des tags et image
            if (isset($_POST['title'], $_POST['author'], $_POST['content'], $_FILES['image'])) {
                if ( ! empty($_POST['title']) AND ! empty($_POST['author']) AND ! empty($_POST['content']) AND ! empty ($_FILES['image']['name'])) {
                    if (exif_imagetype($_FILES['image']['tmp_name']) == 2) {


                        $title   = htmlspecialchars($_POST['title']);
                        $author  = htmlspecialchars($_POST['author']);
                        $content = htmlspecialchars($_POST['content']);
                        $tags    = $_POST['tags'];

                        $insBlog = $this->bdd->prepare('INSERT INTO blog (titre, auteur, contenu) VALUES (?, ?, ?)');
                        $insBlog->execute(array($title, $author, $content));

                        $lastid = $this->bdd->lastInsertId();

                        if ( ! empty($_POST['tags'])) {
                            foreach ($tags as $tag) {
                                $insTag = $this->bdd->prepare(
                                    'INSERT INTO blog_tags (id_article, id_tag) VALUES (?, ?)'
                                );
                                $insTag->execute(array($lastid, $tag));
                            }
                        }

                        $path = './assets/images/uploads/'.$this->clean($title).'_'.$lastid.'.jpg';
                        move_uploaded_file($_FILES['image']['tmp_name'], $path);
                        $insImg = $this->bdd->prepare('UPDATE blog SET image=:path WHERE id=:lastid');
                        $insImg->execute(array(':lastid' => $lastid, ':path' => $path));


                        $feedback = 'Votre article a bien été enregistré';
                    } else {
                        $feedback = 'Votre image doit être au format .jpg';
                    }
                } else {
                    $feedback = 'Veuillez remplir tous les champs';
                }
                $this->router->redirect('/add', $feedback);
            }
        } else {
            $feedback = 'Vous devez être connecté pour publier un article';
            $this->router->redirect('/', $feedback);
        }
    }

    //sanitize du nom de la photo afin de l'ajouter sur le server
    private function clean($string)
    {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }

    //ajout d'un commentaire sur un article donné
    public function addComment($id_article)
    {
        //Ajout de l'article en base de donnée + ajout des tags et image
        if (isset($_POST['comment_title'], $_POST['comment_content'])) {
            if ( ! empty($_POST['comment_title']) AND ! empty($_POST['comment_content'])) {
                $comment_title   = htmlspecialchars($_POST['comment_title']);
                $comment_content = htmlspecialchars($_POST['comment_content']);

                $insCom = $this->bdd->prepare('INSERT INTO comments (id_article, title, content) VALUES (?, ?, ?)');
                $insCom->execute(array($id_article, $comment_title, $comment_content));

                $feedback = 'Votre commentaire a bien été publié';
            } else {
                $feedback = 'Veuillez remplir tous les champs';
            }
            $this->router->redirect('/articles/'.$id_article, $feedback);
        }
    }

    //suppresssion de l'article par son id
    public function delete($id_article)
    {
        $queryDeleteBlog = $this->bdd->prepare('DELETE FROM blog WHERE id=:id');
        $queryDeleteBlog->execute(array(':id' => $id_article));

        $queryDeleteComments = $this->bdd->prepare('DELETE FROM comments WHERE id_article=:id');
        $queryDeleteComments->execute(array(':id' => $id_article));

        $queryDeleteTags = $this->bdd->prepare('DELETE FROM blog_tags WHERE id_article=:id');
        $queryDeleteTags->execute(array(':id' => $id_article));

        $feedback = 'L\'article avec l\'id : '.$id_article.' a bien été supprimé, ainsi que ses commentaires et tags associés';
        $this->router->redirect('/admin', $feedback);
    }

    //chargement de page d'administration si l'utilistateur est connecté
    public function admin()
    {
        if ($this->isConnected()) {
            $articles = $this->getAllArticles();

            echo $this->twig->render('admin.html.twig', array('articles' => $articles));
        } else {
            $feedback = 'Vous devez être connecté pour administré les artticces';
            $this->router->redirect('/', $feedback);
        }
    }
}