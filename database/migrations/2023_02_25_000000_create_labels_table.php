<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Saasplayground\SupportTickets\SupportTickets;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(SupportTickets::getLabelsTableName(), function (Blueprint $table) {
            $table->id();
            $table->string('name', 60);
            $table->string('slug', 140);
            $table->text('description')->nullable();
            $table->boolean('usable');
            $table->softDeletes();
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
        Schema::dropIfExists(SupportTickets::getLabelsTableName());
    }
};
