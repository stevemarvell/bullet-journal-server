<?php

namespace App;

use App\Exceptions\JournalException;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected static function booted()
    {
        static::creating(function($journal) {

            $user = User::all()->find($journal->user_id);

            if( $user->journals()->where('index',$journal->index)->first() ) {
                throw(new JournalException("Cannot create journal with repeated index"));
            }

            if( $user->journals()->where('completed_at',null)->first() ) {
                throw(new JournalException("Cannot create journal when not completed journal exists"));
            }
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'index', 'title', 'started_at', 'completed_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function complete() {
        $this->completed_at = date(DATE_ATOM);
        $this->save();
    }
}
