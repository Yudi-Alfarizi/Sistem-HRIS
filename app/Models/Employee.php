<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    // ORM Eloquent untuk model Task
    // Fitur HasFactory dan SoftDeletes untuk pembuatan data palsu dan penghapusan data secara soft delete
    use HasFactory, SoftDeletes;
    // Fields yang boleh diisi (mass assignable)
    protected $fillable = [
        'fullname',
        'email',
        'phone_number',
        'address',
        'birth_date',
        'hire_date',
        'department_id',
        'role_id',
        'status',
        'salary',
    ];

    // Menentukan relasi dengan model Department dan Role
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    
}
