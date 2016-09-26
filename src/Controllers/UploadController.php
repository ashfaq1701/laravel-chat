<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Repositories\Chat\UploadRepository;

class UploadController extends Controller
{
	protected $uploadRepository;

	public function __construct(UploadRepository $uploadRepository)
	{
		$this->uploadRepository = $uploadRepository;
	}

	public function fileUpload()
	{
		$uploadedFiles = $this->uploadRepository->fileUpload();

		return response()->json(["status"=>"ok", "files"=>$uploadedFiles]);
	}
}