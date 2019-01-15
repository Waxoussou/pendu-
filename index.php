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
        color: green;
        margin: auto 15px; 
        font-size: 1.3em;  
        font-weight: bold;
    /* text-transform: uppercase;*/
    }
    
    .currentWord{
        letter-spacing: 2em; 
        font-size: 2.5em;
        margin-left: 50px; 
    } 

    .winGame{
        color: #81DAF5;
        width: 300px; 
        height: 45px; 
        text-align: center; 
        margin: 150px 40% auto 35%;  
    }

    </style>
</head>
<body>

    <?php
    function chooseLetter ($letter){
        for ($i = 0; $i < strlen($_SESSION['secret_word']); $i++) {
            if ($_SESSION['secret_word'][$i] == $letter) {
                $_SESSION['current_word'][$i] = $letter;
            }
        }
    }
    ?>

    <?php
        //est ce que l'utilisateur a choisi une lettre ?
        if (isset($_GET['letter']) && strlen($_GET['letter']) == 1 && strpos($alphabet, $_GET['letter']) !==false) {
         //   echo "<br/>".$_GET['letter'];
            chooseLetter($_GET['letter']);
        }
    ?>


    <div class="party">
        <form method="post" action="index.php">
            <input type="hidden" name="partie" value="new">
            <input class= "newGame" type="submit" value="Nouvelle partie">
        </form>
        <div class="secretWord">
            <?php
                function init() {
                    global $alphabet;
                    session_unset(); // je libère toutes les variables des parties précédentes
                    $_SESSION['secret_word'] = "pendu";
                    $_SESSION['current_word'] = "";

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
        //quand faut'il créer une nouvelle partie ? 
        if (isset($_POST['partie']) && $_POST['partie'] == 'new') {
            init();
        } 
        //Affichage du mot + alphabet
        for ($i = 0; $i < strlen($alphabet); $i++) {
            echo " <a href='index.php?letter=$alphabet[$i]'>$alphabet[$i]</a> ";
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

        

</body>
</html>