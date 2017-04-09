<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Post extends Model
{
    public function getPublished()
    {
        $posts = $this->latest('published_at')->published()->get();
      return $posts;
        
    }
    
    public function scopePublished($query)
    {
        $query->where('published_at','>=',Carbon::now())
            ->where('published','=',1); 
    }
}
