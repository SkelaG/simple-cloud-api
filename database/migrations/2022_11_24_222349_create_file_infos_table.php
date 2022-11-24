<?php

use App\Enums\FileInfoType;
use App\Models\FileInfo;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('file_infos', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignIdFor(User::class);
            $table->foreignIdFor(FileInfo::class)->nullable();
            $table->enum('type', FileInfoType::toValuesArray());
            $table->string('path')->nullable();
            $table->string('name');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('file_infos');
    }
};
