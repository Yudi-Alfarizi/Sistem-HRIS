<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // untuk menggunakan fitur factory pada model Presence
use Illuminate\Database\Eloquent\SoftDeletes; // untuk menggunakan fitur soft delete pada model Presence

class Presence extends Model
{
    // ORM Eloquent untuk model Task
    // Fitur HasFactory dan SoftDeletes untuk pembuatan data palsu dan penghapusan data secara soft delete
    use HasFactory, SoftDeletes;
    // Fields yang boleh diisi (mass assignable)
    protected $fillable = [
        'employee_id',
        'check_in',
        'check_out',
        'date',
        'status',
        'latitude',
        'longitude',
    ];

    // Relasi dengan model Employee (ORM adalah Object Relational Mapping)
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
