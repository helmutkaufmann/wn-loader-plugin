<?php namespace Mercator\Loader\Components;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Cms\Classes\ComponentBase;
use System\Models\EventLog as EventLog;
use Storage;
use Crypt;

class Loader extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'Drop-Loader',
            'description' => 'Provide a drag-and drop file uploader.',
        ];
    }

    public function defineProperties()
    {
        return [
        'destinationDirectory' => [
             'title'             => 'Destination',
             'description'       => 'Destination of the uploaded items, relative to Storage.',
             'default'           => "upload",
             'type'              => 'string',
             // 'validationPattern' => '^[0-9A-Za-Z,\.]+$',
             // 'validationMessage' => 'Invalid extensions'
        ],
        /*
        'anonymous' => [
             'title'             => 'Anonymous',
             'description'       => 'Anonymous storage, one sub-directory per upload session.',
             'default'           => false,
             'type'              => 'checkbox',
             // 'validationPattern' => '^[0-9A-Za-Z,\.]+$',
             // 'validationMessage' => 'Invalid extensions'
        ],
        */
        'acceptedExtensions' => [
             'title'             => 'Accepted Extensions',
             'description'       => 'Permissible extensions for upload',
             'type'              => 'string',
             // 'validationPattern' => '^[0-9A-Za-Z,\.]+$',
             // 'validationMessage' => 'Invalid extensions'
        ],
        'uploadSizeLimit' => [
             'title'             => 'Upload File Size Limit',
             'description'       => 'Maximum size on on upload items (in megabytes).',
             'default'           => 10,
             'type'              => 'string',
             // 'validationPattern' => '^[0-9A-Za-Z,\.]+$',
             // 'validationMessage' => 'Invalid extensions'
        ],
        'options' => [
             'title'             => 'Options',
             'description'       => 'Dropzone uploader options. See www.dropzonejs.com for details.',
             'type'              => 'string',
             // 'validationPattern' => '^[0-9A-Za-Z,\.]+$',
             // 'validationMessage' => 'Invalid extensions'
        ],

        ];
    }


    public function encrypt($string) {
    	return Crypt::encryptString($string);
    }

    /*
    Insert Dropzone Javascript and CSS
    */

    public function onRun()
	{
    	$this->addJs ('/plugins/mercator/loader/assets/dropzone.js?v=2');
    	$this->addCss('/plugins/mercator/loader/assets/dropzone.css?v=2');
	}

    /*
	Handle Ffile upload
	*/
	public function FileUploader(Request $request){


	 EventLog::add("File uploader called");

	 if ($request->hasFile('file')) {

	   // Upload path
	   try {
			$destinationPath = storage_path(Crypt::decryptString($request->_dest));
		}
		catch (Exception $ex) {
			EventLog::add("Loader::FileUploader: Illegal destination in " . __FILE__);
			return false;
		}

		// Valid extensions
		try {
			$validextensions = ((Crypt::decryptString($request->_ext)));
		}
		catch (Exception $ex) {
			EventLog::add("Loader::FileUploader: Illegal extensions in " . __FILE__);
			return false;
		}

	   Storage::makeDirectory($destinationPath);


	   // Get file extension
	   $extension = $request->file('file')->getClientOriginalExtension();

	   // Check extension
	   if (1 || !$validextensions || ($validextensions == "") || in_array(strtolower($extension), explode(',',  str_replace(".", "", $validextensions)))) {

		 // Rename file
		 $fileName = $request->file('file')->getClientOriginalName().time() .'.' . $extension;

		 // Uploading file to given path
		 $request->file('file')->move($destinationPath, $fileName);

		 EventLog::add("Loader: Uploaded file " . $request->file('file') . " in " .$destinationPath);

	   }
	   else
	   	EventLog::add("Loader: Could not upload file " . $request->file('file') . " in " . __FILE__);
	 }

	}

}
