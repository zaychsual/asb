<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Provinsi extends Model
{
    use SoftDeletes;
    public $table = 'provinsis';

    protected $fillable = [
        'id',
        'id_prov',
        'name',
        'deleted_at',
        'created_at',
        'updated_at',
        'status',
        'zona_waktu',
        'created_by',
        'updated_by',
    ];

    public const Active = 1;
    public const NotActive = 0;
    public const TypeStatus = [
        0 => 'Not Active',
        1 => 'Active'
    ];
    
    public static function getProv($value)
    {
        return Provinsi::where('id_prov', $value)->select('name')->first();
    }
}
