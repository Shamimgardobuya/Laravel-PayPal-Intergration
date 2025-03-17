<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Laravel\Scout\Searchable;

class StaffModel extends Model
{
    use HasFactory, Searchable;
    protected $table = 'staff';
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'role',
        'phone',
        'image_path'
    ];

    protected $appends = ['image'];

    protected $primaryKey = 'staff_id';

    public function shouldBeSearchable()//required if using searchable trait 
    {
    
        
    
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'staff_id' => $this->staff_id
        ];


    }

    public function getImageAttribute() 
    {
        if ($this->image_path) {
            return URL::to(env('APP_URL').'/'.$this->image_path);
            
        }
        return null;
    }
}
