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
        Schema::create(SupportTickets::getTicketsTableName(), function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->uuid('uuid');
            $table->string('slug');
            $table->text('message');
            $table->foreignId('user_id')->on(SupportTickets::getUsersConnectionExpression())
                ->nullable()
                ->nullOnDelete();
            $table->foreignId('agent_id')->on(SupportTickets::getUsersConnectionExpression())
                ->nullable()
                ->nullOnDelete();
            $table->string('priority')->default('low');
            $table->string('source')->default('web');
            $table->string('status')->default(SupportTickets::defaultStatus());
            $table->timestamp('resolved_at')->nullable();
            $table->timestamp('locked_at')->nullable();
            $table->timestamp('archived_at')->nullable();
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
        Schema::dropIfExists(SupportTickets::getTicketsTableName());
    }
};
