<?php

namespace App\Console\Commands;

use App\Connectors\AirTable;
use App\Mission;
use Illuminate\Console\Command;

class UnpublishOldMission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vendredi:unpublish-old-missions {--a|age=90}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Unpublish missions that have been last published more than 90 days ago.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $age = $this->option('age');
        $missions = Mission::where('published_at', '<', \DB::raw("(NOW() - INTERVAL '${age} days')"))
            ->get()
        ;

        foreach ($missions as $mission) {
            $mission->is_published = false;
            $mission->save();
        }
        return true;
    }
}
