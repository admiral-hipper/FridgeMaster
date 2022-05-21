<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blocks extends Model
{
    use HasFactory;
    public function locations()
    {
        return $this->belongsTo(Locations::class);
    }
    public function orders()
    {
        return $this->belongsToMany(Orders::class)->withTimestamps();
    }
    public function scopeTerm($query, $start_rent, $end_rent)
    {
        return $query->where(function ($query) use ($start_rent, $end_rent) {
            $query->whereDoesntHave('orders', function ($query) use ($start_rent, $end_rent) {
                $query->where('orders.id', '>', 0)
                    ->where('orders.status', '=', true)
                    ->where(function ($query) use ($start_rent, $end_rent) {
                        $query->whereBetween('start_rent', [$start_rent, $end_rent])->orWhereBetween('end_rent', [$start_rent, $end_rent]);
                    });
            })->orWhere(function ($q) {
                $q->whereHas('orders', function ($query) {
                    $query->where('orders.status', '=', false);
                });
            });
        });
    }
    public function scopeTemperature($query, $temperature)
    {
        return $query->where(function ($query) use ($temperature) {
            $query->where('temperature', '>=', $temperature - 2)
                ->Where('temperature', '<=', $temperature + 2);
        })->where('temperature', '<', 0);
    }
    public function scopeSpare($query)
    {
        return $query->where(function ($query) {
            $query->whereDoesntHave('orders', function ($query) {
                $query->where('orders.id', '>', 0)
                    ->where('orders.status', '=', true);
            });
        });
    }
}
