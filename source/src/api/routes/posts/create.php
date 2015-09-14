<?php

    $app->get('/create',function() use ($app) { 

        $app->render('posts/create.php');

    })->name('create');



    $app->post('create',function() use ($app) { 

       # Store the post in the database

    });


?>