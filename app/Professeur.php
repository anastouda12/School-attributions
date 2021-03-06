<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Professeur extends Model
{
    protected $primaryKey = 'acronyme';
    protected $keyType = 'string';
    
    public  $timestamps = false;
    public $incrementing = false;

    public static function insertData($data)
    {
        $value = DB::table('professeurs')->where('acronyme', $data['acronyme'])->get();

        if ($value->count() == 0) {
            DB::table('professeurs')->insert([
                'acronyme' => $data['acronyme'],
                'nom' => $data['nom'],
                'prenom' => $data['prenom'],
            ]);
        }
    }
}
