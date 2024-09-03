<?php

require_once __DIR__ . '../../autoload.php'; 
use Models\Users;

$Users = new Users();

// $userData = [
//     'name' => 'Lucas Rios',
//     'email' => 'l@a',
//     'username' => 'lucasrios',
//     'password' => password_hash('1', PASSWORD_DEFAULT),
//     'profile_picture' => 'https://example.com/profile/johndoe.jpg',
//     'date_of_birth' => strtotime('1990-01-01'),
//     'phone_number' => '+1234567890',
//     'status' => 'active',
//     'last_login' => time(),
//     'email_verified' => false,
//     'group_id' => 1,
//     'created_at' => time(),
//     'updated_at' => time(),
// ];

// print_r($Users->createUser($userData));


$Login = $Users->loginUser('l@a', '1');

print_r($Login);
