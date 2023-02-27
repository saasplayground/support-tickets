<?php

namespace Saasplayground\SupportTickets\Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Saasplayground\SupportTickets\SupportTickets;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model = SupportTickets::getUsersModel();
        $messageModel = SupportTickets::getMessagesModel();
        $ticketModel = SupportTickets::getTicketsModel();
        $categoryModel = SupportTickets::getCategoriesModel();
        $labelModel = SupportTickets::getLabelsModel();

        $ticketModel::factory()
            ->for($model::factory())
            ->hasAttached(
                $labelModel::factory()->count(2), [], 'labels'
            )->has(
                $messageModel::factory()->count(2), 'messages'
            )->hasAttached(
                $categoryModel::factory(), [], 'categories'
            )
            ->count(10)
            ->create();
    }
}
