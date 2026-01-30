<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class BarangMasuk implements ShouldBroadcastNow
{
    use SerializesModels;

    public function __construct(public array $data)
    {
        Log::info('EVENT BarangMasuk CREATED', $data);
    }

    /**
     * Channel publik yang didengarkan React
     */
    public function broadcastOn(): Channel
    {
        return new Channel('barang');
    }

    /**
     * Nama event (harus cocok dengan .listen())
     */
    public function broadcastAs(): string
    {
        return 'BarangMasuk';
    }

    /**
     * Payload ke frontend
     */
    public function broadcastWith(): array
    {
        return $this->data;
    }
}
