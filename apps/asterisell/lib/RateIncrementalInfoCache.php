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

/**
 * Speed up retrieving and updating of ar_rate_incremental_info records,
 * storing previous retrieved information in a cache.
 *
 * It signal a conflict error if the CDR are not retrieved in ascending order of cdr.calldate first,
 * and cdr.id later.
 */
class RateIncrementalInfoCache {

  /**
   * Store a index for each
   *
   *   { ar_party_id =>
   *       { ar_rate_id =>
   *         { period =>
   *           { ar_rate_incremental_info.id, last_processed_cdr_date, last_processed_cdr_id, phpBundleRate } } } }
   */
  protected $cache = array();

  /**
   * Return a value in the cache, invalidating the ArRateIncrementalInfo record.
   * Signal if there is a corruption in the cache, because the requested CDR are not consecutives.
   *
   * Use always this function for retrieving data, because it updates the incremental data with
   * the last info about the processed Cdr.
   *
   * Update directly the returned $rateInfo object, in order to upgrade the copy on the cache.
   *
   * At the end of processing of all calls, use closeAndUpdateDatabase() function.
   *
   * @param  BundleRate $bundleRate
   * @param  $partyId
   * @param  $rateId
   * @param  Cdr $cdr
   * @param  $period
   * @return list($rateInfoId, $rateInfo, $isCorrupted)
   */
  public function get(BundleRate $bundleRate, $partyId, $rateId, Cdr $cdr, $period) {

    // Search in cache
    //
    $foundInCache = false;
    $isCorrupted = false;

    $cachedArRateIncrementalInfoId = null;
    $cachedLastProcessedCdrDate = null;
    $cachedLastProcessedCdrId = null;
    $cachedPhpBundleRate = null;

    if (array_key_exists($partyId, $this->cache)) {
      if (array_key_exists($rateId, $this->cache[$partyId])) {
        if (array_key_exists($period, $this->cache[$partyId][$rateId])) {
          list($cachedArRateIncrementalInfoId, $cachedLastProcessedCdrDate, $cachedLastProcessedCdrId, $cachedPhpBundleRate) = $this->cache[$partyId][$rateId][$period];
          $foundInCache = true;
        }
      }
    }

    // Search in database
    //
    if ($foundInCache == false) {

      $c = new Criteria();
      $c->add(ArRateIncrementalInfoPeer::AR_PARTY_ID, $partyId);
      $c->add(ArRateIncrementalInfoPeer::AR_RATE_ID, $rateId);
      $c->add(ArRateIncrementalInfoPeer::PERIOD, $period);
      $record = ArRateIncrementalInfoPeer::doSelectOne($c);

      if (is_null($record)) {
        $cachedLastProcessedCdrDate = strtotime($cdr->getCalldate());
        $cachedLastProcessedCdrId = $cdr->getId();
        $cachedPhpBundleRate = $bundleRate->getEmptyIncrementalInfo($partyId, $rateId, $period);

        // Add a new record in database
        $record = new ArRateIncrementalInfo();
        $record->setArPartyId($partyId);
        $record->setArRateId($rateId);
        $record->setPeriod($period);
        $record->setBundleRate(serialize($cachedPhpBundleRate));

        // Mark the record as under processing
        $record->setLastProcessedCdrDate(null);
        $record->save();

        // this field make sense only after save
        $cachedArRateIncrementalInfoId = $record->getId();

      } else {
        // Found a record in the database
        //

        $cachedLastProcessedCdrDate = strtotime($record->getLastProcessedCdrDate());
        $cachedLastProcessedCdrId = $record->getLastProcessedCdrId();
        $cachedPhpBundleRate = $record->unserializeBundleRate();
        $cachedArRateIncrementalInfoId = $record->getId();

        if (is_null($record->getLastProcessedCdrDate())) {
          $isCorrupted = true;
          // This is an "old" invalidated incremental info record.
          // Usually you encounter this when there were an error during rating
          // that stopped the process with a PHP exception, leaving the
          // database in a inconsistent state.
        }

        // Mark the record as under processing
        $record->setLastProcessedCdrDate(null);
        $record->save();

      }

      // Update/Complete the cache with the record value
      $this->cache[$partyId][$rateId][$period] = array($cachedArRateIncrementalInfoId, $cachedLastProcessedCdrDate, $cachedLastProcessedCdrId, $cachedPhpBundleRate);
    }

    // Check if there is cache conflict.
    // Record CDR must be processed sequentially according call date fist, and id last.
    //
    $cdrCallDate = strtotime($cdr->getCalldate());
    if ($isCorrupted == false) {
      if ($cdrCallDate < $cachedLastProcessedCdrDate) {
        $isCorrupted = true;
      } else if ($cdrCallDate == $cachedLastProcessedCdrDate && $cdr->getId() < $cachedLastProcessedCdrId) {
        $isCorrupted = true;
      }
    }

    // Update the cache with Cdr content
    //
    $this->cache[$partyId][$rateId][$period][1] = $cdrCallDate;
    $this->cache[$partyId][$rateId][$period][2] = $cdr->getId();

    // Return the result
    //
    return array($cachedArRateIncrementalInfoId, $cachedPhpBundleRate, $isCorrupted);
  }

