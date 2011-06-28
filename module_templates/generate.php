<?php

$appsDirectory = realpath("../apps/asterisell");
$modulesDirectory = $appsDirectory."/modules";

// Call Report - Template

copyModule("call_report_template", "admin_tt_call_report");
copyModule("call_report_template", "office_ft_call_report");
copyModule("call_report_template", "office_ff_call_report");
copyModule("call_report_template", "customer_tt_call_report");
copyModule("call_report_template", "customer_ft_call_report");
copyModule("call_report_template", "customer_ff_call_report");
copyModule("call_report_template", "customer_tf_call_report");

processAllCallReportTemplate("config/generator.yml");
processAllCallReportTemplate("config/security.yml");
processAllCallReportTemplate("templates/_list_header.php");
processAllCallReportTemplate("templates/_list.php");
processAllCallReportTemplate("templates/listSuccess.php");
processAllCallReportTemplate("templates/_filter_on_destination_type.php");
processAllCallReportTemplate("templates/_filter_on_show.php");
processAllCallReportTemplate("actions/actions.class.php");


// Invoice - Template 

copyModule("invoice_template", "customer_invoice");
copyModule("invoice_template", "vendor_invoice");

processAllInvoiceTemplate("config/generator.yml");
processAllInvoiceTemplate("actions/actions.class.php");
processAllInvoiceTemplate("templates/_creation_actions.php");

// About - Template

copyModule("about_template", "about");
processTemplate("about_template", "templates/indexSuccess.php", "", "about");


// Support Functions 

function processAllCallReportTemplate($srcFile) {
  processCallReportTemplate($srcFile, "customer", "t", "t");
  processCallReportTemplate($srcFile, "customer", "f", "t");
  processCallReportTemplate($srcFile, "customer", "f", "f");
  processCallReportTemplate($srcFile, "customer", "t", "f");

  processCallReportTemplate($srcFile, "office", "f", "t");
  processCallReportTemplate($srcFile, "office", "f", "f");

  processCallReportTemplate($srcFile, "admin", "t", "t");
}

function processAllInvoiceTemplate($srcFile) {
  processInvoiceTemplate($srcFile, "customer");
  processInvoiceTemplate($srcFile, "vendor");
}

function processInvoiceTemplate($srcFile, $procType) {
  processTemplate("invoice_template", $srcFile, $procType, $procType."_invoice");
}


function processCallReportTemplate($srcFile, $procType, $showOffice, $showAccount) {
  processTemplate("call_report_template", $srcFile, "$procType $showOffice $showAccount", $procType."_" . $showOffice . $showAccount . "_call_report");
}

function processTemplate($srcModule, $srcFile, $processingParams, $dstModule) {
  global $modulesDirectory;

  my_shell_exec("cd $srcModule; php $srcFile $processingParams > $modulesDirectory/$dstModule/$srcFile");
}

function copyModule($srcName, $dstName) {
  global $modulesDirectory;
  copyDirectoryContent($srcName, $modulesDirectory . "/" . $dstName);
}

function copyDirectoryContent($src, $dst) {
  my_shell_exec("mkdir $dst");

  $src1 = realpath($src);
  $dst1 = realpath($dst);

  if (!is_null($dst1) && strlen(trim($dst1)) > 0) {
    if (!is_null($src1) && strlen(trim($src1)) > 0) {
      my_shell_exec("rm -r -f $dst1/*");
      my_shell_exec("cp -r $src1/* $dst1/.");
    } else {
      echo "\nWARNING: Directory $src does not exists!";
    }
  } else {
    echo "\nWARNING: Directory $dst does not exists!";
  }
}

function my_shell_exec($cmd) {
  echo "$cmd\n";
  shell_exec($cmd);
}

?>