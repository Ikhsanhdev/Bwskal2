<?php

namespace App\Console\Commands;

use App\Services\InstagramService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class MedsosFeedRefresh extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'feed:refresh {target}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh media social feed';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(InstagramService $igService)
    {
        switch ($this->argument('target')) {
            case "ig":
                try {
                    //  Get Profile
                    $this->info('Mengambil data profile');
                    $profile = $igService->getProfile();
                    
                    //  Get Media
                    $this->info('Mengambil data media');
                    $media = $igService->getMedia();
                    
                    //  Refresh template
                    $this->info('mengupdate feed');
                    $igService->updateFeedTemplate([
                        'profile' => $profile,
                        'media' => $media,
                    ]);
                } catch (\Throwable $th) {
                    return $this->error('Gagal refresh ig feed: ' . $th->getMessage());
                }

                $this->info('Success refresh ig feed');
                break;
            default:
                $this->error("Target tidak disupport " . $this->argument('target'));
            break;
        }
    }
}
