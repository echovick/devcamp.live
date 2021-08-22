<?php echo get_header();?>
<!-- Banner section start -->
<div class="banner-section bg-main-1 text-center py-5 container-wrapper">
    <div class="w-65 mx-auto">
        <p class="title txt-xlg mb-3">Learning is better with cohorts</p>
        <p class="text txt-lg mb-5">Devcamp.live is a new platform for cohort-based courses. We partner with the world’s best instructors to offer live, online, community-driven courses to transform your career.</p>
        <hr>
        <div class="row mb-4 mx-auto">
            <div class="col-md-6">
                <img src="<?php echo get_theme_file_uri('assets/imgs/about-banner.jpg')?>" alt="" class="w-100">
            </div>
            <div class="col-md-6">
                <p class="title text-left">Live Interactive Classes</p>
                <p class="text txt-md text-left">With the rapid advancement of e-learning, we've decided to take learning to a new level by taking classes online where students ineract actively with instructors and also have access to a community of other developers</p>
            </div>
        </div>
        <hr>
        <div class="row mb-5 mx-auto">
            <div class="col-md-6">
                <p class="title text-left">Opportunity For Instructors</p>
                <p class="text txt-md text-left">Devcamp is not only beneficial to aspiring developers, but also to instructors and those who have knowledge on programming who are also willing to share their knowledge to others. join devcamp as an intructor and contribute to our mission of tutoring students in a unique way</p>
            </div>
            <div class="col-md-6">
                <img src="<?php echo get_theme_file_uri('assets/imgs/about-banner.jpg')?>" alt="" class="w-100">
            </div>
        </div>
        <hr>
        <p class="text txt-md my-4">Join our email list to be the first to learn about new offerings.</p>
        <form action="#" method="POST" class="mx-auto">
            <input type="text" name="email" placeholder="Enter Email Address" class="txt-md text mr-2 mb-3">
            <button type="submit" name="subscribe_newsletter" class="bg-main txt-white txt-md txt-bold text">Subscribe</button>
        </form>
    </div>
</div>
<!-- Banner section end -->
<?php echo get_footer();?>