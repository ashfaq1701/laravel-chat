<?php

namespace App\Repositories\Chat;

use Illuminate\Http\Request;

class UploadRepository
{
	protected $request;
	
	public function __construct(Request $request)
	{
		$this->request = $request;
	}
	
	public function fileUpload()
	{
		$allFiles = $this->request->file();
		$uploadedFiles = array();
		$destination_path = public_path().'/uploads/files/';
		foreach($allFiles as $file)
		{
			$fileNameWithExt = $file->getClientOriginalName();
			$fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
			$fileExt = pathinfo($fileNameWithExt, PATHINFO_EXTENSION);
			$newFileName = $fileName . '-' . time() . '.' . $fileExt;
			$file->move($destination_path, $newFileName);
			$uploadedFiles[] = $newFileName;
		}
		return $uploadedFiles;
	}
}