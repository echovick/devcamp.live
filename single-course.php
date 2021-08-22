<?php echo get_header();?>
<?php
    while(have_posts()):the_post();
        $information_section = rwmb_meta('information_section');
        $topics_covered = rwmb_meta('topics_covered');
        $slashed_price = rwmb_meta('slashed_price');
        $original_price = rwmb_meta('original_price');
        $discount_percentage = rwmb_meta('discount_percentage');
        $private_tutor_cost = rwmb_meta('private_tutor_cost');
        $course_audience = rwmb_meta('course_audience');
        $testimonials_group = rwmb_meta('testimonials_group');
        $instructors = rwmb_meta('course_instructors');
        $course_features_group = rwmb_meta('course_features_group');
        $course_curruculum_group = rwmb_meta('course_curruculum_group');
        $faqs_group = rwmb_meta('faqs_group');
        $instructors_section_group = rwmb_meta('instructors_section_group');
        $cours_id = get_the_id();
        $course_access = rwmb_meta('course_access');
?>
<!-- Banner section start -->
<div class="banner-section bg-main-1 text-center py-5 container-wrapper">
    <div class="w-65 mx-auto">
        <p class="title txt-xlg mb-3"><?php echo rwmb_meta('course_name')?></p>
        <p class="text txt-lg mb-5"><?php echo rwmb_meta('page_description')?></p>
        <div class="d-flex instructor-img mx-auto text-center justify-content-center">
            <img src="<?php echo get_theme_file_uri('assets/imgs/avatar.png')?>" alt="" class="mr-2">
            <p class="text txt-md mb-4 pt-3">by <b>
                    <?php
                    $count = count($instructors);
                    foreach($instructors as $key => $course_instructors){
                        $the_person = get_post($course_instructors);       
                        if($key > 0 && $key < $count - 1){
                            echo ', ';
                        }else if($key == $count - 1){
                            echo ' & ';
                        }
                        echo $the_person->middle_name.' '.$the_person->last_name;
                    }
                ?></b>
                <!-- Uchechukwu Eze & Gabriel Ibenye</b> -->
            </p>
        </div>
    </div>
</div>
<!-- Banner section end -->

