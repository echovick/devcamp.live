<?php echo get_header();?>
<!-- Courses section start -->
<div class="courses-section add-border-bottom container-wrapper bg-white text-center py-5">
    <div class="w-70 mx-auto py-4">
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
                                <span class="text txt-sm txt-bold"><?php if($enrollments->post_count < 15){ echo rand(15,20);} else { echo $enrollments->post_count;}?> of 200 Enrollments</span> <?php ?>
                            </p>
                            <?php
                                    }else{
                                ?>
                            <p class="title txt-md"><a href="#" type="button" data-toggle="modal" data-target="#comingSoon<?php echo $id;?>"><?php echo rwmb_meta('course_name')?></a> <br>
                                <span class="text txt-sm txt-bold"><?php if($enrollments->post_count < 15){ echo rand(15,20);} else { echo $enrollments->post_count;}?> of 200 Enrollments</span>
                            </p>
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
</div>
<!-- Courses Section End -->
<?php echo get_footer();?>