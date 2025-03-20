<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Permissions;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;



class Roles extends Model
{
    use HasFactory;
    protected $table = 'roles';

    public function permissions() : BelongsToMany
    {
        return $this->belongsToMany(Permissions::class, 'role_permissions', 'role_id', 'permission_id');
    }

}
