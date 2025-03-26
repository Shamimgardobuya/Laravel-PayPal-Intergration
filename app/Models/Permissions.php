<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Permissions extends Model
{
    use HasFactory;

    protected $table = 'permissions';

    // public function toSearchableArray()
    // {
    
    //     $array = $this->toArray();
    
    //     return $array;


    // }

    public function roles() : BelongsToMany
    {
        return $this->belongsToMany(Roles::class, 'role_permissions', 'permission_id', 'role_id');
    }

}
