<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Page extends Model {

   public static function insertData($data){

      $value=DB::table('afnic')->where('nom_domaine', $data['nom_domaine'])->get();
      if($value->count() == 0){
         DB::table('afnic')->insert($data);
      }
   }

}
