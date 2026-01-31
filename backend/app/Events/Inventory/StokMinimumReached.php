<?php

namespace App\Events\Inventory;

use App\Models\Inventory\Barang;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class StokMinimumReached implements ShouldBroadcast
{
    public function __construct(
        public Barang $barang
    ) {}

    public function broadcastOn(): Channel
    {
        return new Channel('inventory.alert');
    }

    public function broadcastAs(): string
    {
        return 'stok.minimum';
    }
}

?>