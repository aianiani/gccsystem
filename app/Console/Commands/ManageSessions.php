<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\SessionManagementService;

class ManageSessions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sessions:manage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manage session statuses, send notifications, and handle session lifecycle';

    /**
     * Execute the console command.
     */
    public function handle(SessionManagementService $sessionService)
    {
        $this->info('Starting session management tasks...');
        
        try {
            $sessionService->runSessionManagementTasks();
            $this->info('Session management tasks completed successfully!');
        } catch (\Exception $e) {
            $this->error('Error running session management tasks: ' . $e->getMessage());
            return 1;
        }
        
        return 0;
    }
}
