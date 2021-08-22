<?php echo get_header();?>
<!-- Banner section start -->
<?php
    if(isset($_GET['a']) && $_GET['a'] = 'existing-user'){
?>
<div class="banner-section bg-main-1 text-center py-5 container-wrapper">
    <?php
        if(isset($_SESSION['msg'])){
            echo '<div class="alert w-40 mx-auto txt-md text alert-info">'.$_SESSION['msg'].'</div>';
            unset($_SESSION['msg']);
        }
    ?>
    <div class="w-40 shadow mx-auto card">
        <div class="pt-4 add-border-bottom">
            <p class="title text-center mx-auto">Enroll To the <?php echo get_post($_GET['courseid'])->course_name?></p>
            <p class="text txt-sm text-center mx-auto">Please enter your details to login to your account</p>
        </div>
        <div class="alert alert-info txt-sm text">
            <i class="fas fa-info-circle mr-2"></i> If you have'nt enroll on this site before, Please head to the main enrollment form, <a href="<?php echo site_url('enroll?courseid=').$_GET['courseid'].'&cohortid='.$_GET['cohortid']?>">Click Here</a>
        </div>
        <form action="#" method="POST" class="px-3 was-validated">
            <!-- Modal body -->
            <div class="modal-body">
                <div class="row w-100 mx-auto">
                    <div class="form-group col-12 text-left">
                        <label class="text txt-sm txt-bold" for="email">Email Address:</label>
                        <input type="email" name="email" class="form-control" placeholder="Email Address" id="email" required>
                    </div>
                </div> 
                <div class="row w-100 mx-auto">
                    <div class="form-group col-12 text-left">
                        <label class="text txt-sm txt-bold" for="password">Password:</label>
                        <input type="password" name="password" class="form-control" placeholder="Enter the password you used for inital enrollment" id="password" required>
                    </div>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="submit" name="existing_enroll" class="bg-main text-center mx-auto txt-white txt-sm txt-bold text py-2">Submit</button>
            </div>
        </form>
    </div>
    <div class="row mx-auto w-100 py-3 text-center justify-content-center">
        <p class="title txt-primary text-center txt-sm">Email: support@devcamp.live <br>Phone/Whatsapp: 08129100006</p>
    </div>
</div>
<?php
    }else{
?>
<div class="banner-section bg-main-1 text-center py-5 container-wrapper">
    <?php
        if(isset($_SESSION['msg'])){
            echo '<div class="alert w-40 alert-info">'.$_SESSION['msg'].'</div>';
            unset($_SESSION['msg']);
        }
    ?>
    <div class="w-40 shadow mx-auto card">
        <div class="pt-4 add-border-bottom">
            <p class="title text-center mx-auto">Enroll To the <?php echo get_post($_GET['courseid'])->course_name?></p>
            <p class="text txt-sm text-center mx-auto">Please enter your details to login to your account</p>
        </div>
        <div class="alert alert-info txt-sm text">
            <i class="fas fa-info-circle mr-2"></i> If you have enroll on this site before, No worries, there's no need to enroll again, <a href="<?php echo site_url('enroll?a=existing-user&courseid=').$_GET['courseid'].'&cohortid='.$_GET['cohortid']?>">Click Here</a>
        </div>
        <form action="#" method="POST" class="px-3 was-validated">
            <!-- Modal body -->
            <div class="modal-body">
                <div class="row w-100 mx-auto">
                    <div class="form-group col-md-6 col-12 text-left">
                        <label class="text txt-sm txt-bold" for="fname">First Name:</label>
                        <input type="text" name="first_name" class="form-control" placeholder="First Name" id="fname" required>
                    </div>
                    <div class="form-group col-md-6 col-12 text-left">
                        <label class="text txt-sm txt-bold" for="lname">Last Name:</label>
                        <input type="text" name="last_name" class="form-control" placeholder="Last Name" id="lname" required>
                    </div>
                </div> 
                <div class="row w-100 mx-auto">
                    <div class="form-group col-12 text-left">
                        <label class="text txt-sm txt-bold" for="oname">Others Names:</label>
                        <input type="text" name="other_names" class="form-control" placeholder="Other Names" id="oname" required>
                    </div>
                </div> 
                <div class="row w-100 mx-auto">
                    <div class="form-group col-12 text-left">
                        <label class="text txt-sm txt-bold" for="email">Email Address:</label>
                        <input type="email" name="email" class="form-control" placeholder="Email Address" id="email" required>
                    </div>
                </div> 
                <div class="row w-100 mx-auto">
                    <div class="form-group col-12 text-left">
                        <label class="text txt-sm txt-bold" for="phone">Phone Number:</label>
                        <input type="text" name="phone_number" class="form-control" placeholder="Please Enter a working phone number..." id="phone" required>
                    </div>
                </div> 
                <div class="row w-100 mx-auto">
                    <div class="form-group col-md-6 col-12 text-left">
                        <label class="text txt-sm txt-bold" for="password">Password:</label>
                        <input type="password" name="password" class="form-control" placeholder="******" id="password" required>
                    </div>
                    <div class="form-group col-md-6 col-12 text-left">
                        <label class="text txt-sm txt-bold" for="password">Confirm Password:</label>
                        <input type="password" name="confirm_password" class="form-control" placeholder="******" id="password" required>
                    </div>
                </div>
                <div class="row w-100 mx-auto">
                    <p class="txt-sm text-left text txt-normal"><i class="fas fa-info mr-3"></i>This Password will be used to mark your attendance, give you access to your live classes and all yoour subsquent enrollments on our site</p>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="submit" name="new_enroll" class="bg-main text-center mx-auto txt-white txt-sm txt-bold text py-2">Submit</button>
            </div>
        </form>
    </div>
    <div class="row mx-auto w-100 py-3 text-center justify-content-center">
        <p class="title txt-primary text-center txt-sm">Email: support@devcamp.live <br>Phone: 08129100006</p>
    </div>
</div>
<?php
    }
?>
<!-- Banner section end -->