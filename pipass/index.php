<?php
// This page should determine if the user is logged in or not.
// If the user is logged in, redirect them to manage. If not,
// redirect them to login.

session_start();

if($SESSION) {
    header("Location: manage");
} else {
    header("Location: login");
}
?>