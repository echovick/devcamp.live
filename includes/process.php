<?php
    // Code to subscribe user to newsletter
    if(isset($_POST['subscribe_newsletter'])){
        $email = $_POST['email'];
        $name = $email;
        $name_array = explode("@",$name);
        $name = $name_array[0];
        $list = "fMo2l6763eTs5pnWV4H8kSkQ";

        add_user_to_list($name, $email, $list);
        $_SESSION['msg'] = "Thank You for subscribing to our newsletter!!!";

        // Redirect
        $url = site_url();
        wp_redirect($url);
    }

    // Code to enroll existing user
    if(isset($_POST['existing_enroll'])){
        $courseid = $_GET['courseid'];
        $cohortid = $_GET['cohortid'];
        $email = test_input($_POST['email'] ?? '');
        $password = test_input($_POST['password'] ?? '');
        $password = md5($password);
        
        // Get course email lists
        $mailbox_settings = get_post($courseid)->mailbox_settings;
        $enrollment_list = $mailbox_settings['unpaid_list'];


        // Get user details
        $user = new WP_Query(array(
            'post_type' => 'school-user',
            'posts_per_page' => 1,
            'meta_query' => array(
                array(
                    'key' => 'user_email',
                    'value' => $email,
                    'compare' => '=',
                ),
            ),
        ));

        if($user->have_posts()){
            while($user->have_posts()):$user->the_post();
                $first_name = rwmb_meta('first_name');
                $last_name = rwmb_meta('last_name');
                $other_names = rwmb_meta('other_names');
                $this_password = rwmb_meta('password');
                $phone_number = rwmb_meta('phone_number');
            endwhile;   
        }

        // Get course admin
        $admin_id = get_post($courseid)->course_admin;
        
        // Check if enrollment is private or general
        if($cohortid == 'private'){
            $private_general = "Private Tutoring";
        }else{
            $private_general = "General";
        }
        
        // Check password
        if($password !== $this_password){
            $_SESSION['msg'] = "Passwords incorrect";
            $url = site_url('enroll?a=existing-user&courseid=').$course_id.'&cohortid='.$cohortid;
            wp_redirect($url);
            exit;
        }

        // Create Enrollment
        $enrollment_post_id = wp_insert_post(
            array(
                'post_type' => 'enrollment',
                'post_title' => $user_post_id.$courseid.$cohortid,
                'post_content' => '',
                'post_status' => 'publish',
            )
        );
        // Save enrollent details
        update_post_meta($enrollment_post_id,'student_id',$user_post_id);
        update_post_meta($enrollment_post_id,'course_id',$courseid);
        update_post_meta($enrollment_post_id,'private_general',$private_general);
        update_post_meta($enrollment_post_id,'cohort_id',$cohortid);
        update_post_meta($enrollment_post_id,'admin_id',$admin_id);

        // Add User to enrollment list
        add_user_to_list($first_name,$email,$enrollment_list);

        // Redirect to payment page
        $url = site_url('pay?courseid=').$courseid.'&cohortid='.$cohortid.'&userid='.$user_post_id;
        wp_redirect($url);
        exit;
    }

    // Code to enroll new user
    if(isset($_POST['new_enroll'])){
        $courseid = $_GET['courseid'];
        $cohortid = $_GET['cohortid'];
        $first_name = test_input($_POST['first_name'] ?? '');
        $last_name = test_input($_POST['last_name'] ?? '');
        $other_names = test_input($_POST['other_names'] ?? '');
        $email = test_input($_POST['email'] ?? '');
        $password = test_input($_POST['password'] ?? '');
        $confirm_password = test_input($_POST['confirm_password'] ?? '');
        $phone = test_input($_POST['phone_number'] ?? '');

        // Get course email lists
        $mailbox_settings = get_post($courseid)->mailbox_settings;
        $enrollment_list = $mailbox_settings['unpaid_list'];

        // Get course admin
        $admin_id = get_post($courseid)->course_admin;
        
        // Check if enrollment is private or general
        if($cohortid == 'private'){
            $private_general = "Private Tutoring";
        }else{
            $private_general = "General";
        }

        // Check if email already exists
        $users = new WP_Query(array(
            'post_type' => 'school-user',
            'posts_per_page' => -1,
            'meta_query' => array(
                array(
                    'key' => 'user_email',
                    'value' => $email,
                    'compare' => '=',
                ),
                array(
                    'key' => 'user_role',
                    'value' => 'Student',
                    'compare' => '=',
                ),
            ),
        ));

        // If user already exists
        if($users->have_post){
            $_SESSION['msg'] = "The user with email <b>".$email."</b> already exists, enroll through here instead";
            $url = site_url('enroll?a=existing-user&courseid=').$courseid.'&cohortid='.$cohortid;
            wp_redirect($url);
            exit;
        }

        // Check if passwords match
        if($password == $confirm_password){
            $password = md5($password);
        }else{
            $_SESSION['msg'] = "Passwords Doest Match";
            $url = site_url('enroll?courseid=').$course_id.'&cohortid='.$cohortid;
            wp_redirect($url);
            exit;
        }

        // Create User
        $user_post_id = wp_insert_post(
            array(
                'post_type' => 'school-user',
                'post_title' => $first_name.' '.$last_name,
                'post_content' => '',
                'post_status' => 'publish',
            )
        );
        // Save user details
        update_post_meta($user_post_id,'first_name',$first_name);
        update_post_meta($user_post_id,'last_name',$last_name);
        update_post_meta($user_post_id,'middle_name',$other_names);
        update_post_meta($user_post_id,'user_role','Student');
        update_post_meta($user_post_id,'user_email',$email);
        update_post_meta($user_post_id,'phone_number',$phone);
        update_post_meta($user_post_id,'password',$password);
        update_post_meta($user_post_id,'date_created',date('d-m-y'));
        update_post_meta($user_post_id,'date_updated',date('d-m-y'));

        // Create Enrollment
        $enrollment_post_id = wp_insert_post(
            array(
                'post_type' => 'enrollment',
                'post_title' => $user_post_id.$courseid.$cohortid,
                'post_content' => '',
                'post_status' => 'publish',
            )
        );
        // Save enrollent details
        update_post_meta($enrollment_post_id,'student_id',$user_post_id);
        update_post_meta($enrollment_post_id,'course_id',$courseid);
        update_post_meta($enrollment_post_id,'private_general',$private_general);
        update_post_meta($enrollment_post_id,'cohort_id',$cohortid);
        update_post_meta($enrollment_post_id,'admin_id',$admin_id);

        // Add User to enrollment list
        add_user_to_list($first_name,$email,$enrollment_list);

        // Redirect to payment page
        $url = site_url('pay?courseid=').$courseid.'&cohortid='.$cohortid.'&userid='.$user_post_id;
        wp_redirect($url);
        exit;
    }

    // Code to save instructor application
    if(isset($_POST['submit_instructor_application'])){
        $instructor_name = test_input($_POST['instructor_name'] ?? '');
        $instructor_email = test_input($_POST['instructor_email'] ?? '');
        $instructor_phone= test_input($_POST['instructor_phone'] ?? '');
        $course_description = test_input($_POST['course_description'] ?? '');

        $application_post_id = wp_insert_post(
            array(
                'post_type' => 'application',
                'post_title' => $instructor_email,
                'post_content' => '',
                'post_status' => 'publish',
            )
        );
        update_post_meta($application_post_id,'full_name', $instructor_name);
        update_post_meta($application_post_id,'email', $instructor_email);
        update_post_meta($application_post_id,'phone_number',$instructor_phone);
        update_post_meta($application_post_id,'course_curriculum',$course_description);
        update_post_meta($application_post_id,'application_status','Pending');

        // add to application list
        add_user_to_list($instructor_name,$instructor_email,'SKWxjzHxR95k8hdgpfzrGA');

        global $wp;
        $_SESSION['msg'] = "Application Has been sent successfully, you will be contacted within the next two business days";
        $url = home_url( $wp->request );
        wp_redirect($url);
        exit;
    }

    // Wait list
    if(isset($_POST['wait_list'])){
        $email = test_input($_POST['email'] ?? '');
        $courseid = test_input($_POST['courseid'] ?? '');

        $wait_list = new WP_Query(
            array(
                'post_type' => 'wait-list', 
                'posts_per_page' => -1, 
                'status' => 'published',
                'meta_query' => array(
                    array(
                        'key' => 'course_id',
                        'value' => $courseid,
                        'compare' => '=',
                    ),
                ),
            )
        );
        while($wait_list->have_posts()):$wait_list->the_post();
            $post_id = get_the_id();
            $user_emails = rwmb_meta('user_emails');
        endwhile;

        update_post_meta($post_id,'user_emails',$user_emails.','.$email);

        // Set msg
        $_SESSION['msg'] = "You Have been successfully added to the wait list for this course, you will be notified, as soon as its available";
        $url = site_url();
        wp_redirect($url);
        exit;
    }

    // Join event
    if(isset($_POST['join_event'])){
        $email = test_input($_POST['email'] ?? '');
        $eventid = test_input($_POST['eventid'] ?? '');
        $name = test_input($_POST['name'] ?? '');

        $list = get_post($eventid)->event_email_list;

        add_user_to_list($name,$email,$list);

        // Set message and redirect
        $_SESSION['msg'] = "You Have been successfully added to the attendee list for this event, you will be duely informed and reminded about the event.";
        $url = site_url();
        wp_redirect($url);
        exit;
    }
?>