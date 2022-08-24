<?php

namespace App\Jobs;

use App\Models\Package;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class PackageProcessJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public $user;
    public $package;

    public function __construct($user, $package)
    {
        $this->user = $user;
        $this->package = $package;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        DB::beginTransaction();
        try {
            if (Package::where('tracking_code', $this->package['tracking_code'])
                ->where('user_id', $this->user->id)
                ->doesntExist()) {
                 $package =  $this->user->packages()->create($this->package);
                 SendUserMailJob::dispatch($package)->delay(now()->addSeconds(3));
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            info($e->getMessage());
        }
    }
}
