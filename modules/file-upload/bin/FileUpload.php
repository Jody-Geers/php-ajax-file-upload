<?php

class FileUpload {
	
	// relative to current location
	const UPLOAD_DIR = '../../uploads/';
	
	private $_file = null;

	/**
	 * File Upload Handler.
	 * @return {Object} fileUpload
	 * @access public
	 */
	public function FileUpload( $argsObj ) {
		
		$this->_file = $argsObj;
		
	}
	
	/**
	 * Has the file uploaded.
	 * @access private
	 * @return {boolean} - false if validation fail
	 */
	private function _isFileUploadedSucessfully() {
		
		if ( $this->_file->fileUploadError > 0 ) {
		
			echo 'Error in file upload' . '<br/>';
		
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
		
		if ( file_exists( FileUpload::UPLOAD_DIR . $this->_file->fileName ) ) {
		
			echo 'File already exists.' . '<br/>';
			
			return false;
		
		}
		
		return true;
		
	}
	
	/**
	 * Echos out data of sucessful file upload.
	 * @return {string} - html ui output
	 * @access private
	 */
	private function _successfulOutputUI() {
		
		$returnUi = '';
		
		$returnUi .= '<div class="width-half float-left"><img src="/uploads/' . $this->_file->fileName . '" class="width-whole"/></div>';

		$returnUi .= '<div class="width-half float-left text-center">' 
				  . 'fileName:' . '<br/>' . $this->_file->fileName . '<br>'
				  . 'fileType:' . '<br/>' . $this->_file->fileType . '<br>'
				  . 'fileSizeBytes:' . '<br/>' . ( $this->_file->fileSizeBytes / 1024 ) . ' KB<br>'
				  . 'fileTempName:' . '<br/>' . $this->_file->fileTempName . '<br>'
				  . '</div>'
  		;
  		
  		return $returnUi;
		
	}
	
	/**
	 * Handles incoming file, saves to ./uploads
	 * @return {boolean} - false if process fail
	 * @return {string} - html output if successful
	 * @access public
	 */
	public function handleFileUpload() {
		
		// Error in upload
		if ( !$this->_isFileUploadedSucessfully() ) {
				
			echo 'File Upload - failed' . '<br/>';
				
			return false;
				
		}		
		
		// Input Validation
		$fileUploadValidation = new FileUploadValidation( $this->_file );
		
		if ( !$fileUploadValidation->isFileUploadValidationPass() ) {
			
			echo 'File Upload Validation - failed' . '<br/>';
			
			return false;
			
		}
		
		// File not a duplicate
		if ( !$this->_isNoDuplicationOfFile() ) {
		
			echo 'File duplication error.' . '<br/>';
		
			return false;
		
		}
		
		// Move file to ./uploads
		move_uploaded_file( $this->_file->fileTempName, FileUpload::UPLOAD_DIR . $this->_file->fileName );
		
		// Successful output UI
		return $this->_successfulOutputUI();
		
	}
	
}

?>