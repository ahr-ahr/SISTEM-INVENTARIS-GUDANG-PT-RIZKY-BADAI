<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class UserResource extends BaseApiResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'       => $this->int($this->id),
            'username' => $this->username,

            'role' => $this->whenLoaded('role', function () {
                return [
                    'id'   => $this->int($this->role->id),
                    'name' => $this->role->name,
                ];
            }),

            'employee' => $this->whenLoaded('employee', function () {
                return [
                    'id'   => $this->int($this->employee->id),
                    'nama' => $this->employee->nama_lengkap,
                ];
            }),

            'last_login_at' => $this->isoDate($this->last_login_at),
        ];
    }
}
