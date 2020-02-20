<?php
session_start();

ini_set('display_errors', 1);

header('Content-Type: text/html; charset=utf-8');

// Запускаем роутинг
require_once 'application/bootstrap.php';