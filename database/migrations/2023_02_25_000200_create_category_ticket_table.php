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
        Schema::create(SupportTickets::getTicketsCategoryTableName(), function (Blueprint $table) {
            $table->foreignId('category_id')
                ->constrained(SupportTickets::getCategoriesTableName())
                ->cascadeOnDelete();
            $table->foreignId('ticket_id')
                ->constrained(SupportTickets::getTicketsTableName())
                ->cascadeOnDelete();
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
        Schema::dropIfExists(SupportTickets::getTicketsCategoryTableName());
    }
};
