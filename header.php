<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>DevCamp - Enroll and start learning to Code with our engaging live classes</title>
        <meta name="description" content="Devcamp is an tutoring platform that allow students to learn to code by participating in live classes with world class instructors and experts"/>
        <link rel="shortcut icon" href="<?php echo get_theme_file_uri('assets/imgs/letter-d.png')?>" type="image/x-icon">
        <?php wp_head();?>
    </head>

    <body>
        <nav class="bg-main-1 container-wrapper desktop">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <a href="<?php echo site_url();?>"><img src="<?php echo get_theme_file_uri('assets/imgs/devcamp-logo.png')?>" alt="" class="w-100"></a>
                </div>
                <div class="d-flex">
                    <a href="<?php echo site_url();?>" class="text txt-normal mr-4 txt-bold txt-dark pt-2">Home</a>
                    <a href="<?php echo site_url('about')?>" class="text txt-normal mr-4 txt-bold txt-dark pt-2">About</a>
                    <a href="<?php echo site_url('all-courses')?>" class="text txt-normal mr-4 txt-bold txt-dark pt-2">Courses</a>
                    <button type="button" data-toggle="modal" data-target="#instructorApplication" class="bg-main txt-white txt-sm txt-bold mr-4 text">Apply As A Teacher</button>
                </div>
            </div>
        </nav>

        <nav class="navbar navbar-expand-md bg-main-1 navbar-dark mobile px-4">
            <a class="navbar-brand" href="<?php echo site_url();?>">
                <img src="<?php echo get_theme_file_uri('assets/imgs/devcamp-logo.png')?>" alt="" class="w-100">
            </a>
            <button class="navbar-toggler float-right w-30 my-2 mr-0 pr-0" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <i class="fa fa-bars txt-primary txt-xlg mr-0 pr-0 float-right"></i>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav txt-primary mt-3 w-100">
                    <li class="nav-item mb-3">
                        <a href="<?php echo site_url();?>" class="text txt-md mr-4 txt-bold txt-primary pt-2">Home</a>
                    </li>
                    <li class="nav-item mb-3">
                        <a href="<?php echo site_url('about')?>" class="text txt-md mr-4 txt-bold txt-primary pt-2">About</a>
                    </li>
                    <li class="nav-item mb-3">
                        <a href="<?php echo site_url('all-courses')?>" class="text txt-md mr-4 txt-bold txt-primary pt-2">Courses</a>
                    </li>
                    <li class="nav-item mb-3">
                        <button type="button" data-toggle="modal" data-target="#instructorApplication" class="bg-main py-2 txt-white txt-sm txt-bold mr-4 text">Apply As A Teacher</button>
                    </li>
                </ul>
            </div>
        </nav>