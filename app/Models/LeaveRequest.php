<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeaveRequest extends Model
{
    // ORM Eloquent untuk model Task
    // Fitur HasFactory dan SoftDeletes untuk pembuatan data palsu dan penghapusan data secara soft delete
    use HasFactory, SoftDeletes;
    // Fields yang boleh diisi (mass assignable)
    protected $fillable = [
        'employee_id',
        'leave_type',
        'start_date',
        'end_date',
        'status',
    ];

    // foreign key relationship dengan Employee model 
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
