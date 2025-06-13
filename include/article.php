<?php

class Article
{
    public $id;
    public $titre;
    public $signature;
    public $type1;
    public $type2;
    public $type3;
    public $image;
    public $video;
    public $credit;
    public $id_theme;

    // une méthode qui permet de modifier les attributs de l'objet sur lequel elle est appliquée
    function modifier($titre, $signature, $type1, $type2, $type3, $image, $video, $credit, $id_theme)
    {
        $this->titre = $titre;
        $this->signature = $signature;
        $this->type1 = $type1;
        $this->type2 = $type2;
        $this->type3 = $type3;
        $this->image = $image;
        $this->video = $video;
        $this->credit = $credit;
        $this->id_theme = $id_theme;
    }

    function chargePOST()
    {
        if (isset($_POST['id'])) {
            $this->id = $_POST['id'];
        } else {
            $this->id = '0';
        }
        if (isset($_POST['titre'])) {
            $this->titre = $_POST['titre'];
        } else {
            $this->titre = 'sans titre';
        }
        // On teste si la case 'signature' existe, si oui on copie sa valeur, sinon on utilise une valeur par défaut
        if (isset($_POST['signature'])) {
            $this->signature = $_POST['signature'];
        } else {
            $this->signature = '';
        }
        if (isset($_POST['type1'])) {
            $this->type1 = $_POST['type1'];
        } else {
            $this->type1 = '';
        }
        if (isset($_POST['type2'])) {
            $this->type2 = $_POST['type2'];
        } else {
            $this->type2 = null;
        }
        if (isset($_POST['type3'])) {
            $this->type3 = $_POST['type3'];
        } else {
            $this->type3 = null;
        }
        if (isset($_POST['credit'])) {
            $this->credit = $_POST['credit'];
        } else {
            $this->credit = null;
        }
        // Idem pour l'id theme
        if (isset($_POST['id_theme'])) {
            $this->id_theme = $_POST['id_theme'];
        } else {
            $this->id_theme = '';
        }
        $this->image = chargeFile('image');
        $this->video = chargeFile('video');
    }

    static function readByTheme($id)
    {
        // définition de la requête SQL avec un paramètre :valeur
        $sql = 'SELECT * FROM article WHERE id_theme = :valeur';

        // connexion à la base de données
        $pdo = connexion();

        // préparation de la requête
        $query = $pdo->prepare($sql);

        // on lie le paramètre :valeur à la variable $id reçue
        $query->bindValue(':valeur', $id, PDO::PARAM_INT);

        // exécution de la requête
        $query->execute();

        // récupération de toutes les lignes sous forme d'objets
        $tableau = $query->fetchAll(PDO::FETCH_CLASS, 'article');

        // retourne l'objet contenant résultat
        return $tableau;
    }

    static function readAll()
    {
        // définition de la requête SQL
        $sql = 'select * from article';

        // connexion
        $pdo = connexion();

        // préparation de la requête
        $query = $pdo->prepare($sql);

        // exécution de la requête
        $query->execute();

        // récupération de toutes les lignes sous forme d'objets
        $tableau = $query->fetchAll(PDO::FETCH_CLASS, 'Article');

        // retourne le tableau d'objets
        return $tableau;
    }

    static function readOne($id)
    {
        // définition de la requête SQL avec un paramètre :valeur
        $sql = 'select article.*, theme.couleur from article join theme on article.id_theme=theme.id where article.id = :valeur';
        // $sql = 'select * from article where article.id = :valeur ';

        // connexion à la base de données
        $pdo = connexion();

        // préparation de la requête
        $query = $pdo->prepare($sql);

        // on lie le paramètre :valeur à la variable $id reçue
        $query->bindValue(':valeur', $id, PDO::PARAM_INT);

        // exécution de la requête
        $query->execute();

        // récupération de l'unique ligne
        $objet = $query->fetchObject('Article');

        // retourne l'objet contenant résultat
        return $objet;
    }

