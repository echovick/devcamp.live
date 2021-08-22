<?php echo get_header();?>
<!-- Banner section start -->
<div class="banner-section bg-main-1 text-center py-5 container-wrapper">
    <div class="w-65 mx-auto">
        <?php
            if(isset($_SESSION['msg'])){
                echo '
                <div class="alert alert-info">
                    '.$_SESSION['msg'].'
                </div>
                ';
                unset($_SESSION['msg']);
            }
        ?>
        <p class="title txt-xlg mb-3">Take interactive Live classes on coding</p>
        <p class="text txt-lg mb-5">Devcamp is a new platform that takes tutoring to another level. We partner with the world’s best instructors to offer live, online, community-driven courses to transform your career.</p>
        <p class="text txt-md mb-4">Join our email list to be the first to learn about new offerings.</p>
        <form action="#" method="POST" class="mx-auto">
            <input type="text" name="email" placeholder="Enter Email Address" class="txt-md text mr-2 mb-3">
            <button type="submit" name="subscribe_newsletter" class="bg-main txt-white txt-md txt-bold text">Subscribe</button>
        </form>
    </div>
</div>
<!-- Banner section end -->

<!-- Courses section start -->
<div class="courses-section container-wrapper bg-white text-center py-5">
    <div class="mx-auto py-4">
        <p class="title txt-xlg mb-3">Engaging courses from world class instructors</p>
        <p class="text txt-lg mb-5">Our first cohorts sold out within a few hours. Apply Now to join the waitlist and secure your spot in the next cohort.</p>
    </div>
    <div class="row">
        <?php
            $courses = new WP_Query(array(
                'post_type' => 'course',
                'posts_per_page' => -1,
                'status' => 'published',
            ));
            while($courses->have_posts()):$courses->the_post();
                $id = get_the_id();
                $enrollments = new WP_Query(array(
                    'post_type' => 'enrollment',
                    'posts_per_page' => -1,
                    'meta_query' => array(
                        'relation' => 'AND',
                        array(
                            'key' => 'course_id',
                            'value' => get_the_id(),
                            'compare' => '=',
                        ),
                        array(
                            'key' => 'transaction_id',
                            'value' => 0,
                            'compare' => '>',
                        ),
                    ),
                ));
        ?>
            <div class="col-md-6 mb-4">
                <div class="course-box shadow" style="max-height:230px !mportant;">
                    <div class="row">
                        <div class="col-md-4 col-12 mb-3">
                            <div class="course-img">
                                <img src="<?php echo get_metabox_image_url('course_image')?>" alt="" class="w-100" style="max-height:120px !important; object-fit:cover;">
                            </div>
                        </div>
                        <div class="col-md-8 col-12">
                            <div class="text-left">
                                <?php
                                    if(rwmb_meta('course_status') == "Live"){
                                ?>
                                    <p class="title txt-md"><a href="<?php echo get_permalink();?>"><?php echo rwmb_meta('course_name')?></a> <br>
                                    <span class="text txt-sm txt-bold"><?php if($enrollments->post_count < 15){ echo rand(15,20);} else { echo $enrollments->post_count;}?> of 200 Enrollments</span> <?php ?></p>
                                <?php
                                    }else{
                                ?>
                                    <p class="title txt-md"><a href="#" type="button" data-toggle="modal" data-target="#comingSoon<?php echo $id;?>"><?php echo rwmb_meta('course_name')?></a> <br>
                                    <span class="text txt-sm txt-bold"><?php if($enrollments->post_count < 15){ echo rand(15,20);} else { echo $enrollments->post_count;}?> of 200 Enrollments</span></p>
                                <?php
                                    }
                                ?>
                                <p class="text txt-sm"><?php echo substr(rwmb_meta('course_description'), 0, 100).'...'?></p>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <?php
                            if(rwmb_meta('course_status') == "Live"){
                                echo '<p class="text txt-sm txt-bold"><a href="'.get_permalink().'">Apply Now</a></p>';
                            }else{
                                echo '<p class="badge badge-secondary p-2 text txt-sm txt-bold">Coming Soon</p>';
                            }
                        ?>
                    </div>
                </div>
            </div>
        <?php
            endwhile;
        ?>
    </div>
    <!-- <form action="" class="mx-auto text-center mt-5 mb-2">
        <a href="<?php echo site_url('all-courses');?>" class="bg-main button txt-white txt-sm txt-bold text py-3 px-5">View All Courses</a>
    </form> -->
</div>
<!-- Courses Section End -->

<!-- About Us -->
<div class="become-an-instructor container-wrapper text-center bg-main-1 add-border-bottom">
    <div class="w-70 mx-auto py-4 text-justify">
        <p class="title txt-xlg mb-3 mx-auto text-center">About Us</p>
        <p class="text txt-lg mb-4 text-center">Our mission is to democratize CBCs. Inspired by the simplicity and power of platform like maven and teachfloor, we are building a platform that enables the best students, or aspiring developers around the world to enroll and participate in engaging, interactive online courses.</p>
    </div>
</div>
<!-- About us end -->

<!-- Testimonials section start -->
<div class="courses-section container-wrapper bg-white text-center py-5 mb-5">
    <div class="w-70 mx-auto py-4">
        <p class="title txt-xlg mb-3">Devcamp.live Upcoming Events</p>
        <p class="text txt-lg mb-3">Stay up to date with our events and free webinars</p>
    </div>

    <?php
        $course = new WP_Query(array('post_type' => 'event', 'posts_per_page' => -1, 'status' => 'published'));
        while($course->have_posts()):$course->the_post();
            $id = get_the_id();
            $event_date = date_create(rwmb_meta('event_date'));
    ?>
    <div class="carousel" data-flickity='{"autoPlay" : 2500, "freeScroll" : true, "wrapAround" : true }'>
        <div class="carousel-cell col-md-4 my-2">
            <div class="testimonial-box shadow text-left py-4 px-4">
                <p class="title txt-md"><?php echo rwmb_meta('event_name')?></p>
                <p class="text txt-sm"><?php echo rwmb_meta('event_description')?></p>
                <div class="d-flex justify-content-between">
                    <p class="text txt-sm">Date: <?php echo date_format($event_date, 'M d, Y')?></p>
                    <p class="text txt-sm">Time: <?php echo rwmb_meta('event_time').'PM (GMT)'?></p>
                </div>
                <!-- <div class="row w-100"> -->
                    <a type="button" data-toggle="modal" data-target="#joinEvent<?php echo $id?>" class="bg-main rounded txt-white txt-sm txt-bold text p-2">Join Now</a>
                <!-- </div> -->
            </div>
        </div>
    </div>
    <?php
        endwhile;
    ?>
</div>
<!-- Testimonals section end -->

<!-- Become am instructor section start -->
<div class="become-an-instructor container-wrapper text-center bg-main-1">
    <div class="w-70 mx-auto py-4 text-justify">
        <p class="title txt-xlg mb-3 mx-auto text-center">Become an Instructor</p>
        <p class="text txt-lg mb-4 text-center">Do you have programming knowledge to share with the world but don’t know where to start?</p>
        <p class="text txt-md mb-3">Why don't you join us today on our mission to tutor students from around with using live engaging and interactive courses. We'ld love to  get to know you</p>
        
        <div class="row mx-auto w-100">
            <button type="button" data-toggle="modal" data-target="#instructorApplication" class="bg-main mx-auto txt-white txt-sm txt-bold text">Apply As A Teacher</button>
        </div>
    </div>
</div>
<!-- Become an instructor Section end -->

<?php echo get_footer();?>