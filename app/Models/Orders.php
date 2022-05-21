<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Orders extends Model
{
    //protected $dateFormat = 'Y-m-d';

protected $dates = [ 'start_rent','end_rent'];
    use HasFactory;
    protected $fillable=[
        'termin','access_token'
    ];
    public function blocks(){
        return $this->belongsToMany(Blocks::class);
    }
    public function customers(){
        return $this->belongsTo(Customers::class);
    }
   
    protected $casts=[
        'start_rent'=>'date:Y-m-d','end_rent'=>'date:Y-m-d'
    ];
    public function getStartAttribute(){
        return date_format($this->start_rent,"Y-m-d");
    }
    public function getEndAttribute(){
        return date_format($this->end_rent,"Y-m-d");
    }
}
