<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class WarehouseSeeder extends Seeder
{
    public function run(): void
    {
        $warehouseClass = 'Modules\Core\Models\Warehouse';
        if (!class_exists($warehouseClass)) {
            $this->command->warn('Core module not found. Skipping WarehouseSeeder.');
            return;
        }

        // Create main warehouse in Ramallah
        $mainWarehouse = $warehouseClass::create([
            'code' => 'WH-RAM-MAIN',
            'name' => 'المستودع الرئيسي - رام الله',
            'name_en' => 'Main Warehouse - Ramallah',
            'address' => 'شارع القدس، رام الله',
            'city' => 'رام الله',
            'country' => 'PS',
            'latitude' => 31.9522,
            'longitude' => 35.2332,
            'phone' => '+972 2 123 4567',
            'email' => 'warehouse.ramallah@jenincare.com',
            'manager_name' => 'أحمد محمد',
            'type' => 'main',
            'is_active' => true,
            'capacity' => 10000,
            'operating_hours' => [
                'sunday' => ['8:00', '20:00'],
                'monday' => ['8:00', '20:00'],
                'tuesday' => ['8:00', '20:00'],
                'wednesday' => ['8:00', '20:00'],
                'thursday' => ['8:00', '20:00'],
                'friday' => ['closed'],
                'saturday' => ['9:00', '16:00']
            ],
            'settings' => [
                'auto_reorder' => true,
                'priority_shipping' => true,
                'temperature_controlled' => true
            ]
        ]);

        // Create branch warehouse in Gaza
        $gazaWarehouse = $warehouseClass::create([
            'code' => 'WH-GAZ-001',
            'name' => 'فرع غزة',
            'name_en' => 'Gaza Branch',
            'address' => 'شارع عمر المختار، غزة',
            'city' => 'غزة',
            'country' => 'PS',
            'latitude' => 31.3885,
            'longitude' => 34.3446,
            'phone' => '+972 8 234 5678',
            'email' => 'warehouse.gaza@jenincare.com',
            'manager_name' => 'فاطمة أحمد',
            'type' => 'branch',
            'is_active' => true,
            'capacity' => 5000,
            'operating_hours' => [
                'sunday' => ['9:00', '18:00'],
                'monday' => ['9:00', '18:00'],
                'tuesday' => ['9:00', '18:00'],
                'wednesday' => ['9:00', '18:00'],
                'thursday' => ['9:00', '18:00'],
                'friday' => ['closed'],
                'saturday' => ['10:00', '15:00']
            ],
            'settings' => [
                'auto_reorder' => false,
                'priority_shipping' => false,
                'temperature_controlled' => true
            ]
        ]);

        // Create pickup point in Nablus
        $nablusWarehouse = $warehouseClass::create([
            'code' => 'WH-NAB-PICKUP',
            'name' => 'نقطة استلام نابلس',
            'name_en' => 'Nablus Pickup Point',
            'address' => 'شارع رفيديا، نابلس',
            'city' => 'نابلس',
            'country' => 'PS',
            'latitude' => 32.2133,
            'longitude' => 35.2848,
            'phone' => '+972 9 345 6789',
            'email' => 'pickup.nablus@jenincare.com',
            'manager_name' => 'محمد علي',
            'type' => 'pickup',
            'is_active' => true,
            'capacity' => 1000,
            'operating_hours' => [
                'sunday' => ['10:00', '19:00'],
                'monday' => ['10:00', '19:00'],
                'tuesday' => ['10:00', '19:00'],
                'wednesday' => ['10:00', '19:00'],
                'thursday' => ['10:00', '19:00'],
                'friday' => ['closed'],
                'saturday' => ['11:00', '16:00']
            ],
            'settings' => [
                'auto_reorder' => false,
                'priority_shipping' => false,
                'temperature_controlled' => false
            ]
        ]);

        // Create virtual warehouse for online orders
        $virtualWarehouse = $warehouseClass::create([
            'code' => 'WH-VIRT-ONLINE',
            'name' => 'المستودع الافتراضي',
            'name_en' => 'Virtual Warehouse',
            'address' => 'متجر إلكتروني',
            'city' => 'رام الله',
            'country' => 'PS',
            'phone' => '+972 2 987 6543',
            'email' => 'online@jenincare.com',
            'manager_name' => 'نظام إدارة',
            'type' => 'virtual',
            'is_active' => true,
            'capacity' => null,
            'operating_hours' => [
                'sunday' => ['00:00', '23:59'],
                'monday' => ['00:00', '23:59'],
                'tuesday' => ['00:00', '23:59'],
                'wednesday' => ['00:00', '23:59'],
                'thursday' => ['00:00', '23:59'],
                'friday' => ['00:00', '23:59'],
                'saturday' => ['00:00', '23:59']
            ],
            'settings' => [
                'auto_reorder' => true,
                'priority_shipping' => true,
                'temperature_controlled' => false
            ]
        ]);

        $this->command->info('Warehouses created successfully!');
        $this->command->info('Main Warehouse: ' . $mainWarehouse->name);
        $this->command->info('Gaza Warehouse: ' . $gazaWarehouse->name);
        $this->command->info('Nablus Pickup: ' . $nablusWarehouse->name);
        $this->command->info('Virtual Warehouse: ' . $virtualWarehouse->name);
    }
}
