<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // CCTV Camera fields
            $table->string('resolution')->nullable();
            $table->enum('night_vision', ['yes', 'no'])->nullable();
            $table->enum('weatherproof', ['indoor', 'outdoor', 'both'])->nullable();
            $table->string('power_supply')->nullable();
            $table->string('viewing_angle')->nullable();
            $table->string('storage_type')->nullable();
            
            // Charger fields
            $table->string('output_voltage')->nullable();
            $table->string('output_current')->nullable();
            $table->string('connector_type')->nullable();
            $table->string('compatible_brands')->nullable();
            
            // Hard Disk fields
            $table->string('capacity')->nullable();
            $table->enum('disk_type', ['hdd', 'ssd', 'nvme'])->nullable();
            $table->string('interface')->nullable();
            $table->string('speed')->nullable();
            
            // WiFi Router fields
            $table->string('wifi_standard')->nullable();
            $table->string('wifi_speed')->nullable();
            $table->string('coverage')->nullable();
            $table->string('antennas')->nullable();
            
            // Accessories fields
            $table->string('material')->nullable();
            $table->string('size')->nullable();
            $table->string('color')->nullable();
            $table->string('compatibility')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // CCTV Camera fields
            $table->dropColumn([
                'resolution', 'night_vision', 'weatherproof', 'power_supply', 
                'viewing_angle', 'storage_type'
            ]);
            
            // Charger fields
            $table->dropColumn([
                'output_voltage', 'output_current', 'connector_type', 'compatible_brands'
            ]);
            
            // Hard Disk fields
            $table->dropColumn([
                'capacity', 'disk_type', 'interface', 'speed'
            ]);
            
            // WiFi Router fields
            $table->dropColumn([
                'wifi_standard', 'wifi_speed', 'coverage', 'antennas'
            ]);
            
            // Accessories fields
            $table->dropColumn([
                'material', 'size', 'color', 'compatibility'
            ]);
        });
    }
};
