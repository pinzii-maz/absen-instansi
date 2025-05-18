<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Divisi extends Model
{
    use HasFactory;

    protected $table = 'divisi';

    protected $fillable = ['name','parent_id'];

    public function parent() {
        return $this->belongsTo(Divisi::class, 'parent_id');
    }

    public function children() {
        return $this->hasMany(Divisi::class, 'parent_id');
    }

    public function users() {
        return $this->hasMany(User::class);
    }
}
