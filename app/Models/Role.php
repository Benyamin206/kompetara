<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles'; // opsional, kalau nama tabel sesuai boleh dihapus

    protected $fillable = [
        'nama_role',
    ];

    /**
     * Relasi ke User (1 Role punya banyak User)
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}