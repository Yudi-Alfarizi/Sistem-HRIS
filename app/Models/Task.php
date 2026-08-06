<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    // ORM Eloquent untuk model Task
    // Fitur HasFactory dan SoftDeletes untuk pembuatan data palsu dan penghapusan data secara soft delete
    use HasFactory, SoftDeletes;
    // Fields yang boleh diisi (mass assignable)
    protected $fillable = [
        'title',
        'description',
        'assigned_to',
        'due_date',
        'status',
    ];

    // Relasi dengan model Employee
    public function employee()
    {
        // Relasi dengan model Employee menggunakan foreign key 'assigned_to' dan data yang dihapus secara soft delete tetap bisa diakses
        return $this->belongsTo(Employee::class, 'assigned_to')->withTrashed();;
    }
}
