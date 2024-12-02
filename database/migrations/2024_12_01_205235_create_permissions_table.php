<?php

declare(strict_types = 1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('model_permissions', function (Blueprint $table) {
            $table->string('model_id');
            $table->string('model_type');
            $table->foreignId('permission_id')->constrained()->onDelete('cascade');

            $table->primary(['model_id', 'model_type', 'permission_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('model_permissions');
        Schema::dropIfExists('permissions');
    }
};
