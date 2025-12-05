<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Seminar;
use App\Notifications\SeminarReminder;

class SendSeminarReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'guidance:send-reminders {--year= : Filter by year level}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email reminders to students who have not attended their required seminar.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $yearLevel = $this->option('year');

        $query = User::role('student');
        if ($yearLevel) {
            $query->where('year_level', $yearLevel);
        }

        $students = $query->get();
        $count = 0;

        $this->info('Checking ' . $students->count() . ' students...');

        foreach ($students as $student) {
            $requiredSeminarName = $this->getRequiredSeminarForYear($student->year_level);

            if (!$requiredSeminarName)
                continue;

            $attended = $student->seminarAttendances()
                ->where('seminar_name', $requiredSeminarName)
                ->exists();

            if (!$attended) {
                $this->info("Sending reminder to {$student->name} ({$student->email}) for missing {$requiredSeminarName}...");
                $student->notify(new SeminarReminder($requiredSeminarName));
                $count++;
            }
        }

        $this->info("Sent $count reminders.");
    }

    private function getRequiredSeminarForYear($year)
    {
        $map = [
            1 => 'IDREAMS',
            2 => '10C',
            3 => 'LEADS',
            4 => 'IMAGE'
        ];
        return $map[$year] ?? null;
    }
}
