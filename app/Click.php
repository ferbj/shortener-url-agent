<?php

namespace App;

use App\Url;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Click extends Model
{
    protected $fillable = ['url_id','browser','platform'];

    public function url(){
        return $this->BelongsTo(Url::class,'url_id');
    }
}
