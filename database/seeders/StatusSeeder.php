<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->statusClient();
        $this->statusSC();
        $this->statusCoordinator();
        $this->statusConsultant();
    }

    public function statusClient()
    {
        Status::create([
            'element_type' => 'task',
            'status_type' => 'client',
            'name' => 'pending',
            'html_color' => '#FFC000',
            'is_default' => false,
        ]);

        Status::create([
            'element_type' => 'task',
            'status_type' => 'client',
            'name' => 'confirmed',
            'html_color' => '#70AD47',
            'is_default' => false,
        ]);

        Status::create([
            'element_type' => 'task',
            'status_type' => 'client',
            'name' => 'forecasted',
            'html_color' => '#4472C4',
            'is_default' => true,
        ]);

        Status::create([
            'element_type' => 'task',
            'status_type' => 'client',
            'name' => 'cancelled',
            'html_color' => '#FF0000',
            'is_default' => false,
        ]);

        Status::create([
            'element_type' => 'task',
            'status_type' => 'client',
            'name' => 'pre-forecast',
            'html_color' => '#FF0000',
            'is_default' => false,
        ]);

        Status::create([
            'element_type' => 'task',
            'status_type' => 'client',
            'name' => 'removed',
            'html_color' => '#FF0000',
            'is_default' => false,
        ]);
    }

    public function statusSC()
    {
        Status::create([
            'element_type' => 'task',
            'status_type' => 'senior_consultant',
            'name' => 'first_draft',
            'is_default' => false,
        ]);

        Status::create([
            'element_type' => 'task',
            'status_type' => 'senior_consultant',
            'name' => 'koff_scheduled',
            'is_default' => false,
        ]);

        Status::create([
            'element_type' => 'task',
            'status_type' => 'senior_consultant',
            'name' => 'koff_held',
            'is_default' => false,
        ]);

        Status::create([
            'element_type' => 'task',
            'status_type' => 'senior_consultant',
            'name' => 'highlights',
            'is_default' => false,
        ]);

        Status::create([
            'element_type' => 'task',
            'status_type' => 'senior_consultant',
            'name' => 'referees',
            'is_default' => false,
        ]);

        Status::create([
            'element_type' => 'task',
            'status_type' => 'senior_consultant',
            'name' => 'done',
            'is_default' => false,
        ]);
    }

    public function statusCoordinator()
    {
        Status::create([
            'element_type' => 'task',
            'status_type' => 'coordinator',
            'name' => 'research_started',
            'is_default' => false,
        ]);
    }

    public function statusConsultant()
    {
        Status::create([
            'element_type' => 'task',
            'status_type' => 'consultant',
            'name' => 'ko_sent',
            'description' => 'An email has been sent',
            'html_color' => '#FFC000',
            'is_default' => false,
            'order' => 10,
        ]);

        Status::create([
            'element_type' => 'task',
            'status_type' => 'consultant',
            'name' => 'ko_booked',
            'html_color' => '#7030A0',
            'is_default' => false,
            'order' => 20,

        ]);

        Status::create([
            'element_type' => 'task',
            'status_type' => 'consultant',
            'name' => 'ko_done',
            'html_color' => '#7030A0',
            'is_default' => false,
            'order' => 30,

        ]);

        Status::create([
            'element_type' => 'task',
            'status_type' => 'consultant',
            'name' => 'reminder_sent',
            'html_color' => '#FFC000',
            'is_default' => false,
            'order' => 40,

        ]);

        Status::create([
            'element_type' => 'task',
            'status_type' => 'consultant',
            'name' => 'all_hl_received',
            'description' => '(logged with date) IDEALLY this would offer a breakdown by contributing partners who could then be selected individually.',
            'html_color' => '#FF0000',
            'is_default' => false,
            'order' => 50,

        ]);

        Status::create([
            'element_type' => 'task',
            'status_type' => 'consultant',
            'name' => 'all_referees_received',
            'html_color' => '#FF0000',
            'is_default' => false,
            'order' => 60,

        ]);

        Status::create([
            'element_type' => 'task',
            'status_type' => 'consultant',
            'name' => 'all_data_received',
            'html_color' => '#7030A0',
            'is_default' => false,
            'order' => 70,

        ]);

        Status::create([
            'element_type' => 'task',
            'status_type' => 'consultant',
            'name' => 'draft_sent',
            'html_color' => '#FFC000',
            'is_default' => false,
            'order' => 80,

        ]);

        Status::create([
            'element_type' => 'task',
            'status_type' => 'consultant',
            'name' => 'referees_filed',
            'html_color' => '#3399FF',
            'is_default' => false,
            'order' => 90,

        ]);

        Status::create([
            'element_type' => 'task',
            'status_type' => 'consultant',
            'name' => 'submission_filed',
            'html_color' => '#3399FF',
            'is_default' => false,
            'order' => 100,

        ]);

        Status::create([
            'element_type' => 'task',
            'status_type' => 'consultant',
            'name' => 'conversions_requested',
            'html_color' => '#FFC000',
            'is_default' => false,
            'order' => 110,

        ]);

        Status::create([
            'element_type' => 'task',
            'status_type' => 'consultant',
            'name' => 'done',
            'html_color' => '#4472C4',
            'is_default' => false,
            'order' => 120,

        ]);
    }
}
