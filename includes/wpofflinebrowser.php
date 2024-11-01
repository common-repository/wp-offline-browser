<?php

function lang_add( $output )
{
$output .= ' manifest="cache.manifest"';
return $output;
}

function rule_add( $rules )
{ 
return $rules . "AddType text/cache-manifest .manifest \n";
}

function install()
{
}

function uninstall()
{
unlink(ABSPATH.'/cache.manifest');
}

function validtype($file)
{
$flx=array("js","css","png","jpg","jpeg","gif","php");
$tnr=explode('.',$file);
$ts=array_pop($tnr);
if (in_array($ts,$flx))
{
return true;
}
else
{
return false;
}

}


function generate(){
$network = array("\n\nNETWORK:");
$cache = array("\n\nCACHE:");
$path = get_stylesheet_directory()."/";
$dir = new RecursiveDirectoryIterator( $path );	 


// Scaning theme dir
foreach(new RecursiveIteratorIterator($dir) as $file) {
if ($file->
IsFile() && substr($file->
getFilename(), 0, 1) != ".") {
if(preg_match('/.php$/', $file)) {
if (validtype($file))
array_push($network,"\n" . str_replace('\\','/',str_replace(ABSPATH,get_bloginfo('url').'/',$file)));
} else {
if (validtype($file))
array_push($cache,"\n" . str_replace('\\','/',str_replace(ABSPATH,get_bloginfo('url').'/',$file)));
}
}
} 



// Caching attachement
$attachments = get_children( array(
'post_parent' =>
get_the_ID(),
'post_status' =>
'inherit',
'post_type' =>
'attachment',
'numberposts' =>
50,
'post_mime_type' =>
'image') 
);
foreach ( $attachments as $attachment_id =>
$attachment ) {
array_push($cache,"\n" . wp_get_attachment_url( $attachment_id ) );
}



// Caching posts
$posts = get_children(array(
'post_type'			=>
'post',
'post_status'		=>
'publish'
)
);
foreach ( $posts as $post_id =>
$post ) {array_push($cache,"\n" .get_bloginfo('url').'/?p='.$post_id);}



// Caching pages
$pages = get_children(array(
'post_type'			=>
'page',
'post_status'		=>
'publish'
)
);
foreach ( $pages as $page_id =>
$page ) {array_push($cache,"\n" .get_bloginfo('url').'/?page_id='.$page_id);}




// Caching homepage
array_push($cache,"\n" . get_bloginfo('url') );



// Generating manifest file
$fh = fopen(ABSPATH.'/cache.manifest', 'w' );
fwrite($fh,'CACHE MANIFEST');

foreach($cache as $file){ fwrite($fh,$file); }
foreach($network as $file){ fwrite($fh,$file);}
fclose($fh);


}




?>