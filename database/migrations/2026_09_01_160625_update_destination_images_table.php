<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('destination_images', function (Blueprint $table) {
            $table->renameColumn('id', 'image_id');
            $table->renameColumn('image_path', 'image_url');
            $table->boolean('is_primary')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('destination_images', function (Blueprint $table) {
            $table->renameColumn('image_id', 'id');
            $table->renameColumn('image_url', 'image_path');
            $table->dropColumn('is_primary');
        });
    }
};
