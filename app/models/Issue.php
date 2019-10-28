<?php
namespace App\models;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    protected $fillable = ['title', 'message', 'author_id', 'answer', 'inwork', 'closed'];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id', 'id');
    }
}
