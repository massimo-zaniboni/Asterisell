<?php

/* $LICENSE 2009, 2010:
 *
 * Copyright (C) 2009, 2010 Massimo Zaniboni <massimo.zaniboni@profitoss.com>
 *
 * This file is part of Asterisell.
 *
 * Asterisell is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * Asterisell is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Asterisell. If not, see <http://www.gnu.org/licenses/>.
 * $
 */

sfLoader::loadHelpers(array('I18N', 'Debug', 'Asterisell', 'Form', 'Number', 'Date'));

// Load EZCOMPONENTS
//
require_once 'ext_libs/ezcomponents-2009.2/Base/src/base.php';
spl_autoload_register( array( 'ezcBase', 'autoload' ) );

/**
 * Allows to use a data array for graph display
 */
class DayByDayGraphDataIterator implements Iterator {

  protected $arrLabels;

  protected $arr;

  protected $pos = 0;

  public function __construct($l, $a) {
    $this->arrLabels = $l;
    $this->arr = $a;
    $this->position = 0;
  }

  /**  
   * Convert an element of the key to a value.
   */
  protected function convertKey($k) {
    return $this->arrLabels[$k];
  }

  protected function convertValue($v) {
    return $v;
  }

  function rewind() {
    $this->pos = 0;
  }

  function current() {
    return $this->convertValue($this->arr[$this->arrLabels[$this->pos]]);
  }

  function key() {
    return $this->convertKey($this->pos);
  }

  function next() {
    ++$this->pos;
  }

  function valid() {
    return isset($this->arrLabels[$this->pos]);
  }
}

class MaxLimitGraphDataIterator extends DayByDayGraphDataIterator {

  protected $limit;

  public function __construct($l, $a, $limit) {
    parent::__construct($l, $a);
    $this->limit = $limit;
  }

  protected function convertValue($v) {
    return $this->limit;
  }
}

/**
 * Calculate a graph.
 */
class CalculatedGraph {

  public $graph;

  public $width;

  public $height;

  /**
   * The name of the file, without path.
   */
  public $fileRef;

  /**
   * The name of the file comprehensive of path.
   */
  public $filePath;

  /**
   * TRUE if the graph has some error.
   */
  public $graphWithError;

  /**
   * Describe the meaning of the graph.
   */
  public $description;

  /**
   * If the graph has error, then use this alternative
   * LIST VIEW.
   */
  protected $alternativeGraphDisplay;

  /**
   * Compute and render the graph.
   *
   * @param $concurrentCallLimit not NULL if the graph is about concurrent calls,
   * NULL otherwise.
   */
  public function __construct($title, $description, $data, $concurrentCallLimit = NULL) {
    $this->description = $description;
    $count = count($data);

    // Separate labels from data
    //
    $labels = array();
    $i = 0;
    foreach($data as $l => $v) {
      $labels[$i] = $l;
      $i++;
    }

    $graphData = new ezcGraphArrayDataSet(new DayByDayGraphDataIterator($labels, $data));

    $height = 450;
    $width = $count * 25;
    if ($width < 400) {
      $width = 400;
    }

    $realTitle = $title;
    if (!is_null($concurrentCallLimit)) {
      $realTitle .= " (safe limit is $concurrentCallLimit)";
    }

    $graph = new ezcGraphLineChart();
    $graph->title = $realTitle;
    $graph->xAxis->axisLabelRenderer = new ezcGraphAxisRotatedLabelRenderer();
    $graph->xAxis->axisLabelRenderer->angle = 45;
    $graph->xAxis->axisSpace = 0.3;
    $graph->options->highlightSize = 9;
    $dataId = __($title);
    $graph->data[$dataId] = $graphData;
    $graph->data[$dataId]->highlight = true;
    $graph->data[$dataId]->symbol = ezcGraph::BULLET; 
    $graph->xAxis->labelCount = $count;
    $graph->options->fillLines = 210; 
    $graph->legend = FALSE;
    
    $maxValue = max($data);
    
    if (! is_null($concurrentCallLimit)) {
      $limitData = new ezcGraphArrayDataSet(new MaxLimitGraphDataIterator($labels, $data, $concurrentCallLimit));
      
      $dataId = __('Safe Limit');
      $graph->data[$dataId] = $limitData;
      
      if ($maxValue < $concurrentCallLimit) {
	$maxValue = $concurrentCallLimit;
      }
      
      $graph->yAxis->label = __('Concurrent Calls');
    } else {
      $graph->yAxis->label = __('Total Calls');
    }
    
    $graph->yAxis->min = 0;
    $graph->yAxis->max = $maxValue;
    
    $graph->xAxis->label = __('Date');

    $this->generateGraph($graph, $width, $height);
  }

