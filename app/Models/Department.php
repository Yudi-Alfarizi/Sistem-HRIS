<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    // ORM Eloquent untuk model Task
    // Fitur HasFactory dan SoftDeletes untuk pembuatan data palsu dan penghapusan data secara soft delete
    use HasFactory, SoftDeletes;

    // Fields yang boleh diisi (mass assignable)
    protected $fillable = [
        'name',
        'description',
        'status',
    ];

}
