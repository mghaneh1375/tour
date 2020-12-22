<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendUpdateJavaRequest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $updateId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($updateId) {
        $this->updateId = $updateId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(){

        $ch = curl_init();

        $p = array(
            'updateId' => $this->updateId
        );

        curl_setopt($ch, CURLOPT_URL, getenv("java_url") . "/updateInnerFlight");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        $payload = json_encode( $p );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);
        curl_close ($ch);

        $tmp = \GuzzleHttp\json_decode($server_output);
        foreach ($tmp as $key => $value) {
            if($key == "progress") {
                if($value != -1 && $value < 98) {
                    $this->dispatch(new SendUpdateJavaRequest($this->updateId))->onQueue('updateId:' . $this->updateId . 'progress:' . $value);
                }
            }
        }
    }
}