<!-- Course Badges -->
<div class="courses-section container-wrapper bg-white text-center py-5" id="courseBadges">
    <div class="w-70 mx-auto py-2">
        <p class="title txt-xlg mb-3">View Course Batches</p>
        <p class="text txt-lg mb-2">Apply For the next Batch of training for this course</p>
        <?php
            if(isset($discount_percentage)){
                echo '<p class="text txt-md txt-normal mb-5"><b class="font-weight-bold">'. $discount_percentage.'</b> Discount on this course for the first cohort, hurry now and apply</p>';
            }
        ?>
    </div>
    <?php
        $cohorts = new WP_Query(array(
            'post_type' => 'cohort',
            'posts_per_page' => -1,
            'meta_query' => array(
                array(
                    'key' => 'course_id',
                    'value' => get_the_id(),
                    'compare' => '=',
                ),
            ),
        ));
        if($cohorts->have_posts()){
            while($cohorts->have_posts()):$cohorts->the_post();
    ?>
    <div class="badge-box mb-3">
        <div class="row text-left justify-content-center mb-3 mt-2">
            <div class="col-md-3 col-12 mx-auto text-center mb-3">
                <p class="title txt-sm text-primary mb-1">UPCOMING</p>
                <p class="text txt-md txt-bold"><?php echo rwmb_meta('cohort_name')?></p>
            </div>
            <div class="col-md-3 col-12 mx-auto text-center mb-3">
                <p class="title txt-sm text-primary mb-1">CLASS PERIOD</p>
                <?php
                        $start_date = date_create(rwmb_meta('start_date'));
                        $start_date = date_format($start_date, 'M d');
                        $end_date = date_create(rwmb_meta('end_date'));
                        $year = date_format($end_date, 'Y');
                        $end_date = date_format($end_date, 'M d');
                        $registration_deadline = rwmb_meta('registration_deadline');
                        $today = date('Y-m-d');
                    ?>
                <p class="text txt-md txt-bold"><?php echo $start_date.' - '.$end_date.', '.$year?></p>
            </div>
            <div class="col-md-3 col-12 mx-auto text-center mb-3">
                <p class="title txt-sm text-primary mb-1">REGISTRATION DEADLINE</p>
                <?php
                    $registration_deadline = date_create(rwmb_meta('registration_deadline'));
                    $registration_deadline = date_format($registration_deadline, 'M d, Y');
                ?>
                <p class="text txt-md txt-bold"><?php echo $registration_deadline?></p>
            </div>
            <?php
                $enrollments = new WP_Query(array(
                    'post_type' => 'enrollment',
                    'posts_per_page' => -1,
                    'meta_query' => array(
                        'relation' => 'AND',
                        array(
                            'key' => 'course_id',
                            'value' => $cours_id,
                            'compare' => '='
                        ),
                        array(
                            'key' => 'transaction_id',
                            'value' => 0,
                            'compare' => '>'
                        ),
                        array(
                            'key' => 'cohort_id',
                            'value' => get_the_id(),
                            'compare' => '=',
                        ),
                    ),
                ));
                if($today >= $registration_deadline || $enrollments->have_posts()){
            ?>
                <div class="col-md-3 col-12 mx-auto text-center mb-3">
                    <p class="title txt-lg text-primary mb-1"><del class="txt-md mr-1">&#8358;<?php echo number_format($slashed_price)?></del> &#8358;<?php echo number_format($original_price)?></p>
                    <a href="#" type="button" data-toggle="modal" data-target="#registrationClosed" class="button px-4 bg-main txt-white txt-sm txt-bold text py-2">Registration Closed</a>
                </div>
            <?php        
                }else{
                    if($course_access == 'Free'){
            ?>
                        <div class="col-md-3 col-12 mx-auto text-center mb-3">
                            <p class="title txt-lg text-primary mb-1">FREE</p>
                            <a href="<?php echo site_url('/enroll/?courseid=').$cours_id.'&cohortid='.get_the_id().'&access=free';?>" class="button px-4 bg-main txt-white txt-sm txt-bold text py-2">Apply Now</a>
                        </div>
            <?php
                    }else{
            ?>
                        <div class="col-md-3 col-12 mx-auto text-center mb-3">
                            <p class="title txt-lg text-primary mb-1"><del class="txt-md mr-1">&#8358;<?php echo number_format($slashed_price)?></del> &#8358;<?php echo number_format($original_price)?></p>
                            <a href="<?php echo site_url('/enroll/?courseid=').$cours_id.'&cohortid='.get_the_id();?>" class="button px-4 bg-main txt-white txt-sm txt-bold text py-2">Apply Now</a>
                        </div>
            <?php
                    }
                }
            ?>
        </div>
    </div>
    <?php
            endwhile;
        }
    ?>
    <div class="badge-box w-50 mx-auto mb-3">
        <div class="justify-content-center mb-3 mt-2">
            <p class="title txt-md text-primary mb-1">Apply For Private tutoring</p>
            <p class="text txt-sm txt-bold">Fix Classes and schedules on your own time and your convinence, just for an extra fee!!!</p>
        </div>
        <div class="justify-content-center mb-3 mt-2">
            <p class="title txt-lg text-primary mb-1">&#8358;<?php echo number_format($private_tutor_cost);?></p>
            <a href="<?php echo site_url('/enroll/?courseid=').$cours_id.'&cohortid=private';?>" class="button px-4 bg-main txt-white txt-sm txt-bold text py-2">Apply Now</a>
        </div>
    </div>
</div>
<!-- Course Badges -->

<!-- Course information Section -->
<?php
    if(isset($information_section['show_hide_section']) && $information_section['show_hide_section'] == "Show"){
?>
<div class="become-an-instructor container-wrapper text-center bg-main-1 py-5">
    <div class="w-70 mx-auto py-2">
        <p class="title txt-xlg mb-3"><?php echo $information_section['section_header'] ?? ''?></p>
        <p class="text txt-lg mb-5"><?php echo $information_section['section_snippet'] ?? ''?></p>
    </div>
    <div class="row mx-auto">
        <div class="col-md-6">
            <img src="<?php echo get_metabox_group_image_url($information_section,'section_image')?>" alt="" class="w-100" style="max-height:315px !important; object-fit:cover;">
        </div>
        <div class="col-md-6 text-left">
            <p class="title mt-3"><?php echo $information_section['section_content_title'] ?? ''?></p>
            <p class="text-left"><?php echo $information_section['section_summary_content'] ?? ''?></p>
        </div>
    </div>
    <div class="mx-auto mt-4">
        <a href="#courseBadges" class="bg-main button txt-white txt-md txt-bold text py-3 px-4">Enroll Now</a>
    </div>
</div>
<?php
    }
