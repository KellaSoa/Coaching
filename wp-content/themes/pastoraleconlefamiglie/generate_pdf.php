<?php
/* Template Name: generatepdf */
$informativa = get_field('info', $_GET['idCourse']);
$idCourse = $_GET['idCourse'];
$course = get_the_title($idCourse);
$typeCourse = UserInscription::Instance()->getTypeCourseByIdCourse($idCourse);
ob_start();
Pdf::Instance()->generatePdf($typeCourse, $course, $informativa);
ob_end_flush();
