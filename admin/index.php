<?php
// Initialise Twig
require_once('../vendor/autoload.php');
include('../include/twig.php');
$twig = init_twig();

// Connexion à la base de données
include('../include/connexion.php');
include('../include/file-upload.php');
include('../include/theme.php');
include('../include/article.php');
include('../include/element.php');

$pdo = connexion();

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
    case 'element':
        switch ($action) {
            case 'read':
                $modele = 'element_admin.twig';
                $data = [
                    'element' => Element::readOne($id),
                ];
                break;
            case 'new_titre':
                $modele = 'form_titre.twig';
                $data = ['id' => $id];
                break;
            case 'new_intertitre':
                $modele = 'form_intertitre.twig';
                $data = ['id' => $id];
                break;
            case 'new_paragraphe':
                $modele = 'form_paragraphe.twig';
                $data = ['id' => $id];
                break;
            case 'new_image':
                $modele = 'form_image.twig';
                $data = ['id' => $id];
                break;
            case 'new_video':
                $modele = 'form_video.twig';
                $data = ['id' => $id];
                break;
            case 'new_audio':
                $modele = 'form_audio.twig';
                $data = ['id' => $id];
                break;
            case 'new_citation':
                $modele = 'form_citation.twig';
                $data = ['id' => $id];
                break;
            case 'new_chapo':
                $modele = 'form_chapo.twig';
                $data = ['id' => $id];
                break;
            case 'create':
                $element = new Element();
                $element->chargePOST();
                $element->create();
                header('Location: index.php?page=article&action=read&id=' . $element->id_article);
                break;
            case 'edit':
                $modele = 'edit_element.twig';
                $data = [
                    'element' => Element::readOne($id),
                ];
                break;
            case 'update':
                $element = new Element();
                $element->chargePOST();
                $element->update();
                header('Location: index.php?page=article&action=read&id=' . $element->id_article);
                break;
            case 'delete':
                $element = Element::readOne($id);
                Element::delete($id);
                header('Location: index.php?page=article&action=read&id=' . $element->id_article);
                break;
            default:
                header('Location: index.php?page=theme');
        }
        break;
    case 'article':
        switch ($action) {
            case 'read':
                $modele = 'element_admin.twig';
                $data = [
                    'article' => Article::readOne($id),
                    'elements' => Element::readByArticle($id)
                ];
                break;
            case 'new':
                $modele = 'form_article.twig';
                $data = [
                    "id" => $id
                ];
                break;
            case 'create':
                $article = new Article();
                $article->chargePOST();
                $article->create();
                header('Location: index.php?page=theme&action=read&id=' . $article->id_theme);
                break;
            case 'edit':
                $modele = 'edit_article.twig';
                $data = [
                    'article' => Article::readOne($id),
                ];
                break;
            case 'update':
                $article = new Article();
                $article->chargePOST();
                $article->update();
                header('Location: index.php?page=theme&action=read&id=' . $article->id_theme);
                break;
            case 'delete':
                $article = Article::readOne($id);
                Article::delete($id);
                header('Location: index.php?page=theme&action=read&id=' . $article->id_theme);
                break;
            default:
                header('Location: index.php?page=theme&action=read&id=' . $article->id_theme);
        }
        break;

    case 'theme':
        switch ($action) {
            case 'read':
                if ($id > 0) {
                    $modele = 'article_admin.twig';
                    $data = [
                        'theme' => Theme::readOne($id),
                        'articles' => Article::readByTheme($id),
                    ];
                } else {
                    $modele = 'theme_admin.twig';
                    $data = [];
                }
                break;
            case 'new':
                $modele = 'form_theme.twig';
                $data = [];
                break;
            case 'create':
                $theme = new Theme();
                $theme->chargePOST();
                $theme->create();
                header('Location: index.php');
                break;
            case 'edit':
                $modele = 'edit_theme.twig';
                $data = [
                    'theme' => Theme::readOne($id),
                ];
                break;
            case 'update':
                $theme = new Theme();
                $theme->chargePOST();
                $theme->update();
                header('Location: index.php');
                break;
            case 'delete':
                $theme = Theme::readOne($id);
                Theme::delete($id);
                header('Location: index.php');
                break;
            default:
                $modele = 'base.twig';
                $data = [];
        }
        break;
    default:
        header('Location: index.php?page=theme');
}

$data['themes'] = Theme::readAll();

echo $twig->render($modele, $data);