?>
<!-- Course information section end -->

<!-- Topics Covered -->
<?php
    if(isset($topics_covered['topics_show_hide']) && $topics_covered['topics_show_hide'] == "Show"){
?>
<div class="become-an-instructor container-wrapper text-center bg-white">
    <div class="w-70 mx-auto py-2">
        <p class="title txt-xlg mb-3"><?php echo $topics_covered['topics_section_header'] ?? ''?></p>
        <p class="text txt-lg mb-5"><?php echo $topics_covered['topics_section_snippet'] ?? ''?></p>
    </div>
    <div class="row justify-content-center mx-auto">
        <?php
            $add_topic_group = $topics_covered['add_topic_group'] ?? '';
            if(is_array($add_topic_group)){
                foreach($add_topic_group as $add_topic){
        ?>
        <div class="col-md-4 text-left mb-3">
            <p class="title"><?php echo $add_topic['topic_subject'] ?? ''?></p>
            <p class="text-left"><?php echo $add_topic['topic_content'] ?? ''?></p>
        </div>
        <?php
                }
            }
        ?>
    </div>
</div>
<?php
    }
?>
<!-- Topics covered end -->

<!-- who is this course for -->
<?php
    if(isset($course_audience['audience_show_hide']) && $course_audience['audience_show_hide'] == "Show"){
?>
<div class="become-an-instructor container-wrapper text-center bg-main-1 py-5">
    <div class="py-4 px-5">
        <div class="w-70 mx-auto inner">
            <p class="title txt-xlg mb-3"><?php echo $course_audience['audience_section_header'] ?? ''?></p>
            <p class="text txt-lg mb-5"><?php echo $course_audience['audience_section_description'] ?? ''?></p>
        </div>
        <div class="row px-5 pb-5 mx-auto">
            <?php
                $add_audience_box_group = $course_audience['add_audience_box_group'] ?? '';
                if(is_array($add_audience_box_group)){
                    foreach($add_audience_box_group as $key => $audience_box){
            ?>
                <div class="col-md-4 col-12 mb-3">
                    <div class="info-box shadow add-border p-4 text-left">
                        <p class="text-primary title"><?php echo $audience_box['audience_subject'] ?? ''?></p>
                        <p class="text txt-md"><?php echo $audience_box['audience_description'] ?? ''?></p>
                    </div>
                </div>
            <?php
                    }
                }
            ?>
        </div>
    </div>
</div>
<?php
    }
?>
<!-- Who is this course for end -->

<!-- Meet your instructor start -->
<?php
    if(isset($instructors_section_group['instructors_show_hide']) && $instructors_section_group['instructors_show_hide'] == "Show"){
        if(is_array($instructors)){
?>
<div class="become-an-instructor container-wrapper text-center bg-white">
    <div class="w-70 mx-auto py-2">
        <p class="title txt-xlg mb-3">Meet Your Instructor(s)</p>
    </div>
    <?php
        foreach($instructors as $key => $course_instructors){
            $the_person = get_post($course_instructors); 
    ?>
    <div class="row w-50 mx-auto py-3">
        <div class="col-md-4">
            <img src="<?php echo get_theme_file_uri('/assets/imgs/avatar.png')?>" alt="" class="w-40">
        </div>
        <div class="col-md-8 text-left">
            <p class="title txt-lg"><?php echo $the_person->middle_name.' '.$the_person->last_name?></p>
            <p class="txt-md"><?php echo $the_person->user_description?></p>
        </div>
    </div>
    <?php
        }
    ?>
</div>
<?php
        }
    }   
?>
<!-- Meet your instructor end -->

