<?php

function SeConnecter(){
    //connect PDO 
    try {
        $dsn = 'mysql:host=localhost;dbname=store';
        $username = 'root';
        $password = '';
        $options = [
            // précise le type d'erreur que PDO renvera en cas de requête invalide -> ATTR = attribut
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            // définit le mode de récupération des données de la base par défaut. Ici, ce sera rrenvoyé sous forme de tableau associatif (FETCH_ASSOC)
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            // insère une commande MySQL à l'instanciation de l'objet PDO, cela forcera la prise en charge de l'UTF-8 quand on entrera des données en base (INSERT)
            // UTF-8 : Universal Character Set Transformation Format - 8 bits => codage de caractères informatiques
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
        ];
        // fonction connexion()
        $db = new PDO($dsn, $username, $password, $options);       
        } catch(PDOException $e) {
        //quand une erreur est rencontrée, elle est transmise sous forme de message
        echo "Connection failed: ".$e->getMessage();  
    }
    return $db;
}

    
    function findAll($findAll) {
        //lancement de la fonction connection
        $db=SeConnecter();
        // privilégier le prepare() execute()
        $sql=$db->prepare('SELECT * FROM product');
        $sql->execute();
        $findAll = $sql->fetchAll(PDO::FETCH_ASSOC);
        // affichage
        foreach($findAll as $findOne) {
            echo '<h2>'.$findOne['name'].'</h2>';
            echo '<p>'.$findOne['description'].'<br> '.$findOne['price'].' € </p>';
        } die();
    };
    
    function findOneByID($id) {
        $db=SeConnecter();
        $id = 26;
        $sql1 = $db->prepare('SELECT * FROM product WHERE id = :id');
        $sql1->bindParam(":id", $id);
        $sql1->execute();
        $findOneById = $sql1->fetch(PDO::FETCH_ASSOC);
        // affichage
        echo '<h2>'.$findOneById['name'].'</h2>';
        echo '<p>'.$findOneById['description'].' '.$findOneById['price'].' € </p>';
        die();
    };
       
    function insertProduct($insertProduct) {
        $db=SeConnecter();
        $sql2 = 'INSERT INTO product(name, description, price) VALUES (:name, :description, :price)';
        $insertProduct = $db->prepare($sql2);

        $insertProduct->execute([
            'name' => 'XBOX',
            'description' => 'console de salon',
            'price' => '300'
        ]); 
        die();
    }

    
?>