  protected function generateGraph($graph, $width, $height) {
    // Complete the object fields.
    //
    $this->graph = $graph;
    $this->width = $width;
    $this->height = $height;

    $this->calcFileName();

    try {
      $graph->render($width, $height, $this->filePath);
      $this->graphWithError = FALSE;
      $this->alternativeGraphDisplay = NULL;
    } catch (Exception $e) {
      $this->graphWithError = TRUE;
      $this->alternativeGraphDisplay = "The graph generation has this problem: " . $e->getMessage() . ". The stack trace is: " . $e->getTraceAsString() . ". The graph data is: ";

      $r = "";
      foreach($this->graph->data as $dataSeries => $data) {
	$r .= "<p>Series: $dataSeries : <ul>";
	foreach($data as $key => $value) {
	  $r .= "<li>$key => $value</li>";
	}
	$r .= "</ul></p>";
      }
      $this->alternativeGraphDisplay .= $r;
    }
  }

  protected function calcFileName() {
    $fileName = uniqid('calls');
    $this->fileRef = $fileName . ".svg";
    $this->filePath = "generated_graphs/$this->fileRef";
  }

  /**
   * @return the HTML tags for insert the graph inside an HTML page.
   */
  public function getGraphInsert() {
    if ($this->graphWithError == FALSE) {
      $width = $this->width + 30;
      $height =  $this->height + 30;
      return '<p><embed src="getSvg?file=' . $this->fileRef .'" type="image/svg+xml" width="'. $width . '" height="' . $height . '"/></p><p>' . htmlentities($this->description) . '</p>';
       
    } else {
      return $this->alternativeGraphDisplay;
    }
  }
}

/**
 * A distribution based graph.
 */
class CalculatedDistributionGraph extends CalculatedGraph {

  /**
   * Compute and render the graph.
   */
  public function __construct($title, $description, $sourceData, $concurrentCallLimit) {
    $this->description = $description;
    $data = $this->compactDistributionArray($sourceData, 12);
    $count = count($data);
    $graphData = new ezcGraphArrayDataSet($data);
    $height = 450;
    $width = 800;
    
    $realTitle = $title;
    if (!is_null($concurrentCallLimit)) {
      $realTitle .= " (safe limit is $concurrentCallLimit)";
    }
    
    $graph = new ezcGraphBarChart();
    $graph->title = $realTitle;
    $graph->options->highlightSize = 10;
    $dataId = __($title);
    $graph->data[$dataId] = $graphData;
    $graph->data[$dataId]->highlight = true;
    $graph->legend = FALSE;
    
    $graph->yAxis->label = __('Total Calls');
    $graph->xAxis->label = __('Concurrent Calls');

    $this->generateGraph($graph, $width, $height);
  }

  /**
   * Compact a distribution array into a new array with $finalRanges
   * of values. Each index contains the sum of previous not compacted
   * indices.
   */
  protected function compactDistributionArray($sourceArr, $finalRanges) {

    // Retrieve the max key inside the array.
    //
    $maxKey = 0;
    foreach($sourceArr as $key => $value) {
      if ($maxKey < $key) {
	$maxKey = $key;
      }
    }

    $step = intval(ceil($maxKey / $finalRanges));
    if ($step == 0) {
      $step = 1;
    }

    // Init result array.
    //
    // NOTE: this is usefull also to be sure to have an array
    // with all proper values.
    //
    $destArr = array();
    
    // Sum the value of source array to dest array.
    //
    foreach($sourceArr as $sourceKey => $val) {
      $destKey = intval(ceil($sourceKey / $step)) * $step;
      if (isset($destArr[$destKey])) {
	$destArr[$destKey] += $val;
      } else {
	$destArr[$destKey] = $val;
      }
    }

    ksort($destArr);
    return $destArr;
  }
}

