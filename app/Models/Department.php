<?php
/*
* Department
* Manage department
* @author : Natthanan Sirisurayut 66160352
* @Create Date : 2025-03-30
*/
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $table = 'wrs_departments'; // Specify the table name
    protected $primaryKey = 'dept_id';
    public $timestamps = false;
    protected $fillable = [
        'dept_name',
        'dept_created_date',
        'dept_update_date',
    ];
}
