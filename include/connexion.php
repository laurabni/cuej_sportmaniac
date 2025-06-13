<?php
include('config.php');

function connexion()
{
  global $config;

  $pdo = new PDO(
    $config['driver'] . ':host=' . $config['serveur'] . ';dbname=' . $config['base'] . ';charset=utf8',
    $config['utilisateur'],
    $config['mdp'],
    array(
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
    )
  );
  // $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
  if ($pdo) {
    return $pdo;
  } else {
    echo '<p>Connexion impossible !</p>';
    exit;
  }
}
