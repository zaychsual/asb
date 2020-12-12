<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kabupaten extends Model
{
    use SoftDeletes;
    public $table = 'kabupatens';

    protected $fillable = [
        'id',
        'id_kab',
        'id_prov',
        'id_wilayah',
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

    public static function getKab($value)
    {
        return Kabupaten::where('id_kab', $value)->select('name')->first();
    }
}