  /**
   * Close the cache and save the state on the database.
   * If this method is not invoked (for example a severe error during rate processing)
   * then CDRs will (correctly) re-rated at next pass, because there is a not correct
   * period.
   *
   * @return void
   */
  public function closeAndUpdateDatabase() {
    // *   { ar_party_id =>
    // *       { ar_rate_id =>
    // *         { period =>
    // *           { ar_rate_incremental_info.id, last_processed_cdr_date, last_processed_cdr_id, phpBundleRate } } } }

    try {
      foreach ($this->cache as $partyId => $arr1) {
        foreach ($arr1 as $arRateId => $arr2) {
          foreach ($arr2 as $period => $values) {
            // cache value
            $cachedIncrementalInfoId = $values[0];
            $cachedLastProcessedCdrDate = $values[1];
            $cachedLastProcessedCdrId = $values[2];
            $cachedPhpBundleRate = $values[3];

            // retrieve the record from the database
            $record = ArRateIncrementalInfoPeer::retrieveByPk($cachedIncrementalInfoId);

            // some check
            if (!($partyId == $record->getArPartyId() && $arRateId == $record->getArRateId() && $period == $record->getPeriod())) {
              $p = new ArProblem();
              $p->setDuplicationKey("RateIncrementalInfoCache - unexpected fields in database");
              $p->setDescription('Unexpected Error during closeAndUpdateDatabase of RateIncrementalInfoCache on database fields.');
              $p->setEffect("Affected CDRs will be not rated.");
              $p->setProposedSolution("Contact the developer, because this is a code error.");
              ArProblemException::signalProblemWithException($p);
            }

            // update the database data
            $record->setLastProcessedCdrDate($cachedLastProcessedCdrDate);
            $record->setLastProcessedCdrId($cachedLastProcessedCdrId);
            $record->setBundleRate(serialize($cachedPhpBundleRate));
            $record->save();
          }
        }
      }

    } catch (Exception $e) {
      $p = new ArProblem();
      $p->setDuplicationKey("RateIncrementalInfoCache " . $e->getCode());
      $p->setDescription('Error during closeAndUpdateDatabase of RateIncrementalInfoCache: ' . $e->getMessage() . ' - ' . $e->getTraceAsString());
      $p->setEffect("If the error is a not repeating error, there is no effect. At the next run of the job processor the remaining CDRs will be rated. If this is a recurring error, then there is an error inside the code and the affected CDRs will be not rated.");
      $p->setProposedSolution("Delete the error table. If the error is recuring, contact the developer, because this is a code error.");
      ArProblemException::signalProblemWithException($p);
    }
  }

}

?>