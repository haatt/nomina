<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();

            $table->string('code',30)->unique(true);
            $table->string('name', 50);
            $table->string('first_name', 60);
            $table->string('second_first_name', 60)->nullable(true)->comment('Sometimes exist just one name');
            $table->string('email', 50)->unique(true)->comment('An email can belongs just to one employee');
            $table->string('contract_type', 30)->nullable(true);
            $table->boolean('status')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
