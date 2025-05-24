<?php

namespace App\Console\Commands;

use App\Models\Attachment;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CleanupDeletedFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cleanup-deleted-files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $deleted_files = Attachment::onlyTrashed()->get(['path']);
            $paths = $deleted_files->pluck('path')->all();
            Storage::delete($paths);
            $this->comment('Deleted all unlinked attachments');
        } catch (Exception $e) {
            logger()->error($e->getMessage());
            $this->comment('Unable to delete attachment(s)');
        }

        return Command::SUCCESS;
    }
}