<!-- Course Testimonial -->
<?php
    if(isset($testimonials_group['testimonial_show_hide']) && $testimonials_group['testimonial_show_hide'] == "Show"){
?>
<div class="container-wrapper course-testimonial text-center bg-main-1 py-5">
    <div class="w-70 mx-auto py-2">
        <p class="title txt-xlg mb-3"><?php echo $testimonials_group['testimonial_section_header'] ?? ''?></p>
        <p class="text txt-lg mb-5"><?php echo $testimonials_group['testimonial_section_description'] ?? ''?></p>
    </div>
    <div class="row">
        <?php
            $add_testimonial_group = $testimonials_group['add_testimonial_group'] ?? '';
            if(is_array($add_testimonial_group)){
                foreach($add_testimonial_group as $testimonial){
        ?>
            <div class="col-md-4 my-2">
                <div class="testimonial-box shadow text-left py-4 px-4">
                    <div class="row instructor-img mb-3">
                        <img src="<?php echo get_theme_file_uri('/assets/imgs/avatar.png')?>" alt="">
                        <p class="title txt-md pt-1 ml-2"><?php echo $testimonial['user_name'] ?? ''?> <br><span class="text txt-sm"><?php echo $testimonial['user_role'] ?? ''?></span></p>
                    </div>
                    <p class="text txt-sm"><?php echo $testimonial['testimonial_content'] ?? ''?></p>
                    <?php
                        $testimonial_date = $testimonial['testimonial_date'] ?? '';
                        $testimonial_date = date_create($testimonial_date);
                    ?>
                    <p class="text txt-sm"><?php echo date_format($testimonial_date, 'M d, Y')?></p>
                </div>
            </div>
        <?php
                }
            }
        ?>
    </div>
</div>
<?php
    }
?>
<!-- Course Testimonial -->

<!-- Course features and curriculum -->
<div class="container-wrapper text-center bg-white">
    <?php
        if(isset($course_features_group['course_features_show_hide']) && $course_features_group['course_features_show_hide'] == "Show"){
    ?>
    <div class="w-100 mx-auto">
        <p class="title txt-xlg mb-3"><?php echo $course_features_group['course_features_header'] ?? ''?></p>
        <p class="text txt-lg mb-5"><?php echo $course_features_group['course_featuress_description'] ?? ''?></p>
    </div>
    <div class="row">
        <div class="col-md-6">
            <img src="<?php echo get_metabox_group_image_url($course_features_group,'featured_image')?>" alt="" class="w-100">
        </div>
        <div class="col-md-6 text-left">
            <?php
                if(is_array($course_features_group['add_features_group'])){
                    foreach($course_features_group['add_features_group'] as $features){
            ?>
            <div>
                <p class="title text-primary mt-3"><i class="fa fa-dot-circle mr-2"></i><?php echo $features['feature_subject']?></p>
                <p class="text txt-md pl-4"><?php echo $features['feature_content']?></p>
            </div>
            <?php
                    }
                }
            ?>
        </div>
    </div>
    <?php
        }
    ?>

    <!-- Course curriculum -->
    <?php
        if(isset($course_curruculum_group['curriculum_show_hide']) && $course_curruculum_group['curriculum_show_hide'] == "Show"){
    ?>
    <div class="w-100 mx-auto pt-5 pb-2">
        <p class="title txt-xlg mb-3"><?php echo $course_curruculum_group['curriculum_section_header'] ?? ''?></p>
        <p class="text txt-lg mb-5"><?php echo $course_curruculum_group['curriculum_section_description'] ?? ''?></p>
    </div>
    <div id="accordion">
        <?php
            $add_modules_group = $course_curruculum_group['add_modules_group'] ?? '';
            if(is_array($add_modules_group)){
                foreach($add_modules_group as $keys => $modules){
        ?>
            <div class="card w-60 mx-auto mb-2">
                <div class="card-header text-left">
                    <a class="card-link title" data-toggle="collapse" href="#collapse<?php echo $keys?>">
                        <?php echo $modules['content_label'] ?? ''?>: <?php echo $modules['module_header'] ?? ''?>
                    </a>
                </div>
                <div id="collapse<?php echo $keys?>" class="collapse <?php if($keys == 0){ echo 'show';}?>" data-parent="#accordion">
                    <div class="card-body text-left">
                        <p class="text txt-md text-left"><?php echo $modules['module_content'] ?? ''?></p>
                    </div>
                </div>
            </div>
        <?php
                }
            }
        ?>
    </div>
    <?php
        }
    ?>
