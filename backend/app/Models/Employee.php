<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'nip',
        'nama_lengkap',
        'jabatan',
        'departemen',
        'no_hp',
        'alamat',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
