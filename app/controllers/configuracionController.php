<?php 
namespace App\Controllers;
use App\Core\BaseController;
class ConfiguracionController extends BaseController {
    public function __construct() {
        $this->authenticate();
    }

    public function index(): string {
        return $this->render('configuracion/configuracion');
    }

    public function salaConfiguration(): string {
        return $this->render('hall/hall');
    }

    public function areaConfiguration(): string {
        return $this->render('category/category');
    }

    public function historial(): string {
        return $this->render('history/history');
    }
    public function indicatorConfiguration(){
        return $this->render('indicator/indicator-configuration');
    }
}