<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kecamatan extends Model
{
    use softDeletes;
    public $table = 'kecamatans';

    protected $fillable = [
        'id',
        'id_kec',
        'id_kab',
        'name',
        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const Active = 1;
    public const NotActive = 0;
    public const TypeStatus = [
        0 => 'Not Active',
        1 => 'Active'
    ];
    
    public static function getKec($value)
    {
        return Kecamatan::where('id_kec', $value)->select('name')->first();
    }
}
