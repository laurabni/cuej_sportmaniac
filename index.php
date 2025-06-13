<?php
// Initialise Twig
require_once('./vendor/autoload.php');
include('include/twig.php');
$twig = init_twig();

// Récupère les données GET sur l'URL
if (isset($_GET['id'])) $id = $_GET['id'];
else $id = 0;

// Convertit l'identifiant en entier
$id = intval($id);


// Connexion à la base de données
include('include/connexion.php');
$pdo = connexion();

include('include/theme.php');
include('include/article.php');
include('include/element.php');

// récupération de la variable page sur l'URL
if (isset($_GET['page'])) $page = $_GET['page'];
else $page = '';

// récupération de la variable action sur l'URL
if (isset($_GET['action'])) $action = $_GET['action'];
else $action = 'read';

// récupération de l'id s'il existe (par convention la clé 0 correspond à un id inexistant)
if (isset($_GET['id'])) $id = intval($_GET['id']);
else $id = 0;

// test des différents choix
switch ($page) {
    case 'article':
        switch ($action) {
            case 'read':
                $modele = 'article_element.twig';
                $article = Article::readOne($id);
                $articles = Article::readByTheme($article->id_theme);
                $data = [
                    'article' => $article,
                    'articles' => $articles,
                    'element' => Element::readByArticle($id)    
                ];
                break;
            default:
                // Page vide ou page d'erreur
                $modele = 'base.twig';
                $data = [];
        }
        break;
    case 'edito':
        switch ($action) {
            case 'read':
                $modele = 'edito.twig';
                $data = [];
                break;
            default:
                // Page vide ou page d'erreur
                $modele = 'base.twig';
                $data = [];
        }
        break;
    case 'accueil':
        switch ($action) {
            case 'read':
                $modele = 'accueil.twig';
                $article = Article::readOne($id);
                $articles = Article::readByTheme($article->id_theme);
                $data = [
                    'article' => $article,
                    'articles' => $articles,
                    'element' => Element::readByArticle($id)
                ];
                break;
            default:
                // Page vide ou page d'erreur
                $modele = 'base.twig';
                $data = [];
        }
        break;
    case 'credit':
        switch ($action) {
            case 'read':
                $modele = 'credit.twig';
                $data = [];
                break;
            default:
                // Page vide ou page d'erreur
                $modele = 'base.twig';
                $data = [];
        }
        break;
    default:
        // La page d'accueil affiche tous les elements
        $modele = 'index.twig';
        $data = [];
}

$data['themes'] = Theme::readAll();

// Le contrôleur charge la vue avec les données
echo $twig->render($modele, $data);
