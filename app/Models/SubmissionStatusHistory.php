<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmissionStatusHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'submission_type',
        'submission_id',
        'previous_status',
        'status',
        'reason',
        'decided_by',
        'decided_at',
    ];

    protected $casts = [
        'decided_at' => 'datetime',
    ];

    public function decisionMaker()
    {
        return $this->belongsTo(User::class, 'decided_by');
    }
}
