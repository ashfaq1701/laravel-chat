<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class FileController extends Controller
{
	public function imageDownload($filename)
	{
		$file= public_path(). "/uploads/files/".$filename;
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		$headers = array(
			'Content-Type: image/'.strtolower($ext),
		);
		return response()->download($file, $filename, $headers);
	}
	
	public function fileDownload($filename)
	{
		$file= public_path(). "/uploads/files/".$filename;
		$headers = array();
		return response()->download($file, $filename, $headers);
	}
}