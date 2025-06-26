<?php
namespace Database\Seeders;
use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    public function run()
    {
        $statuses = ['To Do', 'In Progress', 'Done'];
        foreach ($statuses as $status) {
            Status::create(['name' => $status]);
        }
    }
}