    function create()
    {
        // construction de la requête :nom, :prenom sont les valeurs à insérées
        $sql = 'INSERT INTO article (titre, signature, type1, type2, type3, image, video, credit, id_theme) VALUES (:titre, :signature, :type1, :type2, :type3, :image, :video, :credit, :id_theme);';

        // connexion à la base de données
        $pdo = connexion();

        // préparation de la requête
        $query = $pdo->prepare($sql);

        // on donne une valeur aux paramètres à partir des attributs de l'objet courant
        $query->bindValue(':titre', $this->titre, PDO::PARAM_STR);
        $query->bindValue(':signature', $this->signature, PDO::PARAM_STR);
        $query->bindValue(':type1', $this->type1, PDO::PARAM_STR);
        $query->bindValue(':type2', $this->type2, PDO::PARAM_STR);
        $query->bindValue(':type3', $this->type3, PDO::PARAM_STR);
        $query->bindValue(':image', $this->image, PDO::PARAM_STR);
        $query->bindValue(':video', $this->video, PDO::PARAM_STR);
        $query->bindValue(':credit', $this->credit, PDO::PARAM_STR);
        $query->bindValue(':id_theme', $this->id_theme, PDO::PARAM_INT);

        // exécution de la requête
        $query->execute();

        // on récupère la clé de l'auteur inséré
        $this->id = $pdo->lastInsertId();

        // if ($this->image) {
        //     $this->image = "image" . $this->id;
        //     rename("../images/uploads/image", "../images/uploads/" . $this->image . ".jpg");
        //     $this->update();
        // }

        // if ($this->video) {
        //     $this->video = "video" . $this->id;
        //     rename("../images/uploads/video", "../images/uploads/" . $this->video . ".mp4");
        //     $this->update();
        // }
    }


    static function delete($id)
    {
        $article = Article::readOne($id);
        if ($article->image) {
            unlink("../images/uploads/" . $article->image);
        }

        if ($article->video) {
            unlink("../images/uploads/" . $article->video);
        }

        // construction de la requête :nom, :prenom sont les valeurs à insérées
        $sql = 'DELETE FROM article WHERE id = :id;';

        // connexion à la base de données
        $pdo = connexion();

        // préparation de la requête
        $query = $pdo->prepare($sql);

        // on lie le paramètre :id à la variable $id reçue
        $query->bindValue(':id', $id, PDO::PARAM_INT);

        // exécution de la requête
        $query->execute();
    }

    function update()
    {

        $article = Article::readOne($this->id);
        if ($article->image) {
            unlink("../images/uploads/" . $article->image);
        }

        if ($article->video) {
            unlink("../images/uploads/" . $article->video);
        }

        // if ($this->image) {
        //     $this->image = "image" . $this->id;
        //     rename("../images/uploads/image", "../images/uploads/" . $this->image . ".jpg");
        // }

        // if ($this->video) {
        //     $this->video = "video" . $this->id;
        //     rename("../images/uploads/video", "../images/uploads/" . $this->video . ".mp4");
        // }

        // construction de la requête :nom, :prenom sont les valeurs à insérées
        $sql = 'UPDATE article SET titre = :titre , signature = :signature , type1 = :type1 , type2 = :type2 , type3 = :type3 , image = :image , video = :video , credit = :credit , id_theme = :id_theme WHERE id = :id;';

        // connexion à la base de données
        $pdo = connexion();

        // préparation de la requête
        $query = $pdo->prepare($sql);

        // on donne une valeur aux paramètres à partir des attributs de l'objet courant
        $query->bindValue(':id', $this->id, PDO::PARAM_INT);
        $query->bindValue(':titre', $this->titre, PDO::PARAM_STR);
        $query->bindValue(':signature', $this->signature, PDO::PARAM_STR);
        $query->bindValue(':type1', $this->type1, PDO::PARAM_STR);
        $query->bindValue(':type2', $this->type2, PDO::PARAM_STR);
        $query->bindValue(':type3', $this->type3, PDO::PARAM_STR);
        $query->bindValue(':image', $this->image, PDO::PARAM_STR);
        $query->bindValue(':video', $this->video, PDO::PARAM_STR);
        $query->bindValue(':credit', $this->credit, PDO::PARAM_STR);
        $query->bindValue(':id_theme', $this->id_theme, PDO::PARAM_INT);

        // exécution de la requête
        $query->execute();
    }
}
