/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
		config.language = 'en';
		config.extraPlugins = 'uploadimage';
		config.filebrowserBrowseUrl= 'browse.php';
		if(location.host.search('www.')>=0){
			config.filebrowserUploadUrl= 'http://www.shuurkhai.com/assets/uploads/uploader.php';
		}
		else 
		config.filebrowserUploadUrl= 'http://shuurkhai.com/assets/uploads/uploader.php';
		
		config.extraPlugins = 'simple-image-browser';
		config.simpleImageBrowserURL = 'files.php';
		
};
