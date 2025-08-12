<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KasModel extends Model
{
    // Definisikan tabel yang digunakan oleh model ini
    protected $table = 'kas_pusat';

    // Definisikan primary key
    protected $primaryKey = 'id';

    // Jika primary key bukan integer, tambahkan ini
    // protected $keyType = 'string';

    // Jika tabel tidak memiliki kolom timestamps, tambahkan ini
    public $timestamps = false;

    // Definisikan fillable attributes
    protected $fillable = [
        'tgl',
        'no_perkiraan',
        'keterangan',
        'kredit',
        'saldo',
        'bank_sumber',
        'bank_tujuan',
        'jenis',
    ];
}