<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
use App\Page;

class PagesController extends Controller
{

  public function index(){
    return view('index');
  }

  public function uploadFile(Request $request){

    if ($request->input('submit') != null ){

      $file = $request->file('file');

      // File Details
      $filename = $file->getClientOriginalName();
      $extension = $file->getClientOriginalExtension();
      $tempPath = $file->getRealPath();
      $fileSize = $file->getSize();
      $mimeType = $file->getMimeType();

      // Valid File Extensions
      $valid_extension = array("csv");

      // 2MB in Bytes
      $maxFileSize = 501373440;

      // Check file extension
      if(in_array(strtolower($extension),$valid_extension)){

        // Check file size
        if($fileSize <= $maxFileSize){

          // File upload location
          $location = 'uploads';

          // Upload file
          $file->move($location,$filename);

          // Import CSV to Database
          $filepath = public_path($location."/".$filename);

          // Reading file
          $file = fopen($filepath,"r");

          $importData_arr = array();
          $i = 0;

          while (($filedata = fgetcsv($file, 5000000, ";")) !== FALSE) {
             $num = count($filedata );

             // Skip first row (Remove below comment if you want to skip the first row)
             if($i == 0){
                $i++;
                continue;
             }
             for ($c=0; $c < $num; $c++) {
                $importData_arr[$i][] = $filedata [$c];
             }
             $i++;
          }
          fclose($file);

          // Insert to MySQL database
          foreach($importData_arr as $importData){

            $insertData = array(
               "nom_domaine"=>$importData[0],
               "pays_be"=>$importData[1],
               "departement_be"=>$importData[2],
               "ville_be"=>$importData[3],
               "nom_be"=>$importData[4],
               "sous_domaine"=>$importData[5],
               "type_titulaire"=>$importData[6],
               "pays_titutaire"=>$importData[7],
               "departement_titulaire"=>$importData[8],
               "domaine_idn"=>$importData[9],
               "date_creation"=>$importData[10],
               "date_retrait"=>$importData[11]);
            Page::insertData($insertData);

          }

          Session::flash('message','Import Successful.');
        }else{
          Session::flash('message','File too large. File must be less than 50MB.');
        }

      }else{
         Session::flash('message','Invalid File Extension.');
      }

    }

    // Redirect to index
    return redirect()->action('PagesController@index');
  }
}
