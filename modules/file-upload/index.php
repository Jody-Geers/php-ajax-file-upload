<?php

class Main {
	
	private $_file = null;
	
	/**
	 * Application.
	 * @return {Object} main
	 * @access public
	 */
	public function Main() {

		// application dependancys
		require_once( '/bin/File.php' );
		require_once( '/bin/FileUpload.php' );
		require_once( '/bin/FileUploadValidation.php' );
		
		// incoming file
		$this->_file = new File( array(
			'fileName' => $_FILES['file']['name'],
			'fileType' => $_FILES['file']['type'],
			'fileSizeBytes' => $_FILES['file']['size'],
			'fileTempName' => $_FILES['file']['tmp_name'],
			'fileUploadError' => $_FILES['file']['error']
		));
		
	}

	/**
	 * Routing of incoming file transfer.
	 * @access public
	 */
	public function init() {
		
		
		// accept file transfer
		$fileUpload = new FileUpload( $this->_file );
		
		$returnUi = $fileUpload->handleFileUpload();
		
		if ( !$returnUi ) {
			
			// file upload failed
			echo 'Failed file upload' . '<br/>';
			
			header( 'HTTP/1.1 400 Bad Request', true, 400 );
			
		}
		
		// process successful return UI
		echo $returnUi;
		
	}
	
}

/**
 * Start Application
 */
if ( !$_FILES ) {
		
	// decline invalid request
	echo 'Invalid request type' . '<br/>';

	header( 'HTTP/1.1 400 Bad Request', true, 400 );

	return false;
	
} else {

	// bring the noise!
	$main = new Main();
		$main->init();
	
}

?>