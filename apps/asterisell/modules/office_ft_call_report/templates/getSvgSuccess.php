<?php
  /**************************************************************
   !!!                                                        !!!
   !!! WARNING: This file is automatic generated.             !!!
   !!!                                                        !!!
   !!! In order to modify this file change the content of     !!!
   !!!                                                        !!!
   !!!    /module_template/call_report_template               !!!
   !!!                                                        !!!
   !!! and execute                                            !!!
   !!!                                                        !!!
   !!!    sh generate_modules.sh                              !!!     
   !!!                                                        !!!
   **************************************************************/
use_helper('I18N', 'Debug', 'Date', 'Asterisell');

// NOTE: if there is an error in this script then the 
// generated content-type is not "image/svg+xml",
// but "text/html" and there is an error in the resulting 
// HTTP resouce.

$msg = "";
$isAdmin = $sf_user->hasCredential('admin');
if ($isAdmin) {
  $hasFileName = $sf_request->hasParameter('file');
  if ($hasFileName) {
    $fileName = $sf_request->getParameter('file');
    $completeFileName = "generated_graphs/$fileName";
    $fileExists = file_exists($completeFileName);
    if ($fileExists == FALSE) {
      $msg = getSVGTextMessage("Error: file \"$completeFileName\" does not exist.");
    } else {
      $msg = file_get_contents($completeFileName);
      if ($msg == FALSE) {
	$msg = getSVGTextMessage("Error reading file \"$completeFileName\".");
      }
    }
  } else {
    $msg = getSVGTextMessage("Error: missing \"file\" parameter.");
  }
 } 

echo $msg;

function getSVGTextMessage($msg) {
  $xmlHeader = '<' . '?' . 'xml version="1.0" standalone="no"' . '?' . '>';
  //
  // NOTE: I'm using it, because the generator-preprocessor is confused from
  // < and ? tags that are too similar to PHP open script tags.
  
  return $xmlHeader . '<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd"> <svg version="1.1" xmlns="http://www.w3.org/2000/svg"> <text>' . $msg . '</text></svg>';
}


?>