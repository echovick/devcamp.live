<?php
    session_start();
    function theme_files(){
        /* Activate js scripts */
        wp_enqueue_script('ajax-js','https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js',NULL,'1.0',true);
        wp_enqueue_script('popper-js','https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js',NULL,'1.0',true);
        wp_enqueue_script('bootstrap-js','https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js',NULL,'1,0',true);
        wp_enqueue_script('font-awesome-kit','https://kit.fontawesome.com/dcf3d07c5a.js',NULL,'1.0',true);
        wp_enqueue_script('flickity-js','https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js',NULL,'1.0',true);

        /* Activate Stylesheets */
        wp_enqueue_style('theme_main_styles', get_stylesheet_uri());
        wp_enqueue_style('bootstrap-css','https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css');
        wp_enqueue_style('flickity-css','https://unpkg.com/flickity@2/dist/flickity.min.css');
        wp_enqueue_style('responsive-css', get_template_directory_uri().'/assets/css/responsive.css');
    }

    /* Hook to load scripts */
    add_action('wp_enqueue_scripts','theme_files');

    /* Hook to remove admin bar */
    add_action('after_setup_theme', 'remove_admin_bar');
 
    /* Function to remove admin bar for users */
    function remove_admin_bar() {
        if (!current_user_can('administrator') && !is_admin()) {
        show_admin_bar(false);
        }
    }

    @ini_set( 'upload_max_size' , '64M' );
    @ini_set( 'post_max_size', '64M');
    @ini_set( 'max_execution_time', '300' );

    function theme_features(){
        add_theme_support('title-tag');
    }

     /* 
        ======================================================================
        METABOX SPECIFIC FUNCTIONS BEGIN
        ======================================================================
    */

    /* Function to get the direct url for a metabox image */
    function get_metabox_image_url($key){
        /* Reset */
        $image = 0;
        $images = rwmb_meta( $key, array( 'limit' => 1 ) );
        $image = reset( $images );
        
        return $image['full_url'];
    }

    /* Function to get the alt caption for a metabox image */
    function get_metabox_image_alt($key){
        /* Reset */
        $image = 0;
        $images = rwmb_meta( $key, array( 'limit' => 1 ) );
        $image = reset( $images );
        
        return $image['alt'];
    }

    /* Function to get the direct url of an image in a metabox image gallery */
    function get_metabox_image_gallery_url($key){
        /* Reset */
        $image = 0;
        $images = rwmb_meta( $key, array( 'size' => 'thumbnail' ) );
        $image = reset( $images );
        
        return $image['full_url'];
    }

    /* Function to get metabox gallery images, it returns an array */
    function get_metabox_image_gallery($key){
        $image = 0;
        $images = rwmb_meta( $key, array( 'size' => 'thumbnail' ) );
        return $images;
    }

    /* Function to get the caption of a particular image from a metabox image gallery*/
    function get_metabox_image_gallery_caption($key){
        /* Reset */
        $image = 0;
        $images = rwmb_meta( $key, array( 'limit' => '1' ) );
        $image = reset( $images );
        
        return $image['caption'];
    }

    /* Function to get the url of an image from a metabox group */
    function get_metabox_group_image_url( $array, $key ){
        /* Reset */
        $image = 0;
        $image_ids = isset( $array[$key] ) ? $array[$key] : array();

        foreach ( $image_ids as $image_id ) {
            $image = RWMB_Image_Field::file_info( $image_id, array( 'size' => 'thumbnail' ) );
        }
        
        return $image['full_url'];
    }

    /* Function to get a file url from a metabox group */
    function get_metabox_group_file_url($array, $key){
        $files = 0;
        if(isset($array[$key])){
            $files_id = $array[$key];
        }
        //  = isset($array[$key] ) ? $array[$key] : array();
        $files = rwmb_meta( $files_id, array( 'limit' => 1 ) );
        $file = reset( $files );

        return $file['url'];
    }

    /* Function to get image alt caption from a metabox group */
    function get_metabox_group_image_alt( $array, $key ){
        /* Reset */
        $image = 0;
        $image_ids = isset( $array[$key] ) ? $array[$key] : array();

        foreach ( $image_ids as $image_id ) {
            $image = RWMB_Image_Field::file_info( $image_id, array( 'size' => 'thumbnail' ) );
        }
        
        return $image['alt'];
    }

    /* 
        =======================================================================
        METABOX SPECIFIC FUNCTIONS ENDS
        =======================================================================
    */

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    include(get_template_directory().'/includes/process.php');

    /* 
    * Sendey Mail Bos functions
    */
    
    // update user in list
    function update_user_to_list($n, $e, $l, $p){
        $your_installation_url = 'https://mailbox.bloodzoneng.com'; //Your Sendy installation (without the trailing slash)
        $api_key = 'jXOmbz8PimcnaD0Rz7mW'; //Can be retrieved from your Sendy's main settings

        $name = $n;
        $email = $e;
        $list = $l;
        $plan = $p;

        //Check fields
        if($name=='' || $email=='' || $list=='')
        {
            echo 'Please fill in all fields';
            exit;
        }

        //Subscribe
        $postdata = http_build_query(
            array(
            'name' => $name,
            'email' => $email,
            'plan' => $plan,
            'list' => $list,
            'api_key' => $api_key,
            'boolean' => 'true'
            )
        );
        
        $opts = array('http' => array('method'  => 'POST', 'header'  => 'Content-type: application/x-www-form-urlencoded', 'content' => $postdata));
        $context  = stream_context_create($opts);
        $result = file_get_contents($your_installation_url.'/subscribe', false, $context);
        
        //check result and redirect
        if($result){
            return $result;
        }
    }

    @ini_set( 'upload_max_size' , '64M' );
    @ini_set( 'post_max_size', '64M');
    @ini_set( 'max_execution_time', '300' );

    // Add user to product list
    function add_user_to_list($n, $e, $l){
        $your_installation_url = 'https://mailbox.bloodzoneng.com'; //Your Sendy installation (without the trailing slash)
        $api_key = 'jXOmbz8PimcnaD0Rz7mW'; //Can be retrieved from your Sendy's main settings

        $name = $n;
        $email = $e;
        $list = $l;

        //Check fields
        if($name=='' || $email=='' || $list=='')
        {
            echo 'Please fill in all fields';
            exit;
        }

        //Subscribe
        $postdata = http_build_query(
            array(
            'name' => $name,
            'email' => $email,
            'list' => $list,
            'api_key' => $api_key,
            'boolean' => 'true'
            )
        );
        
        $opts = array('http' => array('method'  => 'POST', 'header'  => 'Content-type: application/x-www-form-urlencoded', 'content' => $postdata));
        $context  = stream_context_create($opts);
        $result = file_get_contents($your_installation_url.'/subscribe', false, $context);
        
        //check result and redirect
        if($result){
            return $result;
        }
    }

    // Remove user from list
    function remove_user_from_list($e,$l){
        $your_installation_url = 'https://mailbox.bloodzoneng.com'; //Your Sendy installation (without the trailing slash)
        $api_key = 'jXOmbz8PimcnaD0Rz7mW'; //Can be retrieved from your Sendy's main settings

        $email = $e;
        $list = $l;

        //Check fields
        if($email=='' || $list=='')
        {
            echo 'Please fill in all fields..';
            exit;
        }

        //Unsubscribe
        $postdata = http_build_query(
            array(
            'email' => $email,
            'list' => $list,
            'api_key' => $api_key,
            'boolean' => 'true'
            )
        );
        $opts = array('http' => array('method'  => 'POST', 'header'  => 'Content-type: application/x-www-form-urlencoded', 'content' => $postdata));
        $context  = stream_context_create($opts);
        $result = file_get_contents($your_installation_url.'/unsubscribe', false, $context);
        
        //check result and redirect
        if($result){
            return $result;
        }
    }

    // Delete user from list
    function delete_user_from_list($e,$l){
        $your_installation_url = 'https://mailbox.bloodzoneng.com'; //Your Sendy installation (without the trailing slash)
        $api_key = 'jXOmbz8PimcnaD0Rz7mW'; //Can be retrieved from your Sendy's main settings

        $email = $e;
        $list = $l;

        //Check fields
        if($email=='' || $list=='')
        {
            echo 'Please fill in all fields...';
            exit;
        }

        //delete
        $postdata = http_build_query(
            array(
            'email' => $email,
            'list' => $list,
            'api_key' => $api_key,
            'boolean' => 'true'
            )
        );
        $opts = array('http' => array('method'  => 'POST', 'header'  => 'Content-type: application/x-www-form-urlencoded', 'content' => $postdata));
        $context  = stream_context_create($opts);
        $result = file_get_contents($your_installation_url.'/api/subscribers/delete.php', false, $context);
        
        //check result and redirect
        if($result){
            return $result;
        }
    }

    /* 
        ================= Customising table headers ================
    */

    // School user table
    add_filter('manage_school-user_posts_columns', 'bs_user_table_head');
    function bs_user_table_head( $defaults ) {
        $defaults['first_name'] = 'First name';
        $defaults['middle_name']  = 'Middle Name';
        $defaults['last_name'] = 'Last Name';
        $defaults['user_email'] = 'User Email';
        $defaults['phone_number'] = 'Phone Number';
        return $defaults;
    }
    add_action( 'manage_school-user_posts_custom_column', 'bs_user_table_content', 10, 2 );
    function bs_user_table_content( $column_name, $post_id ) {
        if ($column_name == 'first_name') {
            $first_name = get_post_meta( $post_id, 'first_name', true );
            echo $first_name;
        }
        
        if ($column_name == 'middle_name') {
            $middle_name = get_post_meta( $post_id, 'middle_name', true );
            echo $middle_name;
        }

        if ($column_name == 'last_name') {
            $last_name = get_post_meta( $post_id, 'last_name', true );
            echo $last_name;
        }

        if ($column_name == 'user_email') {
            $user_email = get_post_meta( $post_id, 'user_email', true );
            echo $user_email;
        }

        if ($column_name == 'phone_number') {
            $phone_number = get_post_meta( $post_id, 'phone_number', true );
            echo $phone_number;
        }
    }

    // Testimonial
    add_filter('manage_testimonial_posts_columns', 'bs_testimonial_table_head');
    function bs_testimonial_table_head( $defaults ) {
        $defaults['name'] = 'Author Name';
        $defaults['role_title']  = 'Role / Title';
        return $defaults;
    }
    add_action( 'manage_testimonial_posts_custom_column', 'bs_testimonial_table_content', 10, 2 );
    function bs_testimonial_table_content( $column_name, $post_id ) {
        if ($column_name == 'name') {
            $name = get_post_meta( $post_id, 'name', true );
            echo $name;
        }
        
        if ($column_name == 'role_title') {
            $role_title = get_post_meta( $post_id, 'role_title', true );
            echo $role_title;
        }
    }

    // Cohorts
    add_filter('manage_cohort_posts_columns', 'bs_cohort_table_head');
    function bs_cohort_table_head( $defaults ) {
        $defaults['course_id'] = 'Course';
        $defaults['cohort_name']  = 'Cohort';
        return $defaults;
    }
    add_action( 'manage_cohort_posts_custom_column', 'bs_cohort_table_content', 10, 2 );
    function bs_cohort_table_content( $column_name, $post_id ) {
        if ($column_name == 'course_id') {
            $name = get_post_meta( $post_id, 'course_id', true );
            $name = get_post($name)->course_name;
            echo $name;
        }

        if ($column_name == 'cohort_name') {
            $name = get_post_meta( $post_id, 'cohort_name', true );
            echo $name;
        }
    }

    // Assignment
    add_filter('manage_assignment_posts_columns', 'bs_assignment_table_head');
    function bs_assignment_table_head( $defaults ) {
        $defaults['course_id'] = 'Course';
        $defaults['cohort_id']  = 'Cohort';
        $defaults['assignment_type'] = 'Assignment Type';
        $defaults['assignment_title'] = 'Assignment Title';
        $defaults['assignment_description'] = 'Assignment Description';
        $defaults['assignment_link'] = 'Assignment Link';
        $defaults['submits'] = 'No. Of Submits';
        return $defaults;
    }
    add_action( 'manage_assignment_posts_custom_column', 'bs_assignment_table_content', 10, 2 );
    function bs_assignment_table_content( $column_name, $post_id ) {
        if ($column_name == 'course_id') {
            $name = get_post_meta( $post_id, 'course_id', true );
            $name = get_post($name)->course_name;
            echo $name;
        }

        if ($column_name == 'cohort_id') {
            $name = get_post_meta( $post_id, 'cohort_id', true );
            $name = get_post($name)->cohort_name;
            echo $name;
        }

        if ($column_name == 'assignment_type') {
            $assignment_type = get_post_meta( $post_id, 'assignment_type', true );
            echo $assignment_type;
        }

        if ($column_name == 'assignment_title') {
            $name = get_post_meta( $post_id, 'assignment_title', true );
            echo $name;
        }

        if ($column_name == 'assignment_description') {
            $name = get_post_meta( $post_id, 'assignment_description', true );
            echo $name;
        }

        if ($column_name == 'assignment_link') {
            $name = get_post_meta( $post_id, 'assignment_link', true );
            echo $name;
        }

        if ($column_name == 'submits') {
            $submits = get_post_meta( $post_id, 'submits', true );
            echo count($submits);
        }
    }

    // Announcement
    add_filter('manage_announcement_posts_columns', 'bs_announcement_table_head');
    function bs_announcement_table_head( $defaults ) {
        $defaults['course_id'] = 'Course';
        $defaults['cohort_id']  = 'Cohort';
        return $defaults;
    }
    add_action( 'manage_announcement_posts_custom_column', 'bs_announcement_table_content', 10, 2 );
    function bs_announcement_table_content( $column_name, $post_id ) {
        if ($column_name == 'course_id') {
            $name = get_post_meta( $post_id, 'course_id', true );
            $name = get_post($name)->course_name;
            echo $name;
        }

        if ($column_name == 'cohort_id') {
            $name = get_post_meta( $post_id, 'cohort_id', true );
            $name = get_post($name)->cohort_name;
            echo $name;
        }
    }

    // Applications
    add_filter('manage_application_posts_columns', 'bs_application_table_head');
    function bs_application_table_head( $defaults ) {
        $defaults['full_name'] = 'Full Name';
        $defaults['email']  = 'Email';
        $defaults['phone_number'] = 'Phone Number';
        $defaults['course_curriculum']  = 'Course Curriculum';
        $defaults['application_status'] = 'Application Status';
        return $defaults;
    }
    add_action( 'manage_application_posts_custom_column', 'bs_application_table_content', 10, 2 );
    function bs_application_table_content( $column_name, $post_id ) {
        if ($column_name == 'full_name') {
            $full_name = get_post_meta( $post_id, 'full_name', true );
            echo $full_name;
        }
        if ($column_name == 'email') {
            $email = get_post_meta( $post_id, 'email', true );
            echo $email;
        }
        if ($column_name == 'phone_number') {
            $phone_number = get_post_meta( $post_id, 'phone_number', true );
            echo $phone_number;
        }
        if ($column_name == 'course_curriculum') {
            $course_curriculum = get_post_meta( $post_id, 'course_curriculum', true );
            echo substr($course_curriculum, 0, 100).'...';
        }
        if ($column_name == 'application_status') {
            $application_status = get_post_meta( $post_id, 'application_status', true );
            echo $application_status;
        }
    }

    // Rating
    add_filter('manage_rating_posts_columns', 'bs_rating_table_head');
    function bs_rating_table_head( $defaults ) {
        $defaults['instructor_id'] = 'Intructor Name';
        $defaults['course_id']  = 'Course Name';
        $defaults['rating'] = 'Rating';
        return $defaults;
    }
    add_action( 'manage_rating_posts_custom_column', 'bs_rating_table_content', 10, 2 );
    function bs_rating_table_content( $column_name, $post_id ) {
        if ($column_name == 'instructor_id') {
            $instructor_id = get_post_meta( $post_id, 'instructor_id', true );
            $instructor_id = get_post($instructor_id)->middle_name.' '.get_post($instructor_id)->last_name;
            echo $instructor_id;
        }
        if ($column_name == 'course_id') {
            $course_id = get_post_meta( $post_id, 'course_id', true );
            $course_name = get_post($course_id)->course_name;
            echo $course_name;
        }
        if ($column_name == 'rating') {
            $rating = get_post_meta( $post_id, 'rating', true );
            echo $rating;
        }
    }

    // Enrollments
    add_filter('manage_enrollment_posts_columns', 'bs_enrollment_table_head');
    function bs_enrollment_table_head( $defaults ) {
        $defaults['student_id'] = 'Student Name';
        $defaults['course_id']  = 'Course Name';
        $defaults['private_general'] = 'Private Or General';
        $defaults['cohort_id']  = 'Cohort Name';
        $defaults['admin_id']  = 'Course Admin';
        $defaults['status']  = 'Status';
        return $defaults;
    }
    add_action( 'manage_enrollment_posts_custom_column', 'bs_enrollment_table_content', 10, 2 );
    function bs_enrollment_table_content( $column_name, $post_id ) {
        if ($column_name == 'student_id') {
            $name = get_post_meta( $post_id, 'student_id', true );
            $name = get_post($name)->middle_name.' '.get_post($name)->last_name;
            echo $name;
        }
        if ($column_name == 'course_id') {
            $name = get_post_meta( $post_id, 'course_id', true );
            $name = get_post($name)->course_name;
            echo $name;
        }
        if ($column_name == 'private_general') {
            $private_general = get_post_meta( $post_id, 'private_general', true );
            echo $private_general;
        }
        if ($column_name == 'cohort_id') {
            $name = get_post_meta( $post_id, 'cohort_id', true );
            $name = get_post($name)->cohort_name;
            echo $name;
        }
        if ($column_name == 'admin_id') {
            $name = get_post_meta( $post_id, 'admin_id', true );
            $name = get_post($name)->middle_name.' '.get_post($name)->last_name;
            echo $name;
        }
        if ($column_name == 'status') {
            $status = get_post_meta( $post_id, 'status', true );
            echo $status;
        }
    }

    // Admin Wallets
    add_filter('manage_admin-wallet_posts_columns', 'bs_admin_wallet_table_head');
    function bs_admin_wallet_table_head( $defaults ) {
        $defaults['admin_id'] = 'Admin';
        $defaults['active_balance']  = 'Active Balance';
        $defaults['pending_withdrawal'] = 'Pending Withdrawal';
        $defaults['total_cashout']  = 'Total Cashout';
        return $defaults;
    }
    add_action( 'manage_admin-wallet_posts_custom_column', 'bs_admin_wallet_table_content', 10, 2 );
    function bs_admin_wallet_table_content( $column_name, $post_id ) {
        if ($column_name == 'admin_id') {
            $name = get_post_meta( $post_id, 'admin_id', true );
            $name = get_post($name)->middle_name.' '.get_post($name)->last_name;
            echo $name;
        }
        if ($column_name == 'active_balance') {
            $active_balance = get_post_meta( $post_id, 'active_balance', true );
            echo '&#8358;'.number_format($active_balance);
        }
        if ($column_name == 'pending_withdrawal') {
            $pending_withdrawal = get_post_meta( $post_id, 'pending_withdrawal', true );
            echo '&#8358;'.number_format($pending_withdrawal);
        }
        if ($column_name == 'total_cashout') {
            $total_cashout = get_post_meta( $post_id, 'total_cashout', true );
            echo '&#8358;'.number_format($total_cashout);
        }
    }

    // Wallet Transactions
    add_filter('manage_wallet-transaction_posts_columns', 'bs_wallet_transaction_table_head');
    function bs_wallet_transaction_table_head( $defaults ) {
        $defaults['admin_id'] = 'Admin';
        $defaults['transaction_type']  = 'Transaction Type';
        $defaults['transac_description'] = 'Description';
        $defaults['transac_amount']  = 'Amount';
        return $defaults;
    }
    add_action( 'manage_wallet-transaction_posts_custom_column', 'bs_wallet_transaction_table_content', 10, 2 );
    function bs_wallet_transaction_table_content( $column_name, $post_id ) {
        if ($column_name == 'admin_id') {
            $name = get_post_meta( $post_id, 'admin_id', true );
            $name = get_post($name)->middle_name.' '.get_post($name)->last_name;
            echo $name;
        }
        if ($column_name == 'transaction_type') {
            $transaction_type = get_post_meta( $post_id, 'transaction_type', true );
            echo $transaction_type;
        }
        if ($column_name == 'transac_description') {
            $transac_description = get_post_meta( $post_id, 'transac_description', true );
            echo $transac_description;
        }
        if ($column_name == 'transac_amount') {
            $transac_amount = get_post_meta( $post_id, 'transac_amount', true );
            echo '&#8358;'.number_format($transac_amount);
        }
    }

    // Students Transaction
    add_filter('manage_student-transaction_posts_columns', 'bs_student_transaction_table_head');
    function bs_student_transaction_table_head( $defaults ) {
        $defaults['reference_id'] = 'Flutterwave Ref ID';
        $defaults['student_id']  = 'Student';
        $defaults['course_id'] = 'Course';
        $defaults['cohort_id']  = 'Cohort';
        $defaults['admin_id']  = 'Admin';
        $defaults['amount']  = 'Amount';
        return $defaults;
    }
    add_action( 'manage_student-transaction_posts_custom_column', 'bs_student_transaction_table_content', 10, 2 );
    function bs_student_transaction_table_content( $column_name, $post_id ) {
        if ($column_name == 'reference_id') {
            $reference_id = get_post_meta( $post_id, 'reference_id', true );
            echo $reference_id;
        }
        if ($column_name == 'student_id') {
            $name = get_post_meta( $post_id, 'student_id', true );
            $name = get_post($name)->middle_name.' '.get_post($name)->last_name;
            echo $name;
        }
        if ($column_name == 'course_id') {
            $name = get_post_meta( $post_id, 'course_id', true );
            $name = get_post($name)->course_name;
            echo $name;
        }
        if ($column_name == 'cohort_id') {
            $name = get_post_meta( $post_id, 'cohort_id', true );
            $name = get_post($name)->cohort_name;
            echo $name;
        }
        if ($column_name == 'admin_id') {
            $name = get_post_meta( $post_id, 'admin_id', true );
            $name = get_post($name)->middle_name.' '.get_post($name)->last_name;
            echo $name;
        }
        if ($column_name == 'amount') {
            $amount = get_post_meta( $post_id, 'amount', true );
            echo '&#8358;'.number_format($amount);
        }
    }

    // Courses
    add_filter('manage_course_posts_columns', 'bs_course_table_head');
    function bs_course_table_head( $defaults ) {
        $defaults['course_name'] = 'Course Name';
        $defaults['course_description']  = 'Description';
        $defaults['course_admin'] = 'Course Admin';
        $defaults['original_price']  = 'Price';
        $defaults['private_tutor_cost']  = 'Private Tutoring Cost';
        $defaults['course_status']  = 'Status';
        return $defaults;
    }
    add_action( 'manage_course_posts_custom_column', 'bs_course_table_content', 10, 2 );
    function bs_course_table_content( $column_name, $post_id ) {
        if ($column_name == 'course_name') {
            $course_name = get_post_meta( $post_id, 'course_name', true );
            echo $course_name;
        }
        if ($column_name == 'course_description') {
            $course_description = get_post_meta( $post_id, 'course_description', true );
            echo substr($course_description, 0, 100).'....';
        }
        if ($column_name == 'course_admin') {
            $name = get_post_meta( $post_id, 'course_admin', true );
            $name = get_post($name)->middle_name.' '.get_post($name)->last_name;
            echo $name;
        }
        if ($column_name == 'original_price') {
            $original_price = get_post_meta( $post_id, 'original_price', true );
            echo '&#8358;'.number_format($original_price);
        }
        if ($column_name == 'private_tutor_cost') {
            $private_tutor_cost = get_post_meta( $post_id, 'private_tutor_cost', true );
            echo '&#8358;'.number_format($private_tutor_cost);
        }
        if ($column_name == 'course_status') {
            $course_status = get_post_meta( $post_id, 'course_status', true );
            echo $course_status;
        }
    }

    /* 
        ================= Customising table headers End ================
    */
?>