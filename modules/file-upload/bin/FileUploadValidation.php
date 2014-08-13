<?php

class FileUploadValidation {
	
	const MAX_FILE_SIZE_BYTES = 1000000;
	
	private $_allowedExtsArr = null;
	private $_extension = null;
	private $_allowedTypeArr = null;
	
	private $_incomingFileType = null;
	private $_incomingFileSize = null;
	
	/**
	 * Validation functionality for file upload.
	 * @return {Object} fileUploadValidation
	 * @access public
	 */
	public function FileUploadValidation( $argsArr ) {

		$this->_allowedExtsArr = array( 'gif', 'jpeg', 'jpg', 'png' );
		$temp = explode( '.', $argsArr['fileName'] );
		$this->_extension = end( $temp );
		
		$this->_allowedTypeArr = array( 'image/gif', 'image/jpeg', 'image/jpg', 'image/pjpeg', 'image/x-png', 'image/png' );
		
		$this->_incomingFileType = $argsArr['fileType'];
		$this->_incomingFileSize = $argsArr['fileSizeByes'];
		
	}

	/**
	 * Invalid upload file name.
	 * @access private
	 * @return {bool} - false if validation fail
	 */
	private function _isValidFileName() {
		
		if ( !in_array( $this->_extension, $this->_allowedExtsArr ) ) {
		
			echo 'Invalid file name' . '<br/>';
		
			return false;
		
		}
		
		return true;
		
	}

	/**
	 * Invalid upload file type.
	 * @access private
	 * @return {bool} - false if validation fail
	 */
	private function _isValidFileType() {
		
		if ( !in_array( $this->_incomingFileType, $this->_allowedTypeArr ) ) {
		
			echo 'Invalid file type' . '<br/>';
		
			return false;
		
		}
		
		return true;
		
	}

	/**
	 * Invalid upload file size.
	 * @access private
	 * @return {bool} - false if validation fail
	 */
	private function _isValidFileSize() {
	
		if ( $this->_incomingFileSize > FileUploadValidation::MAX_FILE_SIZE_BYTES ) {
			
			echo 'Invalid file size' . '<br/>';
		
			return false;
		
		}
		
		return true;
	
	}
	
	/**
	 * Runs through full file upload validation process.
	 * @access public
	 * @return {bool} - false if validation fail
	 */
	public function isFileUploadValidationPass() {
		
		return ( $this->_isValidFileName() && $this->_isValidFileType() && $this->_isValidFileSize() )? true : false;
		
	}

	
}

?>