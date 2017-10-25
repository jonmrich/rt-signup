<?php
// This is a sample PHP script that demonstrates accepting a POST from the        
// Unbounce form submission webhook, and then sending an email notification.      
function stripslashes_deep($value) {
  $value = is_array($value) ?
    array_map('stripslashes_deep', $value) :
    stripslashes($value);
  return $value;
}
// First, grab the form data.  Some things to note:                               
// 1.  PHP replaces the '.' in 'data.json' with an underscore.                    
// 2.  Your fields names will appear in the JSON data in all lower-case,          
//     with underscores for spaces.                                               
// 3.  We need to handle the case where PHP's 'magic_quotes_gpc' option           
//     is enabled and automatically escapes quotation marks.                      
if (get_magic_quotes_gpc()) {
  $unescaped_post_data = stripslashes_deep($_POST);
} else {
  $unescaped_post_data = $_POST;
}
$form_data = json_decode($unescaped_post_data['data_json']);
var_dump($form_data);
// If your form data has an 'Email Address' field, here's how you extract it:     
$email_address = $form_data->email[0];
$password = $form_data->password[0];
$password_confirm = $form_data->password_confirm[0];
$username = $email_address;
                                             

$headers   = array();
$headers[] = 'Accept: application/json';
$headers[] = 'Content-Type: application/json';

$objectArray = array(
    'email'              => $email_address,
    'username'            => $email_address,
    'password'                   => $password,
    'password_confirmation'         => $password_confirm,
);
$data3     = array('user' => $objectArray);
$data_json = json_encode($data3);

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://roadtrippers.com/api/v1/users',
    CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST  => 'POST',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER     => $headers,
    CURLOPT_POSTFIELDS     => $data_json,
));

$response = curl_exec($curl);

$err      = curl_error($curl);

curl_close($curl);
die();                                           

?>
