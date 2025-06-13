<?php

class Element
{
    public $id;
    public $balise;
    public $contenu;
    public $alt;
    public $image;
    public $video;
    public $audio;
    public $href;
    public $class;
    public $class2;
    public $class3;
    public $credit;
    public $id_article;

    // une méthode qui permet de modifier les attributs de l'objet sur lequel elle est appliquée
    function modifier($balise, $contenu, $alt, $image, $video, $audio, $href, $class, $class2, $class3, $credit, $id_article)
    {
        $this->balise = $balise;
        $this->contenu = $contenu;
        $this->alt = $alt;
        $this->image = $image;
        $this->video = $video;
        $this->audio = $audio;
        $this->href = $href;
        $this->class = $class;
        $this->class2 = $class2;
        $this->class3 = $class3;
        $this->credit = $credit;
        $this->id_article = $id_article;
    }

    function chargePOST()
    {
        if (isset($_POST['id'])) {
            $this->id = $_POST['id'];
        } else {
            $this->id = '0';
        }
        if (isset($_POST['balise'])) {
            $this->balise = $_POST['balise'];
        } else {
            $this->balise = 'sans balise';
        }
        // On teste si la case 'contenu' existe, si oui on copie sa valeur, sinon on utilise une valeur par défaut
        if (isset($_POST['contenu'])) {
            $this->contenu = $_POST['contenu'];
        } else {
            $this->contenu = '';
        }
        // Idem pour le alt
        if (isset($_POST['alt'])) {
            $this->alt = $_POST['alt'];
        } else {
            $this->alt = '';
        }
        // // Idem pour le src
        // if (isset($_POST['src'])) {
        //     $this->src = $_POST['src'];
        // } else {
        //     $this->src = '';
        // }
        // Idem pour le href
        if (isset($_POST['href'])) {
            $this->href = $_POST['href'];
        } else {
            $this->href = '';
        }
        // Idem pour la class
        if (isset($_POST['class'])) {
            $this->class = $_POST['class'];
        } else {
            $this->class = '';
        }
        if (isset($_POST['class2'])) {
            $this->class2 = $_POST['class2'];
        } else {
            $this->class2 = '';
        }
        if (isset($_POST['class3'])) {
            $this->class3 = $_POST['class3'];
        } else {
            $this->class3 = '';
        }
        // Idem pour le credit
        if (isset($_POST['credit'])) {
            $this->credit = $_POST['credit'];
        } else {
            $this->credit = '';
        }
        // Idem pour la id_article
        if (isset($_POST['id_article'])) {
            $this->id_article = $_POST['id_article'];
        } else {
            $this->id_article = '';
        }
        $this->image = chargeFile('image');
        $this->video = chargeFile('video');
        $this->audio = chargeFile('audio');
    }

    static function readByArticle($id)
    {
        // définition de la requête SQL avec un paramètre :valeur
        $sql = 'SELECT * FROM element WHERE id_article = :valeur ORDER BY id';

        // connexion à la base de données
        $pdo = connexion();

        // préparation de la requête
        $query = $pdo->prepare($sql);

        // on lie le paramètre :valeur à la variable $id reçue
        $query->bindValue(':valeur', $id, PDO::PARAM_INT);

        // exécution de la requête
        $query->execute();

        // récupération de toutes les lignes sous forme d'objets
        $tableau = $query->fetchAll(PDO::FETCH_CLASS, 'Element');

        // retourne l'objet contenant résultat
        return $tableau;
    }

    static function readAll()
    {
        // définition de la requête SQL
        $sql = 'SELECT * FROM element';

        // connexion
        $pdo = connexion();

        // préparation de la requête
        $query = $pdo->prepare($sql);

        // exécution de la requête
        $query->execute();

        // récupération de toutes les lignes sous forme d'objets
        $tableau = $query->fetchAll(PDO::FETCH_CLASS, 'Element');

        // retourne le tableau d'objets
        return $tableau;
    }

    static function readOne($id)
    {
        // définition de la requête SQL avec un paramètre :valeur
        $sql = 'SELECT * FROM element WHERE id = :valeur';

        // connexion à la base de données
        $pdo = connexion();

        // préparation de la requête
        $query = $pdo->prepare($sql);

        // on lie le paramètre :valeur à la variable $id reçue
        $query->bindValue(':valeur', $id, PDO::PARAM_INT);

        // exécution de la requête
        $query->execute();

        // récupération de l'unique ligne
        $objet = $query->fetchObject('Element');

        // retourne l'objet contenant résultat
        return $objet;
    }

