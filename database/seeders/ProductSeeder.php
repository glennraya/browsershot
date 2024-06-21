<?php

namespace Database\Seeders;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productNames = [
            'LaserGym Pro',
            'SolarWave Charger',
            'NanoBot Butler',
            'AquaGlide Hoverboard',
            'MindSync Headset',
            'PlasmaGrill BBQ',
            'QuantumScape VR',
            'EcoSphere Terrarium',
            'TimeWarp Watch',
            'MegaFusion Blender',
            'HyperPulse Speaker',
            'VirtualVista Glasses',
            'SkyFlare Drone',
            'FusionFuel Car',
            'NanoGrow Plant Kit',
            'DataSphere Globe',
            'InfiniteCoaster VR',
            'RoboChef KitchenBot',
            'SolarFlux Power Bank',
            'QuantumLeap Shoes',
            'CyberPulse Earbuds',
            'GalaxyLink Router',
            'BioArmor Suit',
            'MindMeld Helmet',
            'HydroFusion Shower',
            'BioTech Oasis',
            'AeroDash Backpack',
            'XenoCraft Spaceship',
            'TeleportPod Transporter',
            'BrainWave Amplifier',
            'LuxoGlide Chair',
            'MicroFleet Toy Set',
            'FusionCruiser Bike',
            'AeroJet Pack',
            'DreamSphere Pillow',
            'InfinityScreen TV',
            'LunaHike Boots',
            'AquaBot Aquarium',
            'QuantumZoom Camera',
            'MegaPixel Art Kit',
            'SolarFlare Oven',
            'VeloSwift Bicycle',
            'BioGlow Plant Lamp',
            'HyperSpeed Scooter',
            'NeuroPulse Monitor',
            'RoboMate Companion',
            'EcoHarvest Garden',
            'SpaceExplorer VR',
            'HoloChef KitchenBot',
            'DataFusion Globe',
            'AquaView Goggles',
            'NebulaSound System',
            'NanoCharge Cable',
            'MindMerge Headset',
            'FusionGrill BBQ',
            'StellarCraft Model',
            'LaserLink Router',
            'HyperDrive Car',
            'EcoWave Generator',
            'TimeSync Watch',
            'QuantumPod Speaker',
            'GalaxyGlide Hoverboard',
            'BioSphere Terrarium',
            'QuantumBlast Gaming',
            'SolarSprint Sneakers',
            'NanoHaven Home',
            'VirtualWave Glasses',
            'XenoSphere Globe',
            'AeroBlast Drone',
            'FusionTorch Flashlight',
            'CyberSphere VR',
            'RoboGuard Security',
            'MindRide Rollercoaster',
            'PlasmaJet Hovercraft',
            'QuantumChill Fridge',
            'NanoFlame Lighter',
            'BioRide Bike',
            'HydroLux Bathtub',
            'AeroDine Tableware',
            'DataVista Glasses',
            'SolarLink Charger',
            'TimeFlux Clock',
            'MegaFusion Generator',
            'NeuroSync Helmet',
            'EcoScape Terrarium',
            'SpaceCraft Simulator',
            'LunaLuxe Bed',
            'QuantumPulse Earbuds',
            'HyperHarbor Yacht',
            'RoboWave Surfboard',
            'MindSculptor Pen',
            'AquaZen Fountain',
            'NanoTrek Hiking Gear',
            'StellarSync Telescope',
            'SolarMatrix Panel',
            'BioFusion Lab',
            'QuantumShift Shoes',
            'LaserPulse Laser',
            'TeleportWave Gateway',
            'InfinityPulse Speaker',
            'DreamVoyage Cruise',
            'EcoHaven Cabin',
            'DataSphere Atlas',
            'HydroGlide Surfboard',
            'HyperView Glasses',
            'RoboTrek Backpack',
            'MindMeld Music Player',
            'AeroDroid Drone',
            'SolarBlast BBQ',
            'BioHarbor Marina',
        ];

        foreach ($productNames as $product) {
            // Select a random product category
            // and add the product to the db.
            Product::create([
                'name' => $product,
                'price' => fake()->randomFloat(2, 50, 1300),
                'quantity' => fake()->numberBetween(10, 100),
                'is_expired' => fake()->randomElement([1, 0]),
                'created_at' => Carbon::now()->subDays(rand(0, 1095)),
                'updated_at' => Carbon::now()->subDays(rand(0, 1095)),
            ]);
        }
    }
}