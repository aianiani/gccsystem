<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SessionNote;
use Carbon\Carbon;

class UpdateSessionStatuses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sessions:update-statuses';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update existing session notes with correct status based on next_session dates';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Updating session statuses...');
        
        $now = Carbon::now();
        $updatedCount = 0;
        
        $sessionNotes = SessionNote::whereNotNull('next_session')->get();
        
        $this->info("Found {$sessionNotes->count()} session notes with next_session dates.");
        
        if ($sessionNotes->count() === 0) {
            $allNotes = SessionNote::all();
            $this->info("Total session notes in database: {$allNotes->count()}");
            
            if ($allNotes->count() > 0) {
                $this->info("Sample session note:");
                $note = $allNotes->first();
                $this->info("ID: {$note->id}, Next Session: " . ($note->next_session ? $note->next_session : 'NULL') . ", Status: {$note->session_status}");
            }
            return 0;
        }
        
        foreach ($sessionNotes as $sessionNote) {
            $nextSessionDate = Carbon::parse($sessionNote->next_session);
            $hoursDiff = $nextSessionDate->diffInHours($now);
            
            $oldStatus = $sessionNote->session_status;
            $newStatus = null;
            
            if ($nextSessionDate->isPast()) {
                if ($hoursDiff > 24) {
                    $newStatus = SessionNote::STATUS_EXPIRED;
                } else {
                    $newStatus = SessionNote::STATUS_MISSED;
                }
            } else {
                $newStatus = SessionNote::STATUS_SCHEDULED;
            }
            
            $this->info("Session Note ID {$sessionNote->id}: Next Session = {$sessionNote->next_session}, Current Status = {$oldStatus}, New Status = {$newStatus}");
            
            if ($oldStatus !== $newStatus) {
                $sessionNote->update(['session_status' => $newStatus]);
                $this->info("Updated Session Note ID {$sessionNote->id}: {$oldStatus} -> {$newStatus}");
                $updatedCount++;
            }
        }
        
        $this->info("Updated {$updatedCount} session notes.");
        $this->info('Session status update completed!');
        
        return 0;
    }
}
