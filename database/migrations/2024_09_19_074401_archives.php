<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('archives_college', function (Blueprint $table) {
            $table->id(); // This is the primary key and auto increments
            $table->string('firstname', 25); // VARCHAR(25)
            $table->string('middleinitial', 25); // VARCHAR(25)
            $table->string('lastname', 25); // VARCHAR(25)
            $table->string('birthday', 25); // VARCHAR(25) (Could be changed to date type depending on your requirement)
            $table->string('email', 50); // VARCHAR(50)
            $table->integer('idnumber'); // INT(10)
            $table->string('courseyear', 25); // VARCHAR(25)
            $table->string('address', 25); // VARCHAR(25)
            $table->string('contactperson', 25); // VARCHAR(25)
            $table->string('contactnumber', 25); // INT(11) - unsigned by default
            $table->string('idpicture', 100)->nullable();; // LONGBLOB
            $table->string('signature', 100)->nullable();; // LONGBLOB
            $table->string('payment', 100)->nullable(); // MEDIUMBLOB
            $table->timestamps(); // Optional: adds `created_at` and `updated_at`
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archives');
    }
};
