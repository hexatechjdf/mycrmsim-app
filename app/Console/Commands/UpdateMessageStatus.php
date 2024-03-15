<?php

namespace App\Console\Commands;

use GHL\Api;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdateMessageStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ghl:update-message-status {--workspaceId=} {--messageId=} {--status=} {--error=null}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update message status';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $workspaceId = $this->option("workspaceId");
        $messageId = $this->option("messageId");
        $status = $this->option("status");
        $error = $this->option("error");
        if($error)
            $error = [
                "code" => 1,
                "message" => $error
            ];


        Api::updateMessageStatus($workspaceId, $messageId, $status, $error);
    }
}
