<?php

/**
 * Extract all nations from new rate prefix.
 */
function groupAllNations($filename) {
  $nrOfColInLine = 4;
  $handle = fopen($filename, 'r');
  if ($handle == false) {
    echo "Error opening file \"$filename\"";
    exit(2);
  }

  echo "\nReading telephone prefixes\n";

  $prefixes = array();

  $ln = 0;
  while (($data = fgetcsv($handle, 5000, ";")) !== false) {
    $ln++;
    $prefixes[trim($data[0])] = 0;
  }

  fclose($handle);

  return $prefixes;
}


/**
 * Extract all sure nations, because there is something like `Italy Mobile`.
 */
function sureNations($groups) {

  $sure = array();

  foreach($groups as $group => $zero) {
    // if it contains "Mobile" then the initial part is for sure the name of a nation
    //
    $pos = strpos($group, " Mobile");

    if (! $pos == FALSE) {
      $name = substr($group, 0, $pos);
      $sure[$name] = 0;
    }
  }

  return $sure;
}

/**
 * Given something like `Italy Mobile TIM` extract `Italy` and `Mobile line` and `TIM`
 * @return list($nation, $type, $operator)
 */
function extractNationAndType1($nationAndType, $sureNations) {

  $bestLen = 0;
  $bestNation = $nationAndType;
  $bestType = NULL;
  $bestOperator = NULL;

  foreach($sureNations as $sureNation => $zero) {
    $len = strlen($sureNation);
    if (substr($nationAndType, 0, $len) === $sureNation) {
      if (strlen($nationAndType) === $len || substr($nationAndType, $len, 1) === " ") {
        if ($len > $bestLen) {
	  // ok we have a valid name better than previous valid name
          //
          $type1 = trim(substr($nationAndType, $len));
          $operator = "";
          $type = "";

          $mobileStr = "Mobile";
          if (substr($type1,0, strlen($mobileStr)) === $mobileStr) {
            $type = "Mobile Line";
            $operator = trim(substr($type1, strlen($mobileStr)));
          } else {
            $type = "Fixed Line";
            $operator = $type1;
          } 

          $bestLen = $len;
          $bestNation = $sureNation;
          $bestType = $type;
          $bestOperator = $operator;
        }
      }
    }
  }

  return array($bestNation, $bestType, $bestOperator);
}

function extractNationAndType($nationAndType, $sureNations, $specialNations) {
  list($x, $y, $z) = extractNationAndType1($nationAndType, $sureNations);

  if (is_null($y)) {
    return extractNationAndType1($nationAndType, $specialNations);
  } 

  return array($x, $y, $z);
}

/**
 * Find the nations without a `Mobile` part, and they must be manually specified.
 */
function nationsToFix($allNations, $sureNations, $specialNations) {
  foreach($allNations as $nationAndType => $zero) {
    list($nation, $type, $operator) = extractNationAndType($nationAndType, $sureNations, $specialNations);
    if (is_null($type)) {
      echo "\n,\"" . $nationAndType . "\" => \"Unspecified\"";
    }
  }
}

/**
 * Write using a new and more rational format.
 */
function produceCSV($filename, $sureNations, $specialNations, $outFile) {
  $handle = fopen($filename, 'r');
  $out = fopen($outFile, 'w');
  if ($handle == false) {
    echo "Error opening file \"$filename\"";
    exit(2);
  }

  $ln = 0;
  while (($data = fgetcsv($handle, 5000, ";")) !== false) {
      $prefix = trim($data[1]);
      $nationAndType = trim($data[0]);
      list($nation, $type, $operator) = extractNationAndType($nationAndType, $sureNations, $specialNations);
      fwrite($out, "\"$prefix\", \"$nation\", \"$type\", \"$operator\"\n");
  }

  fclose($handle);
  fclose($out);
}

/**
 * The special nations extracted from `nationsToFix`, fixed manually.
 */
$specialNations = array(
 "Antarctica" => "Unspecified"
,"Ascension Island" => "Unspecified"
,"Bermuda" => "Unspecified"
,"British Virgin Islands" => "Unspecified"
,"Canada" => "Unspecified"
,"Canada Northwest Territories" => "Unspecified"
,"Cook Islands" => "Unspecified"
,"Diego Garcia" => "Unspecified"
,"East Timor" => "Unspecified"
,"EMSAT" => "Unspecified"
,"Equatorial Guinea" => "Unspecified"
,"Faeroe Islands" => "Unspecified"
,"Falkland Islands" => "Unspecified"
,"French Polynesia" => "Unspecified"
,"Global Sat" => "Unspecified"
,"Guam" => "Unspecified"
,"Inmarsat" => "Unspecified"
,"Inmarsat Aero" => "Unspecified"
,"Inmarsat B" => "Unspecified"
,"Inmarsat B HSD" => "Unspecified"
,"Inmarsat BGAN" => "Unspecified"
,"Inmarsat BGAN Isdn" => "Unspecified"
,"Inmarsat M" => "Unspecified"
,"Inmarsat M Isdn" => "Unspecified"
,"Inmarsat Mini" => "Unspecified"
,"Iridium 8816" => "Unspecified"
,"Iridium 8817" => "Unspecified"
,"Korea North" => "Unspecified"
,"Marshall Islands" => "Unspecified"
,"Micronesia" => "Unspecified"
,"Midway Islands" => "Unspecified"
,"Nauru" => "Unspecified"
,"Niue" => "Unspecified"
,"Norfolk Islands" => "Unspecified"
,"Northern Marianas" => "Unspecified"
,"Palau" => "Unspecified"
,"Puerto Rico" => "Unspecified"
,"St. Helena" => "Unspecified"
,"St. Kitts and Nevis" => "Unspecified"
,"St. Vincent and Grenadines" => "Unspecified"
,"Thuraya Satellite" => "Unspecified"
,"Tokelau" => "Unspecified"
,"Trinidad and Tobago" => "Unspecified"
,"Turks and Caicos" => "Unspecified"
,"USA" => "Unspecified"
,"USA Alaska" => "Unspecified"
,"USA Hawaii" => "Unspecified"
,"USA New York City" => "Unspecified"
,"Vatican City" => "Unspecified"
,"Virgin Islands US" => "Unspecified"
,"Wallis Futuna" => "Unspecified"
,"Western Samoa" => "Unspecified"
);

///////////////
// MAIN PART //
///////////////

$newFile = "new_world_prefixes.csv";
$oldFile = "previous_world_prefix_table.csv";
$outFile = "world_prefix_table.csv";

$allNations = groupAllNations($newFile);
$sureNations = sureNations($allNations);

echo "\nNATIONS TO FIX:\n";
nationsToFix($allNations, $sureNations, $specialNations);

echo "\nPRODUCE $outFile \n";
produceCSV($newFile, $sureNations, $specialNations, $outFile);

?>
