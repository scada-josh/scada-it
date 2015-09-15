<?php

    $app->get('/view/:id',function($id) use ($app) { 

        //$app->render('posts/view.php');
        echo $id;

    })->name('name');



?>