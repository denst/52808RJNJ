<?php
    chdir();
    include_once 'classes/vacancies.php';
    $vacancies = new Vacancies();
//    $vacancies->send_notification('test', 'test');
//    $vacancies->check_advertisements(PUBLIC_TYPE);
    $vacancies->check_advertisements(PORTAL_TYPE);
?>