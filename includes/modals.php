<!-- Modals section -->
<div class="modal fade" id="instructorApplication">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="p-4 add-border-bottom">
                <p class="title text-center mx-auto">Apply To Teach On Devcamp.live</p>
                <!-- <p class="text txt-sm text-center mx-auto">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Suscipit quas dolorem dolores sint. Iusto voluptatum error eum quas ex necessitatibus nesciunt, officia obcaecati aperiam enim quibusdam repudiandae perferendis, quidem qui.</p> -->
            </div>
            <form action="#" method="POST" class="px-3 was-validated">
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="form-group">
                        <label class="text txt-sm txt-bold" for="name">Full Name:</label>
                        <input type="text" name="instructor_name" class="form-control" placeholder="Enter Full Name" id="name" required>
                    </div>
                    <div class="form-group">
                        <label class="text txt-sm txt-bold" for="email">Email address:</label>
                        <input type="email" name="instructor_email" class="form-control" placeholder="Enter email" id="email" required>
                    </div>
                    <div class="form-group">
                        <label class="text txt-sm txt-bold" for="phone">Phone Number:</label>
                        <input type="text" name="instructor_phone" class="form-control" placeholder="Enter Phone Number" id="phone" required>
                    </div>
                    <div class="form-group">
                        <label class="text txt-sm txt-bold" for="description">What Will You Be Teaching:</label>
                        <textarea class="form-control" name="course_description" rows="5" placeholder="Tell us a little about what you will be teaching on devcamp.live" id="description" required></textarea>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" name="submit_instructor_application" class="bg-main text-center mx-auto txt-white txt-md txt-bold text py-2">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- login modal -->
<div class="modal fade" id="login">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="p-4 add-border-bottom">
                <p class="title text-center mx-auto">Login To Devcamp</p>
                <p class="text txt-sm text-center mx-auto">Please enter your details to login to your account</p>
            </div>
            <form action="" class="px-3 was-validated">
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="form-group">
                        <label class="text txt-sm txt-bold" for="email">Email address:</label>
                        <input type="email" class="form-control" placeholder="Enter email" id="email" required>
                    </div>
                    <div class="form-group">
                        <label class="text txt-sm txt-bold" for="password">Password:</label>
                        <input type="password" class="form-control" placeholder="******" id="password" required>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button class="bg-main text-center mx-auto txt-white txt-sm txt-bold text py-2">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="login.html">Logout</a>
            </div>
        </div>
    </div>
</div>

<!-- Course Soon Modal -->
<?php
    $course = new WP_Query(array('post_type' => 'course', 'posts_per_page' => -1, 'status' => 'published'));
    while($course->have_posts()):$course->the_post();
        $id = get_the_id();
?>
<div class="modal fade" id="comingSoon<?php echo $id?>">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="p-4 add-border-bottom">
                <p class="title text-center mx-auto">Coming Soon</p>
                <p class="text txt-sm text-center mx-auto">Hello There, are you interested in this course?, we're sorry but its not available at the moment. But hey, you can drop your email and join the wait list, we will inform you when the course is available</p>
            </div>
            <form action="#" method="POST" class="px-3 was-validated">
                <input type="text" name="courseid" value="<?php echo $id?>" hidden>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="form-group">
                        <label class="text txt-sm txt-bold" for="email">Email address:</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter Email" id="email" required>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" name="wait_list" class="bg-main text-center mx-auto txt-white txt-sm txt-bold text py-2">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
    endwhile;
?>

<!-- Registration closed modal -->
<div class="modal fade" id="registrationClosed">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="p-4 add-border-bottom">
                <p class="title text-center mx-auto">Registration Closed</p>
                <p class="text txt-sm text-center mx-auto">Hello There, i see you're trying to enroll for this cohort, but unfortunately the registration for this cohort is closed. Its either the students limit has ben reached or the deadline for registration has passed. you can try applying for the next cohort</p>
            </div>
        </div>
    </div>
</div>

<!-- Join event -->
<?php
    $course = new WP_Query(array('post_type' => 'event', 'posts_per_page' => -1, 'status' => 'published'));
    while($course->have_posts()):$course->the_post();
        $id = get_the_id();
?>
<div class="modal fade" id="joinEvent<?php echo $id?>">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="p-4 add-border-bottom">
                <p class="title text-center mx-auto"><?php echo rwmb_meta('event_name')?></p>
                <p class="text txt-sm text-center mx-auto">If you're interested in participating in this event, please enter your email to join, and you will be notified on information about the event.</p>
            </div>
            <form action="#" method="POST" class="px-3 was-validated">
                <input type="text" name="eventid" value="<?php echo $id?>" hidden>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="form-group">
                        <label class="text txt-sm txt-bold" for="name">Full Name:</label>
                        <input type="name" name="name" class="form-control" placeholder="Enter Your Name" id="name" required>
                    </div>
                    <div class="form-group">
                        <label class="text txt-sm txt-bold" for="email">Email address:</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter Email" id="email" required>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" name="join_event" class="bg-main text-center mx-auto txt-white txt-sm txt-bold text py-2">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
    endwhile;
?>