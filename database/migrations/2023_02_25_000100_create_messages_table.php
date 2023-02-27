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
        Schema::create(SupportTickets::getMessagesTableName(), function (Blueprint $table) {
            $table->id();
            $table->text('body');
            $table->foreignId('user_id')->on(SupportTickets::getUsersConnectionExpression())
                ->nullable()
                ->nullOnDelete();
            $table->foreignId('ticket_id')
                ->constrained(SupportTickets::getTicketsTableName())
                ->cascadeOnDelete();
            $table->nestedSet();
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
        Schema::dropIfExists(SupportTickets::getMessagesTableName());
    }
};
