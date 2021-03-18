<?php

namespace App\Models\Admin;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Admin\Pemilihan;
use App\Models\Admin\Voting;
use App\Models\Siswa;

class Calon extends Model
{
    use SoftDeletes;

    protected $table = 'calon';
	protected $fillable = [
        'name', 'sekolah_id'
    ];
    protected $guarded = [];

    // public function user()
    // {
    // 	return $this->belongsTo(User::class);
    // }

    public function pemilihans(){
        return $this->belongsToMany(Pemilihan::class);
    }

    public function votes(){
        return $this->hasMany(Voting::class);
    }

    public function user(){
        return $this->hasMany(User::class);
    }

}
