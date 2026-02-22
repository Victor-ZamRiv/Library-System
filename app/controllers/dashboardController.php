<?php
namespace App\Controllers;
use App\Core\BaseController;

class DashboardController extends BaseController {

    public function __construct() {
        $this->authenticate();
    }

    public function index(): string {
        return $this->render('home/home');
    }
}