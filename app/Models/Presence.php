<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // untuk menggunakan fitur factory pada model Presence
use Illuminate\Database\Eloquent\SoftDeletes; // untuk menggunakan fitur soft delete pada model Presence

class Presence extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'check_in',
        'check_out',
        'date',
        'status',
    ];

    // Relasi dengan model Employee (ORM adalah Object Relational Mapping)
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
