<?php
namespace App\Controllers;
use App\Core\BaseController;

class DashboardController extends BaseController {

    public function __construct() {
        $this->authenticate();
        $this->middlewareRol(['Director', 'Jefe de sala'], 'Dashboard');
    }

    public function index(): string {
        return $this->render('home/home');
    }
}