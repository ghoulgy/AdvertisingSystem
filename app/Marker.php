<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Marker extends Model
{
	protected $fillable = ['lng', 'lat', 'title', 'type', 'description'];
	
  public function user() {
  	return $this->belongsTo(User::class);
  }
}
