<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('/layanan', 'LayananController::index');
$routes->get('pendaftaran-rehabilitasi', 'RehabilitasiController::registrationForm');
$routes->get('alur-rehabilitasi', 'RehabilitasiController::alurRehabilitasi');
$routes->get('alur-skhpn', 'SkhpnController::alurSkhpn');
$routes->get('alur-tat', 'TatController::alurTat');
$routes->post('pendaftaran-rehabilitasi', 'RehabilitasiController::register');
$routes->get('bacaan', 'Learning::index');
$routes->get('bacaan/cari', 'Learning::search');
$routes->get('bacaan/lebih-banyak', 'Learning::more');
$routes->get('profil', 'ProfilePage::index');
$routes->get('quiz', 'QuizController::index');
$routes->get('quiz/cari', 'QuizController::search');
$routes->get('quiz/lebih-banyak', 'QuizController::more');
$routes->get('quiz/(:num)', 'QuizController::show/$1');
$routes->post('quiz/(:num)/submit', 'QuizController::submit/$1');
$routes->get('quiz/(:num)/hasil/(:segment)', 'QuizController::result/$1/$2');
$routes->get('artikel', 'PublicArticleController::index');
$routes->get('artikel/lebih-banyak', 'PublicArticleController::more');
$routes->get('artikel/(:num)', 'PublicArticleController::show/$1');
$routes->get('artikel/(:num)/komentar-lainnya', 'PublicArticleController::moreComments/$1');
$routes->post('artikel/(:num)/komentar', 'PublicArticleController::comment/$1');
$routes->get('login', 'AuthController::loginForm');
$routes->post('login', 'AuthController::login');
$routes->post('logout', 'AuthController::logout', ['filter' => 'auth']);

// Dashboard — role-based routing di dalam controller
$routes->get('dashboard', 'DashboardController::index', ['filter' => 'auth']);

// Landing Page (Humas Umum)
$routes->get('dashboard/landing-page', 'HumasController::landingPage', ['filter' => 'auth']);
$routes->post('dashboard/landing-page/save', 'HumasController::saveLandingPage', ['filter' => 'auth']);
$routes->post('dashboard/landing-page/save-monthly-stats', 'HumasController::saveMonthlyStats', ['filter' => 'auth']);
$routes->get('api/monthly-stats', 'Home::monthlyStatsApi');
$routes->get('dashboard/landing-page/about/create', 'AboutSectionController::create', ['filter' => 'auth']);
$routes->post('dashboard/landing-page/about', 'AboutSectionController::store', ['filter' => 'auth']);
$routes->get('dashboard/landing-page/about/(:num)', 'AboutSectionController::edit/$1', ['filter' => 'auth']);
$routes->post('dashboard/landing-page/about/(:num)', 'AboutSectionController::update/$1', ['filter' => 'auth']);
$routes->post('dashboard/landing-page/about/(:num)/delete', 'AboutSectionController::delete/$1', ['filter' => 'auth']);

// Konten Rehabilitasi (Humas Rehabilitasi)
//$routes->get('dashboard/konten-rehabilitasi', 'HumasRehabilitasiController::kontenRehabilitasi', ['filter' => 'auth']);
//$routes->get('dashboard/registrasi-rehabilitasi', 'HumasRehabilitasiController::registrasiRehabilitasi', ['filter' => 'auth']);

// SCORM
$routes->get('scorm/launch/(:segment)', 'Scorm::launch/$1');
$routes->get('scorm/content/(:segment)/(.+)', 'Scorm::content/$1/$2');
$routes->get('scorm/manifest/(:segment)', 'Scorm::getManifest/$1');
$routes->post('scorm/save', 'Scorm::save');

$routes->get('dashboard/scorm', 'ScormController::index', ['filter' => 'auth']);
$routes->get('dashboard/scorm/create', 'ScormController::create', ['filter' => 'auth']);
$routes->post('dashboard/scorm/store', 'ScormController::store', ['filter' => 'auth']);
$routes->get('dashboard/scorm/edit/(:segment)', 'ScormController::edit/$1', ['filter' => 'auth']);
$routes->post('dashboard/scorm/update/(:segment)', 'ScormController::update/$1', ['filter' => 'auth']);
$routes->get('dashboard/scorm/publish/(:segment)', 'ScormController::publish/$1', ['filter' => 'auth']);
$routes->get('dashboard/scorm/unpublish/(:segment)', 'ScormController::unpublish/$1', ['filter' => 'auth']);
$routes->get('dashboard/scorm/toggle/(:segment)', 'ScormController::togglePublished/$1', ['filter' => 'auth']);
$routes->get('dashboard/scorm/delete/(:segment)', 'ScormController::delete/$1', ['filter' => 'auth']);

// Profil Akun (shared)
$routes->get('dashboard/profile', 'ProfileController::index', ['filter' => 'auth']);
$routes->post('dashboard/profile/update', 'ProfileController::update', ['filter' => 'auth']);

$routes->get('dashboard/articles', 'ArticleController::index', ['filter' => 'auth']);
$routes->get('dashboard/articles/create', 'ArticleController::create', ['filter' => 'auth']);
$routes->post('dashboard/articles', 'ArticleController::store', ['filter' => 'auth']);
$routes->get('dashboard/articles/edit/(:num)', 'ArticleController::edit/$1', ['filter' => 'auth']);
$routes->post('dashboard/articles/update/(:num)', 'ArticleController::update/$1', ['filter' => 'auth']);
$routes->post('dashboard/articles/delete/(:num)', 'ArticleController::delete/$1', ['filter' => 'auth']);

$routes->get('dashboard/quizzes', 'QuizAdminController::index', ['filter' => 'auth']);
$routes->get('dashboard/quizzes/create', 'QuizAdminController::create', ['filter' => 'auth']);
$routes->get('dashboard/quizzes/logs', 'QuizAdminController::logs', ['filter' => 'auth']);
$routes->post('dashboard/quizzes', 'QuizAdminController::store', ['filter' => 'auth']);
$routes->get('dashboard/quizzes/edit/(:num)', 'QuizAdminController::edit/$1', ['filter' => 'auth']);
$routes->post('dashboard/quizzes/update/(:num)', 'QuizAdminController::update/$1', ['filter' => 'auth']);
$routes->post('dashboard/quizzes/delete/(:num)', 'QuizAdminController::delete/$1', ['filter' => 'auth']);

// Quiz questions management
//$routes->get('dashboard/quizzes/(:num)/questions', 'QuizQuestionAdminController::index/$1', ['filter' => 'auth']);
//$routes->get('dashboard/quizzes/(:num)/questions/create', 'QuizQuestionAdminController::create/$1', ['filter' => 'auth']);
//$routes->post('dashboard/quizzes/(:num)/questions', 'QuizQuestionAdminController::store/$1', ['filter' => 'auth']);
//$routes->get('dashboard/quizzes/(:num)/questions/edit/(:num)', 'QuizQuestionAdminController::edit/$1/$2', ['filter' => 'auth']);
//$routes->post('dashboard/quizzes/(:num)/questions/update/(:num)', 'QuizQuestionAdminController::update/$1/$2', ['filter' => 'auth']);
//$routes->post('dashboard/quizzes/(:num)/questions/delete/(:num)', 'QuizQuestionAdminController::delete/$1/$2', ['filter' => 'auth']);
