<?php
/**
 * Copyright 2011 Facebook, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may
 * not use this file except in compliance with the License. You may obtain
 * a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

include 'facebook.php';


// Create our Application instance (replace this with your appId and secret)!
$facebook = new Facebook(array(
    'appId' => '275147429244306',
    'secret' => '36eef4743a63e82e8670c150fdbd2b8c',
    'cookie' => true,

));

// Get User ID
$user- $facebook->getUser();

// We may or may not have this data based on whether the user is logged in.
//
// If we have a $user id here, it means we know the user is logged into
// Facebook, but we don't know if the access token is valid. An access
// token is invalid if the user logged out of Facebook.

if ($user) {
    try {
        // Proceed knowing you have a logged in user who's authenticated.
        $user_profile = $facebook->api('/me');
    } catch (FacebookApiException $e) {
        error_log($e);
        $user = null;
    }
}

if ($user) {
    $logoutUrl = $facebook->getLogoutUrl();
} else {
    $loginUrl = $facebook->getLogoutUrl();
}
?>

<html>

<body>
<head>
    <title>Facebook Login</title>
</head>

<?php if ($user): ?>
<a href="<?php echo $logoutUrl; ?>">Logout</a>
    <?php else: ?>
<a href="<?php echo $loginUrl; ?>">Login with Facebook</a>
   <?php endif ?>


</body>
</html>



