<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class BarangMasuk implements ShouldBroadcast
{
    use SerializesModels;

    public function __construct(
        public array $data
    ) {}

    /**
     * Channel yang di-listen React
     */
    public function broadcastOn(): Channel
    {
        return new Channel('barang');
    }

    /**
     * Nama event (HARUS cocok dengan React)
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
