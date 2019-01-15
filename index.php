<?php 
session_start();
$alphabet = "abcdefghijklmnopqrstuvwxyz"
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>

    .newGame{
        color: #fff;
        background-color: #81DAF5;
        border: none;
        border-radius: 3px;
        height: 50px; 
        width: 200px; 
        text-transform: uppercase; 
        font-weight: bold; 
        margin: 25px 50px; 
    }

   .party{
       display: flex;
       margin-bottom: 50px; 
       flex-direction: column; 
   }

    .alphabet a{
        color: #3399ff;
        margin: auto 25px; 
        font-size: 1.3em;  
        font-weight: bold;
        border-radius: 3px; 
        text-decoration: none;
    /* text-transform: uppercase;*/
    }

    
    
    .currentWord{
        letter-spacing: 2em; 
        font-size: 2.5em;
        margin-left: 50px; 
    } 

    .winGame, .looseGame{
        width: 300px; 
        height: 45px; 
        text-align: center; 
        margin: 150px 40% auto 35%;  
    }

    .winGame{
        color: #81DAF5;
    }

    .looseGame{
        color: red;
    }

    </style>
</head>
<body>

    <?php
    function chooseLetter ($letter){
        
        $found = false; //variable pour compter lettre erronée 
        for ($i = 0; $i < strlen($_SESSION['secret_word']); $i++) {
            if ($_SESSION['secret_word'][$i] == $letter) {
                $_SESSION['current_word'][$i] = $letter;
                $found = true;
            }
        } 
        if (!$found){
            $_SESSION['error'] ++ ;
            }
    }
    ?>

    <?php
        //est ce que l'utilisateur a choisi une lettre ?
        if (isset($_GET['letter']) && strlen($_GET['letter']) == 1 && strpos($alphabet, $_GET['letter']) !==false && $_SESSION['error'] < 10) {
         //   echo "<br/>".$_GET['letter'];
            $_SESSION['count'] ++;
            echo  '<p> counter : '.$_SESSION['count'].'</p>';
            echo '<p> number of mistakes : '.$_SESSION['error'].'</p>';
            chooseLetter($_GET['letter']);
        }
    ?>

    <?php
        //quand faut'il créer une nouvelle partie ? 
        if (isset($_POST['partie']) && $_POST['partie'] == 'new')  {
            init();
        } 
    ?>    

    <div class="party">
        <form method="post" action="index.php">
            <input type="hidden" name="partie" value="new">
            <input class= "newGame" type="submit" value="new Game">
        </form>
        <div class="secretWord">
            <?php
                function init() {
                    global $alphabet;
                    session_unset(); // je libère toutes les variables des parties précédentes
                    $_SESSION['secret_word'] = "pendejo";
                    $_SESSION['current_word'] = "";
                    $_SESSION['count'] = 0; 
                    $_SESSION['error'] = 0;

                    //boucle pour parcourir le mot secret et remplacer chaque lettre par un " _ "
                    for ($i = 0; $i <strlen($_SESSION['secret_word']); $i++) { 
                        $_SESSION['current_word'][$i] = $_SESSION['current_word']."_" ; // ou plus simple :  $_SESSION['current_word'][$i] .= " _ ";
                    }          
                }
        
                // isset($_POST['partie']); // on vérifie que la variable existe 
                // $_POST['partie'] == 'new'; // on vérifie qu'il y a une valeur dedans            
            ?>
            <br>
            <div class="currentWord">
                <?php
                    echo $_SESSION['current_word'].'<br>';        
                ?>
            </div>
        </div>

    </div>

    <div class="alphabet">     
        <?php
            //Affichage du mot + alphabet
            if ($_SESSION['error']<10 && $_SESSION['secret_word'] !== $_SESSION['current_word']){
                for ($i = 0; $i < strlen($alphabet); $i++) {
                    echo " <a href='index.php?letter=$alphabet[$i]'>$alphabet[$i]</a> ";
                }
            }
        ?>
    </div>
    
    <div class="winGame">
        <?php
            if ($_SESSION['secret_word'] == $_SESSION['current_word']) {
                echo ' <h1> You WIN !</h1> ';
            }
        ?>
    </div>        
    <div class="looseGame">
        <?php
            if ($_SESSION['error']>9) {
                echo '<h1> You lost ! </h1><br><p>you can try again</p>';
            }
        ?>
    </div>
</body>
</html>