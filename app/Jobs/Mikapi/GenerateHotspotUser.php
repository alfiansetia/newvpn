<?php

namespace App\Jobs\Mikapi;

use App\Services\Mikapi\Hotspot\UserServices;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;

class GenerateHotspotUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    public $request;
    public $user_id;

    /**
     * Create a new job instance.
     */
    public function __construct($request, $user_id)
    {
        $this->request = $request;
        $this->user_id = $user_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // $request = $this->request;
        $request = new Request($this->request);
        UserServices::routerId($request->router, $this->user_id)->generate($request);
    }
}
