<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class absengps extends Model
{
    use HasFactory;
    public $table ='absens';
    protected $guarded = ['id', 'timestamps'];
    public function hrd()
    {
        return $this->belongsTo(hrd::class);
    }
}
