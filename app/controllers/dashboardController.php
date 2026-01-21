<?php
namespace App\Controllers;
use App\Core\BaseController;

class DashboardController extends BaseController {

    public function index(): string {
        return $this->render('home/home');
    }
}