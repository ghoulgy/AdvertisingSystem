<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MarkerDemand extends Model
{
	protected $fillable = ['lng', 'lat', 'title', 'type', 'need', 'description'];
	
  public function user() {
  	return $this->belongsTo(User::class);
  }
}
