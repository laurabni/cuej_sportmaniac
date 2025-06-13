<?php

class Theme
{
    public $id;
    public $theme;
    public $articles;
    public $couleur;

    // une méthode qui permet de modifier les attributs de l'objet sur lequel elle est appliquée
    function modifier($theme)
    {
        $this->theme = $theme;
    }

    function affiche()
    {
        echo '<p>Thème : ' . $this->theme . '</p>';
        echo '<p>Couleur : ' . $this->couleur . '</p>';

        echo '<a href="controleur.php?page=element&id=' . $this->id . '">voir le détail</a>';
        echo '<br>';
        // Lien pour supprimer
        echo '<a href="controleur.php?page=element&action=delete&id=' . $this->id . '">supprimer</a>';
        echo '<br>';
        // Lien pour modifier
        echo '<a href="controleur.php?page=element&action=edit&id=' . $this->id . '">modifier</a>';
    }

    function chargePOST()
    {
        if (isset($_POST['id'])) {
            $this->id = $_POST['id'];
        } else {
            $this->id = '0';
        }
        if (isset($_POST['theme'])) {
            $this->theme = $_POST['theme'];
        } else {
            $this->theme = '';
        }
        if (isset($_POST['couleur'])) {
            $this->couleur = $_POST['couleur'];
        } else {
            $this->couleur = '';
        }
    }

    static function readAll()
    {
        // définition de la requête SQL
        $sql = 'SELECT * FROM theme';

        // connexion
        $pdo = connexion();

        // préparation de la requête
        $query = $pdo->prepare($sql);

        // exécution de la requête
        $query->execute();

        // récupération de toutes les lignes sous forme d'objets
        $tableau = $query->fetchAll(PDO::FETCH_CLASS, 'Theme');
        foreach ($tableau as $theme) {
            $theme->articles = Article::readByTheme($theme->id);
        }

        // retourne le tableau d'objets
        return $tableau;
    }

    static function readOne($id)
    {
        // définition de la requête SQL avec un paramètre :valeur
        $sql = 'SELECT * FROM theme WHERE id = :valeur LIMIT 1';

        // connexion à la base de données
        $pdo = connexion();

        // préparation de la requête
        $query = $pdo->prepare($sql);

        // on lie le paramètre :valeur à la variable $id reçue
        $query->bindValue(':valeur', $id, PDO::PARAM_INT);

        // exécution de la requête
        $query->execute();

        // récupération de l'unique ligne
        $objet = $query->fetchObject('Theme');

        // retourne l'objet contenant résultat
        return $objet;
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

    function create()
    {
        // construction de la requête :nom, :prenom sont les valeurs à insérées
        $sql = 'INSERT INTO theme (theme, couleur) VALUES (:theme, :couleur);';

        // connexion à la base de données
        $pdo = connexion();

        // préparation de la requête
        $query = $pdo->prepare($sql);

        // on donne une valeur aux paramètres à partir des attributs de l'objet courant
        $query->bindValue(':theme', $this->theme, PDO::PARAM_STR);
        $query->bindValue(':couleur', $this->couleur, PDO::PARAM_STR);

        // exécution de la requête
        $query->execute();

        // on récupère la clé de l'auteur inséré
        $this->id = $pdo->lastInsertId();
    }


    static function delete($id)
    {
        // construction de la requête :nom, :prenom sont les valeurs à insérées
        $sql = 'DELETE FROM theme WHERE id = :id;';

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
        // construction de la requête :nom, :prenom sont les valeurs à insérées
        $sql = 'UPDATE theme SET theme = :theme , couleur = :couleur WHERE id = :id;';

        // connexion à la base de données
        $pdo = connexion();

        // préparation de la requête
        $query = $pdo->prepare($sql);

        // on donne une valeur aux paramètres à partir des attributs de l'objet courant
        $query->bindValue(':id', $this->id, PDO::PARAM_INT);
        $query->bindValue(':theme', $this->theme, PDO::PARAM_STR);
        $query->bindValue(':couleur', $this->couleur, PDO::PARAM_STR);

        // exécution de la requête
        $query->execute();
    }
}
