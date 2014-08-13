<?php

class FileUpload {
	
	// relative to current location
	const UPLOAD_DIR = '../../uploads/';
	
	private $_fileName = null;
	private $_fileTempName = null;
	private $_fileSizeBytes = null;
	private $_fileType = null;
	private $_fileUploadError = null;

	/**
	 * File Upload Handler.
	 * @return {Object} fileUpload
	 * @access public
	 */
	public function FileUpload( $argsArr ) {
		
		$this->_fileName = $argsArr['fileName'];
		$this->_fileType = $argsArr['fileType'];
		$this->_fileSizeBytes = $argsArr['fileSizeBytes'];
		$this->_fileTempName = $argsArr['fileTempName'];
		$this->_fileUploadError = $argsArr['fileUploadError'];
		
	}
	
	/**
	 * Has the file uploaded.
	 * @access private
	 * @return {boolean} - false if validation fail
	 */
	private function _isFileUploadedSucessfully() {
		
		if ( $this->_fileUploadError > 0 ) {
		
			echo 'File upload failed' . '<br/>';
		
			return false;
		
		}
		
		return true;
		
	}
	
	/**
	 * File at location allready exists.
	 * @access private
	 * @return {boolean} - false if validation fail
	 */
	private function _isNoDuplicationOfFile() {
		
		if ( file_exists( FileUpload::UPLOAD_DIR . $this->_fileName ) ) {
		
			echo 'File already exists.' . '<br/>';
			
			return false;
		
		}
		
		return true;
		
	}
	
	/**
	 * Echos out data of sucessful file upload.
	 * @access private
	 */
	private function _successfulOutputUI() {
		
		echo '_fileName - ' . $this->_fileName . '<br>';
		echo '_fileType - ' . $this->_fileType . '<br>';
		echo '_fileSizeBytes - ' . ( $this->_fileSizeBytes / 1024 ) . ' KB<br>';
		echo '_fileTempName - ' . $this->_fileTempName . '<br>';
		
	}
	
	/**
	 * Handles incoming file, saves to ./uploads
	 * @access public
	 */
	public function handleFileUpload() {
		
		// Error in upload
		if ( !$this->_isFileUploadedSucessfully() ) {
				
			echo 'File Upload - failed' . '<br/>';
			
			header( 'HTTP/1.1 400 Bad Request', true, 400 );
				
			return;
				
		}		
		
		// Input Validation
		$fileUploadValidation = new FileUploadValidation( array(
			'fileName' => $this->_fileName,
			'fileType' => $this->_fileType,
			'fileSizeByes' => $this->_fileSizeBytes
		));
		
		if ( !$fileUploadValidation->isFileUploadValidationPass() ) {
			
			echo 'File Upload Validation - failed' . '<br/>';
			
			header( 'HTTP/1.1 400 Bad Request', true, 400 );
			
			return;
			
		}
		
		// File not a duplicate
		if ( !$this->_isNoDuplicationOfFile() ) {
		
			echo 'File duplication error.' . '<br/>';
			
			header( 'HTTP/1.1 400 Bad Request', true, 400 );
		
			return;
		
		}
		
		// Move file to ./uploads
		move_uploaded_file( $this->_fileTempName, FileUpload::UPLOAD_DIR . $this->_fileName );
		
		// Successful output UI
		$this->_successfulOutputUI();
		
	}
	
}

?>