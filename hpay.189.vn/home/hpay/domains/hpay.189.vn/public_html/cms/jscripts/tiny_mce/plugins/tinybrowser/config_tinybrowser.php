<?php

// set script time out higher, to help with thumbnail generation
set_time_limit(240);

$tinybrowser = array();

// Session control and security check - to enable please uncomment
//if(isset($_GET['sessidpass'])) session_id($_GET['sessidpass']); // workaround for Flash session bug
//session_start();
//$tinybrowser['sessioncheck'] = 'auth_user'; //name of session variable to check

// Random string used to secure Flash upload if session control not enabled - be sure to change!
$tinybrowser['obfuscate'] = 's0merand0mjunk!!!111';

// Set default language (ISO 639-1 code)
$tinybrowser['language'] = 'en';

// Set the integration type (TinyMCE is default)
$tinybrowser['integration'] = 'tinymce'; // Possible values: 'tinymce', 'fckeditor'

// Default is rtrim($_SERVER['DOCUMENT_ROOT'],'/') (suitable when using absolute paths, but can be set to '' if using relative paths)
$tinybrowser['docroot'] = rtrim($_SERVER['DOCUMENT_ROOT'],'/');

// Folder permissions for Unix servers only
$tinybrowser['unixpermissions'] = 0777;

// File upload paths (set to absolute by default)
$tinybrowser['path']['image'] = '/uploads/image/'; // Image files location - also creates a '_thumbs' subdirectory within this path to hold the image thumbnails
$tinybrowser['path']['media'] = '/uploads/media/'; // Media files location
$tinybrowser['path']['file']  = '/uploads/file/'; // Other files location
// link chen vao web
// File upload paths (set to absolute by default)
$tinybrowser2['path']['image'] = '/image/'; // Image files location - also creates a '_thumbs' subdirectory within this path to hold the image thumbnails
$tinybrowser2['path']['media'] = '/media/'; // Media files location
$tinybrowser2['path']['file']  = '/file/'; // Other files location



// File link paths - these are the paths that get passed back to TinyMCE or your application (set to equal the upload path by default)
$tinydomain = 'http://uploads.hoanggia.net';
$tinybrowser['link']['image'] = $tinydomain.$tinybrowser2['path']['image']; // Image links
$tinybrowser['link']['media'] = $tinydomain.$tinybrowser2['path']['media']; // Media links
$tinybrowser['link']['file']  = $tinydomain.$tinybrowser2['path']['file']; // Other file links

// File upload size limit (0 is unlimited)
$tinybrowser['maxsize']['image'] = 0; // Image file maximum size
$tinybrowser['maxsize']['media'] = 0; // Media file maximum size
$tinybrowser['maxsize']['file']  = 0; // Other file maximum size

// Image automatic resize on upload (0 is no resize)
$tinybrowser['imageresize']['width']  = 0;
$tinybrowser['imageresize']['height'] = 0;

// Image thumbnail source (set to 'path' by default - shouldn't need changing)
$tinybrowser['thumbsrc'] = 'path'; // Possible values: path, link

// Image thumbnail size in pixels
$tinybrowser['thumbsize'] = 80;

// Image and thumbnail quality, higher is better (1 to 99)
$tinybrowser['imagequality'] = 80; // only used when resizing or rotating
$tinybrowser['thumbquality'] = 80;

// Date format, as per php date function
$tinybrowser['dateformat'] = 'd/m/Y H:i';

// Permitted file extensions
$tinybrowser['filetype']['image'] = '*.jpg, *.jpeg, *.gif, *.png'; // Image file types
$tinybrowser['filetype']['media'] = '*.swf, *.dcr, *.mov, *.qt, *.mpg, *.mp3, *.mp4, *.mpeg, *.avi, *.wmv, *.wm, *.asf, *.asx, *.wmx, *.wvx, *.rm, *.ra, *.ram'; // Media file types
$tinybrowser['filetype']['file']  = '*.*'; // Other file types

// Prohibited file extensions
$tinybrowser['prohibited'] = array('php','php3','php5','phtml','asp','aspx','ascx','jsp','cfm','cfc','pl','bat','exe','dll','reg','cgi', 'sh', 'py');

// Default file sort
$tinybrowser['order']['by']   = 'name'; // Possible values: name, size, type, modified
$tinybrowser['order']['type'] = 'asc'; // Possible values: asc, desc

// Default image view method
$tinybrowser['view']['image'] = 'thumb'; // Possible values: thumb, detail

// File Pagination - split results into pages (0 is none)
$tinybrowser['pagination'] = 0;

// TinyMCE dialog.css file location, relative to tinybrowser.php (can be set to absolute link)
$tinybrowser['tinymcecss'] = '../../themes/advanced/skins/thebigreason/dialog.css';

// Assign Permissions for Upload, Edit and Delete
$tinybrowser['allowupload'] = true;
$tinybrowser['allowedit']   = true;
$tinybrowser['allowdelete'] = true;

// Set default action for edit page
$tinybrowser['defaultaction'] = 'delete'; // Possible values: delete, rename
?>
