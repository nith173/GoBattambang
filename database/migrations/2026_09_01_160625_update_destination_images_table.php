<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('destination_images', function (Blueprint $table) {
            if (!Schema::hasColumn('destination_images', 'image_id') && Schema::hasColumn('destination_images', 'id')) {
                $table->renameColumn('id', 'image_id');
            }
            if (!Schema::hasColumn('destination_images', 'image_url') && Schema::hasColumn('destination_images', 'image_path')) {
                $table->renameColumn('image_path', 'image_url');
            }
            if (!Schema::hasColumn('destination_images', 'is_primary')) {
                $table->boolean('is_primary')->default(false);
            }
        });
    }

    public function down(): void
    {
        Schema::table('destination_images', function (Blueprint $table) {
            if (Schema::hasColumn('destination_images', 'image_id')) {
                $table->renameColumn('image_id', 'id');
            }
            if (Schema::hasColumn('destination_images', 'image_url')) {
                $table->renameColumn('image_url', 'image_path');
            }
            if (Schema::hasColumn('destination_images', 'is_primary')) {
                $table->dropColumn('is_primary');
            }
        });
    }
};
