<?php

class Main {
	
	/**
	 * Application.
	 * @return {Object} main
	 * @access public
	 */
	public function Main() {

		// application dependancys
		require_once( '/bin/FileUpload.php' );
		require_once( '/bin/FileUploadValidation.php' );
		
	}

	/**
	 * Routing of incoming file transfer.
	 * @access public
	 */
	public function init() {
		
		if ( $_FILES ) {
			
			// accept file transfer
			$fileUpload = new FileUpload( array(
				'fileName' => $_FILES['file']['name'],
				'fileType' => $_FILES['file']['type'],
				'fileSizeBytes' => $_FILES['file']['size'],
				'fileTempName' => $_FILES['file']['tmp_name'],
				'fileUploadError' => $_FILES['file']['error']
			));
			
			$fileUpload->handleFileUpload();
			
			return;
		
		} else {
			
			// decline invalid request
			echo 'Invalid request type' . '<br/>';
			
			header( 'HTTP/1.1 400 Bad Request', true, 400 );
			
			return;
			
		}
		
	}
	
}

/**
 * Start Application
 */
$main = new Main();
	$main->init();

?>