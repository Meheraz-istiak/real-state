<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectitemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projectitems', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects'); // Assuming 'projects' is the name of your projects table
            $table->string('name', 50);
            $table->integer('item_type');
            $table->string('item_position', 50)->nullable();
            $table->string('item_side', 50)->nullable();
            $table->double('price')->default(0);
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
        Schema::dropIfExists('projectitems');
    }
}