/**
 * Compute and present to client, stats on calls.
 */
class StatsOnCalls {

  /**
   * Condition on filtered calls.
   */
  public $condition;

  public $startFilterDate;

  public $endFilterDate;

  /**
   * Number of days between the two dates.
   */
  public $numDays;

  /**
   * Total number of calls.
   */
  public $totCalls;

  /**
   * The max number of concurrent calls
   * found in the filter condition.
   */
  public $maxNrOfConcurrentCalls;

  /**
   * Mean calls for each day.
   */
  public function getMeanCalls() {
    if ($this->numDays != 0) {
      return intval($this->totCalls / $this->numDays);
    } else {
      return intval($this->totCalls);
    }
  }

  /**
   * Safe limit.
   */
  public $concurrentCallsSafeLimit;

  /**
   * Dangerous calls above safe limit.
   */
  public $dangerousCalls;

  /**
   * Safe calls under safe limit.
   */
  public function getSafeCalls() {
    return $this->totCalls - $this->dangerousCalls;
  }

  /**
   * Normalize a date into a label
   */
  public function getDateLabel($d) {
    $label = format_invoice_timestamp_according_config($d);
    return $label;
  }

  /**
   * Perc. of dangerous calls.
   */
  public function getDangerousCallsPerc() {
    if ($this->totCalls != 0) {
      return ($this->dangerousCalls / $this->totCalls) * 100.0;
    } else {
      return 0;
    }
  }

  /**
   * Empty graphs can not be displayed.
   */
  public function isEmpty() {
    if ($this->totCalls == 0) {
      return TRUE;
    } else {
      return FALSE;
    }
  }

  /**
   * The number of total calls in a day.
   * Day is an integer from 0 and represent
   * the number of days after the $this->startFilterDate.
   */
  public $nrOfTotCalls;

  /**
   * The number of max concurrent calls in a day.
   * Day is an integer from 0 and represent
   * the number of days after the $this->startFilterDate.
   */
  public $nrOfConcurrentCalls;

  /** 
   * This array contains the distribution of 
   * concurrent calls. 
   * For each number of concurrent calls (used as index), 
   * it stores the number of times it happens (stored as value).
   * For example 
   *
   * > $this->concurrentCallsDistribution[5] = 10
   *
   * means that for 10 times, there were 5 concurrent calls.
   * Or better, there were 10 calls happening when there were
   * other 4 concurrent calls. So for 10 times, the system accepted
   * exactly 5 concurrent calls.
   */
  public $concurrentCallsDistribution;

