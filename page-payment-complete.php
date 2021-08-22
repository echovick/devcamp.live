<?php echo get_header();?>
<?php
    // Get payment response details from flutter
    $local_tranaction_ref = $_GET['tx_ref'] ?? '';
    $flutter_transaction_ref = $_GET['transaction_id'] ?? '';
    $status = $_GET['status'] ?? '';

    if($status == "successful"){
        // Update transaction
        $transaction = new WP_Query(array(
            'post_type' => 'student-transaction',
            'posts_per_page' => -1,
            'meta_query' => array(
                array(
                    'key' => 'transaction_id',
                    'value' => $local_tranaction_ref,
                    'compare' => '=',
                ),
            ),
        ));
        if($transaction->have_posts()){
            while($transaction->have_posts()):$transaction->the_post();
                $student_id = rwmb_meta('student_id');
                $post_id = get_the_id();
            endwhile;
        }
        update_post_meta($post_id,'reference_id', $flutter_transaction_ref);
        update_post_meta($post_id,'payment_date', date('d-m-Y'));

        //Remove from unpaid list and add to paid list
        $email = get_post($student_id)->user_email;
        $name = get_post($student_id)->first_name.' '.get_post($student_id)->last_name;
        remove_user_from_list($email,'nxuj7kvbnAa4MqbPxsTduw');

        // Add user to paid list

        // Get course email lists
        $mailbox_settings = get_post($course_id)->mailbox_settings;
        $list = $mailbox_settings['paid_list'];
        
        add_user_to_list($name,$email,$list);

        // Update user enrollment
        $enrollment = new WP_Query(array(
            'post_type' => 'enrollment',
            'posts_per_page' => -1,
            'meta_query' => array(
                array(
                    'key' => 'student_id',
                    'value' => $student_id,
                    'compare' => '=',
                ),
            ),
        ));
        if($enrollment->have_posts()){
            while($enrollment->have_posts()):$enrollment->the_post();
                $enrollment_post_id = get_the_id();
            endwhile;
        }
    
        update_post_meta($enrollment_post_id,'transaction_id',$post_id);
        update_post_meta($enrollment_post_id,'date_updated',date('d-m-Y'));
        update_post_meta($enrollment_post_id,'status','Paid');
        
?>
    <div class="banner-section bg-main-1 text-center py-5 container-wrapper">
        <div class="card w-50 mx-auto shadow">
            <div class="card-body text-center">
                <p class="title txt-xlg mx-auto text-center">Payment Successfull!!!</p>
                <i class="fas txt-xlg mb-5 mt-3 txt-primary fa-thumbs-up"></i>
                <br>
                <p class="text txt-sm">Your payment have been confirmed, and you have been sent an email containing the course information and the next steps, if you encountered any problems with payment please contact us immediately</p>
                <div class="mx-auto my-4">
                    <a href="<?php echo site_url()?>" class="bg-main button txt-white txt-sm txt-bold text py-3 px-5">Home</a>
                </div>
                <p class="title txt-primary txt-sm">Email: support@devcamp.live <br>Phone/Whatsapp: 08129100006</p>
            </div>
        </div>
    </div>
<?php
    }else{
?>
    <div class="banner-section bg-main-1 text-center py-5 container-wrapper">
        <div class="card w-50 mx-auto shadow">
            <div class="card-body text-center">
                <p class="title txt-xlg mx-auto text-center">Oops, Something went wrong</p>
                <i class="fas txt-xlg mb-5 mt-3 txt-primary fa-times"></i>
                <br>
                <p class="text txt-sm">We encountered a problem while processing your payment, please try repaying or if you have been debited, please contact our support team immediately</p>
                <div class="mx-auto my-4">
                    <a href="<?php echo site_url()?>" class="bg-main button txt-white txt-sm txt-bold text py-3 px-5">Home</a>
                </div>
                <p class="title txt-primary txt-sm">Email: support@devcamp.live <br>Phone/Whatsapp: 08129100006</p>
            </div>
        </div>
    </div>
<?php
    }
?>
<?php echo get_footer();?>