    function create()
    {
        // construction de la requête :nom, :prenom sont les valeurs à insérées
        $sql = 'INSERT INTO element (balise, contenu, alt, image, video, audio, href, credit, class, class2, class3, id_article) VALUES (:balise, :contenu, :alt, :image, :video, :audio, :href, :credit, :class, :class2, :class3, :id_article);';

        // connexion à la base de données
        $pdo = connexion();

        // préparation de la requête
        $query = $pdo->prepare($sql);

        // on donne une valeur aux paramètres à partir des attributs de l'objet courant
        $query->bindValue(':balise', $this->balise, PDO::PARAM_STR);
        $query->bindValue(':contenu', $this->contenu, PDO::PARAM_STR);
        $query->bindValue(':alt', $this->alt, PDO::PARAM_STR);
        $query->bindValue(':image', $this->image, PDO::PARAM_STR);
        $query->bindValue(':video', $this->video, PDO::PARAM_STR);
        $query->bindValue(':audio', $this->audio, PDO::PARAM_STR);
        $query->bindValue(':href', $this->href, PDO::PARAM_STR);
        $query->bindValue(':credit', $this->credit, PDO::PARAM_STR);
        $query->bindValue(':class', $this->class, PDO::PARAM_STR);
        $query->bindValue(':class2', $this->class2, PDO::PARAM_STR);
        $query->bindValue(':class3', $this->class3, PDO::PARAM_STR);
        $query->bindValue(':id_article', $this->id_article, PDO::PARAM_INT);

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
        // if ($this->audio) {
        //     $this->audio = "audio" . $this->id;
        //     rename("../images/uploads/image", "../images/uploads/" . $this->image . ".mp3");
        //     $this->update();
        // }
    }


    static function delete($id)
    {

        $element = Element::readOne($id);
        if ($element->image) {
            unlink("../images/uploads/" . $element->image . ".jpg");
        }

        $element = Element::readOne($id);
        if ($element->video) {
            unlink("../images/uploads/" . $element->video . ".mp4");
        }

        $element = Element::readOne($id);
        if ($element->audio) {
            unlink("../images/uploads/" . $element->audio . ".mp3");
        }


        // construction de la requête :nom, :prenom sont les valeurs à insérées
        $sql = 'DELETE FROM element WHERE id = :id;';

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

        $element = Element::readOne($this->id);
        if ($element->image) {
            unlink("../images/uploads/" . $element->image . ".jpg");
        }

        if ($element->video) {
            unlink("../images/uploads/" . $element->video . ".mp4");
        }

        if ($element->audio) {
            unlink("../images/uploads/" . $element->audio . ".mp3");
        }

        // if ($this->image) {
        //     $this->image = "image" . $this->id;
        //     rename("../images/uploads/image", "../images/uploads/" . $this->image . ".jpg");
        // }

        // if ($this->video) {
        //     $this->video = "video" . $this->id;
        //     rename("../images/uploads/video", "../images/uploads/" . $this->video . ".mp4");
        // }

        // if ($this->audio) {
        //     $this->audio = "audio" . $this->id;
        //     rename("../images/uploads/audio", "../images/uploads/" . $this->audio . ".mp3");
        // }


        // construction de la requête :nom, :prenom sont les valeurs à insérées
        $sql = 'UPDATE element SET balise = :balise , contenu = :contenu , alt = :alt , image = :image , video = :video , audio = :audio , href = :href , class = :class , class2 = :class2 , class3 = :class3 , credit = :credit , id_article = :id_article WHERE id = :id;';

        // connexion à la base de données
        $pdo = connexion();

        // préparation de la requête
        $query = $pdo->prepare($sql);

        // on donne une valeur aux paramètres à partir des attributs de l'objet courant
        $query->bindValue(':id', $this->id, PDO::PARAM_INT);
        $query->bindValue(':balise', $this->balise, PDO::PARAM_STR);
        $query->bindValue(':contenu', $this->contenu, PDO::PARAM_STR);
        $query->bindValue(':alt', $this->alt, PDO::PARAM_STR);
        $query->bindValue(':image', $this->image, PDO::PARAM_STR);
        $query->bindValue(':video', $this->video, PDO::PARAM_STR);
        $query->bindValue(':audio', $this->audio, PDO::PARAM_STR);
        $query->bindValue(':href', $this->href, PDO::PARAM_STR);
        $query->bindValue(':class', $this->class, PDO::PARAM_STR);
        $query->bindValue(':class2', $this->class2, PDO::PARAM_STR);
        $query->bindValue(':class3', $this->class3, PDO::PARAM_STR);
        $query->bindValue(':credit', $this->credit, PDO::PARAM_STR);
        $query->bindValue(':id_article', $this->id_article, PDO::PARAM_INT);

        // exécution de la requête
        $query->execute();
    }
}
