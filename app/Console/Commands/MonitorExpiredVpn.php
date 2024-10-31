<?php

namespace App\Console\Commands;

use App\Mail\MonitorVpnMail;
use App\Models\Vpn;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class MonitorExpiredVpn extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:monitor-expired-vpn';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Melakukan Monitor Expired VPN';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $vpns = Vpn::query()
            ->with(['server', 'user'])
            ->where('is_active', 1)
            ->where('expired', '<=', date('Y-m-d'))
            ->get()
            ->groupBy('user_id');
        try {
            foreach ($vpns as $data) {
                foreach ($data as $key => $item) {
                    $item->update([
                        'is_active'                 => 0,
                        'last_send_notification'    => date('Y-m-d H:i:s'),
                    ]);
                }
                $to = $data->first()->user->email;
                if (empty($to)) {
                    throw new Exception('Error : MAIL_BACKUP_NOTIFICATION_ADDRESS !');
                }
                Mail::to($to)->queue(new MonitorVpnMail($data->toArray()));
            }
            $this->info('Monitor Sukses');
            return Command::SUCCESS;
        } catch (\Throwable $th) {
            $this->error('Monitor Gagal : ' . $th->getMessage());
            return Command::FAILURE;
        }
    }
}