  /**
   * Compute stats. Then stats results can be retrieved reading
   * the field of the object.
   */
  public function __construct($condition, $startFilterDate, $endFilterDate = NULL) {
    // Set date limits.
    //
    if (is_null($endFilterDate)) {
      $endFilterDate = time();
    }
    $this->startFilterDate = $startFilterDate;
    $this->endFilterDate = $endFilterDate;

    $this->numDays = getDaysBetween($startFilterDate, $endFilterDate);

    // Debug
    //
    //sfContext::getInstance()->getLogger()->info("ChannelUsage START");
    //sfContext::getInstance()->getLogger()->info("Date from $startFilterDate to $endFilterDate");
    //sfContext::getInstance()->getLogger()->info("Days to process: " . $this->numDays);

    // Init arrays.
    //
    $this->nrOfTotCalls = array();
    $this->nrOfConcurrentCalls = array();
    $this->concurrentCallsDistribution = array();
    for ($i = 0; $i <= $this->numDays; $i++) {
      $d = strtotime("+$i days", $startFilterDate);
      $l = $this->getDateLabel($d);
      $this->nrOfTotCalls[$l] = 0;
      $this->nrOfConcurrentCalls[$l] = 0;
    }

    // This array contains the active calls.
    // It has format "CDR.ID => CDR.CALLDATE"
    // with CALLDATE in Unixtimestamp format.
    //
    $activeCalls = array();

    // Prepare the query
    //
    $c = clone $condition;
    $this->condition = $c;
    $c->clearSelectColumns();
    $c->addSelectColumn(CdrPeer::CALLDATE);          // field 1
    $c->addSelectColumn(CdrPeer::DURATION);          // field 2
    $c->addSelectColumn(CdrPeer::DESTINATION_TYPE);  // field 3
    $c->addSelectColumn(CdrPeer::ID);                // field 4
    $callDateField = 1;
    $durationField = 2;
    $destinationTypeField = 3;
    $idField = 4;
    $c->addAscendingOrderByColumn(CdrPeer::CALLDATE);
    
    // Execute a query without retrieving all the results,
    // but requesting them from MySQL one at a time.
    // This reduce memory overhead.
    //
    $this->totCalls = 0;
    $rs = CdrPeer::doSelectRS($c);
    $this->maxNrOfConcurrentCalls = 0;
    while($rs->next()) {
      $callDateStamp = $rs->getTimestamp($callDateField);
      $callDate = strtotime($callDateStamp);
      $duration = $rs->getInt($durationField);
      $destinationType = $rs->getInt($destinationTypeField);
      $id = $rs->getInt($idField);
      
      // Skip unprocessed/ignored calls
      //
      if ($destinationType == DestinationType::unprocessed 
	  || $destinationType == DestinationType::ignored) {
	continue;
      }
      $this->totCalls++;
      
      $endDate = $callDate + $duration;

      $day = $this->getDateLabel($callDate);
      
      // Debug
      //
      //sfContext::getInstance()->getLogger()->info("At calldate: $callDateStamp ($callDate) is day $day");

      // Safety measure in case of calls after "now" time.
      //
      if (isset($this->nrOfTotCalls[$day])) {
	$this->nrOfTotCalls[$day]++;
      } else {
	$this->nrOfTotCalls[$day] = 1;
      }
      
      // Calc the number of concurrent calls.
      //
      // The ALGO works subsuming that the number of active calls is rather
      // limited (e.g. it stays in the cache of the CPU). They are put inside
      // $activeCalls array. It is scanned completely.
      //
      // It avoids heavy reorganization of the array using in-place insert of new
      // calls. The new calls replace old, not active calls.
      //
      $countConcurrentCalls = 1;
      $wasInserted = FALSE;
      foreach($activeCalls as $nid => $validDate) {
	if ($validDate < $callDate) {
	  if ($wasInserted == FALSE) {
	    $activeCalls[$nid] = $endDate;
	    $wasInserted = TRUE;
	  }
	} else {
	  $countConcurrentCalls++;
	}
      }
      
      if ($wasInserted == FALSE) {
	$activeCalls[$id] = $endDate;
      }
      
      // $this->nrOfConcurrentCalls[$day] contains the max number
      // of concurrent calls for the current day.
      //
      if (isset($this->nrOfConcurrentCalls[$day])) {
	if ($this->nrOfConcurrentCalls[$day] < $countConcurrentCalls) {
	  $this->nrOfConcurrentCalls[$day] = $countConcurrentCalls;
	}
      }
      
      // Update distribution of concurrent calls.
      //
      if (isset($this->concurrentCallsDistribution[$countConcurrentCalls])) {
	$this->concurrentCallsDistribution[$countConcurrentCalls]++;
      } else {
	$this->concurrentCallsDistribution[$countConcurrentCalls] = 1;
      }
      
      if ($this->maxNrOfConcurrentCalls < $countConcurrentCalls) {
	$this->maxNrOfConcurrentCalls = $countConcurrentCalls;
      }
    }
    
    $this->concurrentCallsSafeLimit = sfConfig::get('app_safe_limit_for_concurrent_calls');
    $this->dangerousCalls = $this->calcDangerousCalls($this->concurrentCallsDistribution, $this->concurrentCallsSafeLimit);

    // Debug 
    //
    //sfContext::getInstance()->getLogger()->info("ChannelUsage END");
  }

  /**
   * @return the number of calls happening when there 
   * were concurrent calls above the safe limit.
   * This are calls that can be potentially rejected.
   */
  protected function calcDangerousCalls() {
    $safeLimit = $this->concurrentCallsSafeLimit;
    $r = 0;

    foreach($this->concurrentCallsDistribution as $k => $v) {
      if ($k > $safeLimit) {
	$r += $v;
      }
    }
    
    return $r;
  }

}

?>