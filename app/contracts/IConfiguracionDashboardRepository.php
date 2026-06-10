<?php 
namespace App\Contracts;

use App\Models\Entities\ConfiguracionDashboard;

interface IConfiguracionDashboardRepository
{
    public function get(): ConfiguracionDashboard;
    public function save(ConfiguracionDashboard $config): bool;
}