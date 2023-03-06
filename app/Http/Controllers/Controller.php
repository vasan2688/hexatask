<?php

namespace App\Http\Controllers;

use App\Events\SendEmailEvent;
use Exception;
use App\Models\FileUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function fileUpload(Request $request)
    {  
        $rules      = ['file' => 'required|file|mimes:pdf,txt,word,xml,csv|max:10000'];
        $messages   = [
            'file.required' => 'File is Required', 
            'file.file'     => 'Must be a File',
            'file.mimes'    => 'Selected File format is invalid',
            'file.size'     => 'File Size should be In 10 MB',
        ];
        $validate  =  Validator::make($request->all(), $rules, $messages);

        if ($validate->fails()) {
            $error_messages = implode(',', $validate->errors()->all());
            return back()->withErrors($error_messages);
                // throw new Exception($error_messages);
        }  
        
        if ($request->hasFile('file')) {

            $folderPath = 'laravel-auth/files';
           
            if (! $path = $this->s3Upload('s3', $folderPath,  $request->file('file'), 'public')) {
                return back()->withErrors('File Upload Failed');
                throw new Exception("File Upload Failed");
            } 

            $fileUpload = new FileUpload();
            $fileUpload->user_id = Auth()->user()->id;
            $fileUpload->path    = $path;
            $fileUpload->save();

            $s3Path = "https://test105528.s3.ap-south-1.amazonaws.com/".$path;
            session(['path' => $s3Path]);    
            
            $emailData = [
                "subject"   => "New Mail Received Contails S3 url !!!",
                "url"       => $s3Path,
            ];

            event(new SendEmailEvent($emailData));

            return back()->withSuccess('File Upload Successfully Completed');
        }        
      
        return back()->withErrors('File Not Uploaded');
        
    }

    public function generateFileName()
    {
        $prefix = sprintf("%s-%s-%s", microtime(true), getmygid(), gethostname());
        return md5($prefix);
    }


    public function getStorageDriver($driver)
    {
        return Storage::disk($driver);
    }

    public function s3Upload($driver, $path, $file, $accessType)
    {
        $driver = $this->getStorageDriver($driver);
        return $driver->put($path, $file, $accessType);
    }

}
