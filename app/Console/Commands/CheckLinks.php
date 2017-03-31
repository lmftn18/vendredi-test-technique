<?php

namespace App\Console\Commands;

use App\Job;
use Illuminate\Console\Command;

class CheckLinks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vendredi:check-links';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks the pages pointed to by job urls have not changed since last time';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $jobs = Job::whereNotNull('url_fingerprint')->get();

        foreach ($jobs as $job) {
            $newFingerprint = $this->getFingerprintWithRetries($job->url);

            $hasFingerprintChanged = ($newFingerprint !== $job->url_fingerprint);
            if ($hasFingerprintChanged) {
                $job->url_fingerprint = null;
                $job->save();
            }
        }
        return true;
    }

    /**
     * Triy a few times to get the url fingerprint.
     *
     * @param $url
     *
     * @return null|string
     */
    private function getFingerprintWithRetries($url)
    {
        $tryCount = 0;
        $fingerprint = null;

        // try up to 3 times to get a non null hash
        while ($tryCount < 2 && !$fingerprint) {
            $fingerprint = \AppHelper::getUrlFingerprint($url);
            $tryCount++;
        }

        return $fingerprint;
    }
}
