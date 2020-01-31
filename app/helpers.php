<?php 

function gravatar_url($email){
    $email = md5($email);
    return "https://www.gravatar.com/avatar/{$email}?s=60&d=http://bit.ly/default_avatar";
}