<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;

class phr_categoryAttributes extends Model
{ 

    use HasFactory;

    protected $primaryKey = 'categoryAtt_id';

    public $incrementing = false;
    protected $keyType = 'string';


    protected $fillable = [
        'categoryAtt_id',
        'categoryAtt_name',
        'categoryAtt_dataType',
        'formCat_id',

    ];

    public function formCategory(): HasOneOrMany
    {
        return $this->hasOne(phr_formCategories::class, 'foreign_key', 'formCat_id');
    }
}
