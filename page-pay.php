<?php echo get_header();?>
<?php
    $courseid = $_GET['courseid'];
    $cohortid = $_GET['cohortid'];
    $userid = $_GET['userid'];

    // Collect user details and initalise payment
    $user_email = get_post($userid)->user_email;
    $phone_number = get_post($userid)->phone_number;
    $full_name = get_post($userid)->first_name.' '.get_post($userid)->last_name;
    $coure_name = get_post($courseid)->course_name;
    
    // Generate transaction id
    $transaction_id = date('Ymd').date('his');

    $curl = curl_init();
    $customer_email = $user_email;
    $amount = get_post($courseid)->original_price;  
    $currency = "NGN";
    $txref = $transaction_id; // ensure you generate unique references per transaction.
    $PBFPubKey = "FLWPUBK-83ec6f7b5f0e9940db2fc2620f5452cc-X"; // get your public key from the dashboard.
    $redirect_url = site_url('/payment-complete');

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.flutterwave.com/v3/payments",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode([
            'tx_ref' => $transaction_id,
            'amount' => $amount,
            'currency' => 'NGN',
            'redirect_url' => $redirect_url,
            'payment_options' => [
                'card', 'ussd'
            ],
            'customer' => [
                'email' => $user_email,
                'phonenumber' => $phone_number,
                'name' => $full_name,
            ],
            'customizations' => [
                'title' => 'Devcamp Academy',
                'description' => 'You are paying for the '.$coure_name,
                'logo' => 'http://devcamp.live/wp-content/uploads/2021/08/letter-d.png',
            ],
        ]),
        CURLOPT_HTTPHEADER => [
            "content-type: application/json",
            "cache-control: no-cache",
            "Authorization: Bearer FLWSECK-35ee7173c13a09485a8a4d16be6a9c45-X",
        ],
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    if($err){
        // there was an error contacting the rave API
        die('Curl returned error: ' . $err);
    }

    $transaction = json_decode($response);

    if(!$transaction->data && !$transaction->data->link){
        // there was an error from the API
        print_r('API returned error: ' . $transaction->message);
    }else{
        // Create Transaction
        $transaction_post_id = wp_insert_post(
            array(
                'post_type' => 'student-transaction',
                'post_title' => $transaction_id,
                'post_content' => '',
                'post_status' => 'publish',
            )
        );
        
        // Save data
        update_post_meta($transaction_post_id,'transaction_id',$transaction_id);
        update_post_meta($transaction_post_id,'student_id',$userid);
        update_post_meta($transaction_post_id,'course_id',$courseid);
        update_post_meta($transaction_post_id,'cohort_id',$cohortid);
        update_post_meta($transaction_post_id,'amount', get_post($courseid)->original_price);
        update_post_meta($transaction_post_id,'admin_id',get_post($courseid)->course_admin);
    }

    // redirect to page so User can pay
    $url = $transaction->data->link;
?>
<div class="banner-section bg-main-1 text-center py-5 container-wrapper">
    <div class="card w-50 mx-auto shadow">
        <div class="card-body text-center">
            <p class="title txt-xlg mx-auto text-center">All Set!!!</p>
            <i class="fas txt-xlg mb-5 mt-3 txt-primary fa-grin"></i>
            <br>
            <p class="text txt-sm">Your secured payment transaction link has been created, click the button below to proceed to the payment page</p>
            <div class="mx-auto my-3">
                <a href="<?php echo $url?>" class="bg-main button txt-white txt-sm txt-bold text py-3 px-5">Continue to Pay</a>
            </div>
            <div class="py-5">
                <p class="title txt-primary txt-sm">Email: support@devcamp.live <br>Phone/Whatsapp: 08129100006</p>
            </div>
        </div>
    </div>
</div>
<?php echo get_footer();?>