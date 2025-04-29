<?php

namespace Database\Seeders;

use App\Models\ServiceRequest;
use App\Models\User;
use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceRequestsTableSeeder extends Seeder
{

    public function run(): void
    {
        $clientsCount = User::where('role', 'client')->count();
        $professionalsCount = User::where('role', 'professional')->count();
        $servicesCount = Service::count();
        
        if ($clientsCount === 0 || $professionalsCount === 0 || $servicesCount === 0) {
            $this->command->info('Vous devez avoir des clients, des professionnels et des services avant de générer des demandes de service.');
            return;
        }
        
        ServiceRequest::factory(30)->create();
        
        ServiceRequest::factory(15)->completed()->create();
    }
}
