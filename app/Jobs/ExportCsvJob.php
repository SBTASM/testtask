<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ExportCsvJob implements ShouldQueue
{
    const CHUNK_SIZE = 8192;

    protected $path;
    public function __construct($path)
    {
        $this->path = $path;
    }

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $handle = fopen(Storage::path($this->path), 'w');

        fputcsv($handle, [
            'id',
            'email',
            'firstname',
            'lastname',
            'age',
            'country',
            'city',
            'date'
        ]);

        DB::table('user_info')
            ->orderBy('id')
            ->chunk(self::CHUNK_SIZE, function ($users) use ($handle) {
            foreach ($users as $user) {
                fputcsv($handle, [
                    $user->id,
                    $user->email,
                    $user->firstname,
                    $user->lastname,
                    $user->age,
                    $user->country,
                    $user->city,
                    $user->date,
                ]);
            }
        });

        fclose($handle);
    }
}
