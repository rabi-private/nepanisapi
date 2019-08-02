<?php
namespace App\Models\testing;
use Illuminate\Database\Eloquent\Model;
class test extends Model
{
    protected $table = 'first';
    /*
    protected $fillable = [
        'name',
        'label',
        'data_type',
        'default_value',
        'description',
        'display_order',
        'is_private',
    ];
    protected $fillableTranslation = [
        'label',
    ];
    public function opts()
    {
        return $this->hasMany('App\Models\AttrOpt', 'attr_id', 'id');
    }
    */
}