<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Table_A extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table        = 'my_flights';

    protected $primaryKey   = 'my_id';

    protected $incrementing = false; // False if primary key non-numeric

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_id'
    ];

    /**
     * The attributes that should be cast to native types.
     * The supported cast types are: integer, real, float, double, string, boolean, object, array,  collection, date, datetime, and timestamp.
     * @var array
     */
    protected $casts = [
        'is_admin' => 'boolean',
    ];

    protected $timestamps   = false; // False if no created_at and updated_at

    /**
     * The storage format of the model's date columns.
     * Y-m-d H:i:s
     * @var string
     */
    protected $dateFormat = 'U';

    /**
     * If you need to customize the names of the columns used to store the timestamps.
     *
     * @var string
     */
    const CREATED_AT     = 'creation_date'; 

    const UPDATED_AT     = 'last_update';

    /**
     * One To One : Table A To Table 1.
     *
     * return $this->hasOne('App\Table_1', 'foreign_key');
     * return $this->hasOne('App\Table_1', 'foreign_key', 'local_key');
     */
    public function Table_1()
    {
        return $this->hasOne('App\Table_1')->withDefault([
    
            'name' => 'Guest Author',
    
        ]);
    }

    /**
     * One To Many : Table A To Table 2
     *
     * return $this->hasMany('App\Table_2', 'foreign_key');
     * return $this->hasMany('App\Table_2', 'foreign_key', 'local_key');
     */
    public function Table_2()
    {
        return $this->hasMany('App\Table_2')->withDefault([
    
            'name' => 'Guest Author',
    
        ]);
    }

    /**
     * Many To Many : Table A To Table 3
     *
     * return $this->belongsToMany('App\Table_3', 'role_user');
     * return $this->belongsToMany('App\Table_3', 'role_user', 'user_id', 'role_id');
     */
    public function Table_3()
    {
        return $this->belongsToMany('App\Table_3');
    }
            
}
