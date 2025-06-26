<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'description', 'image', 'status_id', 'created_by', 'assigned_to',
        'created_date', 'assigned_date', 'completed_date'
    ];

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