</div>
<!-- Course features end -->

<!-- Enrol Section -->
<div class="container-wrapper text-center bg-main-1 py-5">
    <div class="w-70 mx-auto">
        <p class="title txt-xlg mb-3">Join today</p>
    </div>
    <?php
        if($cohorts->have_posts()){
            while($cohorts->have_posts()):$cohorts->the_post();
    ?>
    <div class="badge-box mb-3 w-65 mx-auto">
        <div class="row text-left">
            <div class="col-md-3 col-4 mx-auto text-center">
                <p class="title txt-sm text-primary mb-1">UPCOMING</p>
                <p class="text txt-md txt-bold"><?php echo rwmb_meta('cohort_name')?></p>
            </div>
            <div class="col-md-3 col-4 mx-auto text-center">
                <p class="title txt-sm text-primary mb-1">CLASS PERIOD</p>
                <?php
                    $start_date = date_create(rwmb_meta('start_date'));
                    $start_date = date_format($start_date, 'M d');
                    $end_date = date_create(rwmb_meta('end_date'));
                    $year = date_format($end_date, 'Y');
                    $end_date = date_format($end_date, 'M d');
                ?>
                <p class="text txt-md txt-bold"><?php echo $start_date.' - '.$end_date.', '.$year?></p>
            </div>
            <div class="col-md-3 col-4 mx-auto text-center">
                <p class="title txt-sm text-primary mb-1">REGISTRATION DEADLINE</p>
                <?php
                    $registration_deadline = date_create(rwmb_meta('registration_deadline'));
                    $registration_deadline = date_format($registration_deadline, 'M d, Y');
                ?>
                <p class="text txt-md txt-bold"><?php echo $registration_deadline?></p>
            </div>
        </div>
    </div>
    <?php
        endwhile;
    }
    ?>
    <?php
        $course_access = rwmb_meta('course_access');
        if($course_access == 'Free'){
    ?>
    <div class="mx-auto">
        <p class="title txt-lg text-primary"><del class="txt-md">&#8358;<?php echo number_format($slashed_price)?></del> &#8358;<?php echo number_format($original_price)?></p>
        <a href="#courseBadges" class="bg-main button txt-white txt-sm txt-bold text py-3 px-5">Apply Now</a>
    </div>
    <?php
        }else{
    ?>
    <div class="mx-auto">
        <p class="title txt-lg text-primary"><del class="txt-md">&#8358;<?php echo number_format($slashed_price)?></del> &#8358;<?php echo number_format($original_price)?></p>
        <a href="#courseBadges" class="bg-main button txt-white txt-sm txt-bold text py-3 px-5">Apply Now</a>
    </div>
    <?php
        }
    ?>
</div>
<!-- Enroll section end -->

<!-- FAQ Section -->
<?php
    if(isset($faqs_group['faq_section_show']) && $faqs_group['faq_section_show'] == "Show"){
?>
<div class="container-wrapper faq text-center bg-white">
    <div class="w-100 mx-auto">
        <p class="title txt-xlg mb-3"><?php echo $faqs_group['faq_section_header'] ?? ''?></p>
        <p class="text txt-lg mb-5"><?php echo $faqs_group['faq_section_snippet'] ?? ''?></p>
    </div>
    <?php
        $add_faqs_group = $faqs_group['add_faqs_group'] ?? '';
        if(is_array($add_faqs_group)){
            foreach($add_faqs_group as $faqs){
    ?>
    <div class="text-left w-70 mx-auto mb-3">
        <p class="title txt-md"><?php echo $faqs['faq_question'] ?? ''?></p>
        <p class="text txt-md">
            <?php echo $faqs['faq_answer'] ?? ''?>
        </p>
    </div>
    <?php
            }
        }
    ?>
</div>
<?php
    }
?>
<!-- FAQ Section  -->
<hr>
<?php
    endwhile;   
?>
<?php echo get_footer();?>