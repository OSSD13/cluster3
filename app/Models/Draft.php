<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Draft extends Model
{
    use HasFactory;

    protected $table = 'drafts';
    protected $primaryKey = 'draft_id';

    // ความสัมพันธ์กลับไปยัง WorkRequest
    public function workRequest()
    {
        return $this->belongsTo(WorkRequest::class, 'draft_req_id', 'req_id');
    }
}
