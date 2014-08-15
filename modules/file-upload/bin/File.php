<?php

class File {
	
	public $fileName = null;
	public $fileTempName = null;
	public $fileSizeBytes = null;
	public $fileType = null;
	public $fileUploadError = null;
	
	/**
	 * File Object.
	 * @return {Object} file
	 * @access public
	 */
	public function File( $argsArr ) {
		
		$this->fileName = $argsArr['fileName'];
		$this->fileType = $argsArr['fileType'];
		$this->fileSizeBytes = $argsArr['fileSizeBytes'];
		$this->fileTempName = $argsArr['fileTempName'];
		$this->fileUploadError = $argsArr['fileUploadError'];
		
	}
	
}

?>