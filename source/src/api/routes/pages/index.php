<?php

    $app->get('/',function() use ($app) { 
        $app->render('pages/index.php');
    })->name('home ');


?>