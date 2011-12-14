<?php


abstract class BaseArInvoice extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $ar_party_id;


	
	protected $type = 'C';


	
	protected $is_revenue_sharing = false;


	
	protected $nr;


	
	protected $invoice_date;


	
	protected $ar_cdr_from;


	
	protected $ar_cdr_to;


	
	protected $total_bundle_without_tax = 0;


	
	protected $total_calls_without_tax = 0;


	
	protected $total_without_tax = 0;


	
	protected $vat_perc = 0;


	
	protected $total_vat = 0;


	
	protected $total = 0;


	
	protected $html_details;


	
	protected $pdf_invoice;


	
	protected $pdf_call_report;


	
	protected $email_subject;


	
	protected $email_message;


	
	protected $already_sent;


	
	protected $displayed_online;


	
	protected $info_or_ads_image1;


	
	protected $info_or_ads_image2;


	
	protected $ar_params_id;

	
	protected $aArParty;

	
	protected $aArParams;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getArPartyId()
	{

		return $this->ar_party_id;
	}

	
	public function getType()
	{

		return $this->type;
	}

	
	public function getIsRevenueSharing()
	{

		return $this->is_revenue_sharing;
	}

	
	public function getNr()
	{

		return $this->nr;
	}

	
	public function getInvoiceDate($format = 'Y-m-d')
	{

		if ($this->invoice_date === null || $this->invoice_date === '') {
			return null;
		} elseif (!is_int($this->invoice_date)) {
						$ts = strtotime($this->invoice_date);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [invoice_date] as date/time value: " . var_export($this->invoice_date, true));
			}
		} else {
			$ts = $this->invoice_date;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getArCdrFrom($format = 'Y-m-d')
	{

		if ($this->ar_cdr_from === null || $this->ar_cdr_from === '') {
			return null;
		} elseif (!is_int($this->ar_cdr_from)) {
						$ts = strtotime($this->ar_cdr_from);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [ar_cdr_from] as date/time value: " . var_export($this->ar_cdr_from, true));
			}
		} else {
			$ts = $this->ar_cdr_from;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getArCdrTo($format = 'Y-m-d')
	{

		if ($this->ar_cdr_to === null || $this->ar_cdr_to === '') {
			return null;
		} elseif (!is_int($this->ar_cdr_to)) {
						$ts = strtotime($this->ar_cdr_to);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [ar_cdr_to] as date/time value: " . var_export($this->ar_cdr_to, true));
			}
		} else {
			$ts = $this->ar_cdr_to;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getTotalBundleWithoutTax()
	{

		return $this->total_bundle_without_tax;
	}

	
	public function getTotalCallsWithoutTax()
	{

		return $this->total_calls_without_tax;
	}

	
	public function getTotalWithoutTax()
	{

		return $this->total_without_tax;
	}

	
	public function getVatPerc()
	{

		return $this->vat_perc;
	}

	
	public function getTotalVat()
	{

		return $this->total_vat;
	}

	
	public function getTotal()
	{

		return $this->total;
	}

	
	public function getHtmlDetails()
	{

		return $this->html_details;
	}

	
	public function getPdfInvoice()
	{

		return $this->pdf_invoice;
	}

	
	public function getPdfCallReport()
	{

		return $this->pdf_call_report;
	}

	
	public function getEmailSubject()
	{

		return $this->email_subject;
	}

	
	public function getEmailMessage()
	{

		return $this->email_message;
	}

	
	public function getAlreadySent()
	{

		return $this->already_sent;
	}

	
	public function getDisplayedOnline()
	{

		return $this->displayed_online;
	}

	
	public function getInfoOrAdsImage1()
	{

		return $this->info_or_ads_image1;
	}

	
	public function getInfoOrAdsImage2()
	{

		return $this->info_or_ads_image2;
	}

	
	public function getArParamsId()
	{

		return $this->ar_params_id;
	}

	
	public function setId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = ArInvoicePeer::ID;
		}

	} 
	
	public function setArPartyId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->ar_party_id !== $v) {
			$this->ar_party_id = $v;
			$this->modifiedColumns[] = ArInvoicePeer::AR_PARTY_ID;
		}

		if ($this->aArParty !== null && $this->aArParty->getId() !== $v) {
			$this->aArParty = null;
		}

	} 
	
	public function setType($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->type !== $v || $v === 'C') {
			$this->type = $v;
			$this->modifiedColumns[] = ArInvoicePeer::TYPE;
		}

	} 
	
	public function setIsRevenueSharing($v)
	{

		if ($this->is_revenue_sharing !== $v || $v === false) {
			$this->is_revenue_sharing = $v;
			$this->modifiedColumns[] = ArInvoicePeer::IS_REVENUE_SHARING;
		}

	} 
	
	public function setNr($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->nr !== $v) {
			$this->nr = $v;
			$this->modifiedColumns[] = ArInvoicePeer::NR;
		}

	} 
	
	public function setInvoiceDate($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [invoice_date] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->invoice_date !== $ts) {
			$this->invoice_date = $ts;
			$this->modifiedColumns[] = ArInvoicePeer::INVOICE_DATE;
		}

	} 
	
	public function setArCdrFrom($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [ar_cdr_from] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->ar_cdr_from !== $ts) {
			$this->ar_cdr_from = $ts;
			$this->modifiedColumns[] = ArInvoicePeer::AR_CDR_FROM;
		}

	} 
	
	public function setArCdrTo($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [ar_cdr_to] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->ar_cdr_to !== $ts) {
			$this->ar_cdr_to = $ts;
			$this->modifiedColumns[] = ArInvoicePeer::AR_CDR_TO;
		}

	} 
	
	public function setTotalBundleWithoutTax($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->total_bundle_without_tax !== $v || $v === 0) {
			$this->total_bundle_without_tax = $v;
			$this->modifiedColumns[] = ArInvoicePeer::TOTAL_BUNDLE_WITHOUT_TAX;
		}

	} 
	
	public function setTotalCallsWithoutTax($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->total_calls_without_tax !== $v || $v === 0) {
			$this->total_calls_without_tax = $v;
			$this->modifiedColumns[] = ArInvoicePeer::TOTAL_CALLS_WITHOUT_TAX;
		}

	} 
	
	public function setTotalWithoutTax($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->total_without_tax !== $v || $v === 0) {
			$this->total_without_tax = $v;
			$this->modifiedColumns[] = ArInvoicePeer::TOTAL_WITHOUT_TAX;
		}

	} 
	
	public function setVatPerc($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->vat_perc !== $v || $v === 0) {
			$this->vat_perc = $v;
			$this->modifiedColumns[] = ArInvoicePeer::VAT_PERC;
		}

	} 
	
	public function setTotalVat($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->total_vat !== $v || $v === 0) {
			$this->total_vat = $v;
			$this->modifiedColumns[] = ArInvoicePeer::TOTAL_VAT;
		}

	} 
	
	public function setTotal($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->total !== $v || $v === 0) {
			$this->total = $v;
			$this->modifiedColumns[] = ArInvoicePeer::TOTAL;
		}

	} 
	
	public function setHtmlDetails($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->html_details !== $v) {
			$this->html_details = $v;
			$this->modifiedColumns[] = ArInvoicePeer::HTML_DETAILS;
		}

	} 
	
	public function setPdfInvoice($v)
	{

								if ($v instanceof Lob && $v === $this->pdf_invoice) {
			$changed = $v->isModified();
		} else {
			$changed = ($this->pdf_invoice !== $v);
		}
		if ($changed) {
			if ( !($v instanceof Lob) ) {
				$obj = new Blob();
				$obj->setContents($v);
			} else {
				$obj = $v;
			}
			$this->pdf_invoice = $obj;
			$this->modifiedColumns[] = ArInvoicePeer::PDF_INVOICE;
		}

	} 
	
	public function setPdfCallReport($v)
	{

								if ($v instanceof Lob && $v === $this->pdf_call_report) {
			$changed = $v->isModified();
		} else {
			$changed = ($this->pdf_call_report !== $v);
		}
		if ($changed) {
			if ( !($v instanceof Lob) ) {
				$obj = new Blob();
				$obj->setContents($v);
			} else {
				$obj = $v;
			}
			$this->pdf_call_report = $obj;
			$this->modifiedColumns[] = ArInvoicePeer::PDF_CALL_REPORT;
		}

	} 
	
	public function setEmailSubject($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->email_subject !== $v) {
			$this->email_subject = $v;
			$this->modifiedColumns[] = ArInvoicePeer::EMAIL_SUBJECT;
		}

	} 
	
	public function setEmailMessage($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->email_message !== $v) {
			$this->email_message = $v;
			$this->modifiedColumns[] = ArInvoicePeer::EMAIL_MESSAGE;
		}

	} 
	
	public function setAlreadySent($v)
	{

		if ($this->already_sent !== $v) {
			$this->already_sent = $v;
			$this->modifiedColumns[] = ArInvoicePeer::ALREADY_SENT;
		}

	} 
	
	public function setDisplayedOnline($v)
	{

		if ($this->displayed_online !== $v) {
			$this->displayed_online = $v;
			$this->modifiedColumns[] = ArInvoicePeer::DISPLAYED_ONLINE;
		}

	} 
	
	public function setInfoOrAdsImage1($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->info_or_ads_image1 !== $v) {
			$this->info_or_ads_image1 = $v;
			$this->modifiedColumns[] = ArInvoicePeer::INFO_OR_ADS_IMAGE1;
		}

	} 
	
	public function setInfoOrAdsImage2($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->info_or_ads_image2 !== $v) {
			$this->info_or_ads_image2 = $v;
			$this->modifiedColumns[] = ArInvoicePeer::INFO_OR_ADS_IMAGE2;
		}

	} 
	
	public function setArParamsId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->ar_params_id !== $v) {
			$this->ar_params_id = $v;
			$this->modifiedColumns[] = ArInvoicePeer::AR_PARAMS_ID;
		}

		if ($this->aArParams !== null && $this->aArParams->getId() !== $v) {
			$this->aArParams = null;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->ar_party_id = $rs->getInt($startcol + 1);

			$this->type = $rs->getString($startcol + 2);

			$this->is_revenue_sharing = $rs->getBoolean($startcol + 3);

			$this->nr = $rs->getString($startcol + 4);

			$this->invoice_date = $rs->getDate($startcol + 5, null);

			$this->ar_cdr_from = $rs->getDate($startcol + 6, null);

			$this->ar_cdr_to = $rs->getDate($startcol + 7, null);

			$this->total_bundle_without_tax = $rs->getInt($startcol + 8);

			$this->total_calls_without_tax = $rs->getInt($startcol + 9);

			$this->total_without_tax = $rs->getInt($startcol + 10);

			$this->vat_perc = $rs->getInt($startcol + 11);

			$this->total_vat = $rs->getInt($startcol + 12);

			$this->total = $rs->getInt($startcol + 13);

			$this->html_details = $rs->getString($startcol + 14);

			$this->pdf_invoice = $rs->getBlob($startcol + 15);

			$this->pdf_call_report = $rs->getBlob($startcol + 16);

			$this->email_subject = $rs->getString($startcol + 17);

			$this->email_message = $rs->getString($startcol + 18);

			$this->already_sent = $rs->getBoolean($startcol + 19);

			$this->displayed_online = $rs->getBoolean($startcol + 20);

			$this->info_or_ads_image1 = $rs->getString($startcol + 21);

			$this->info_or_ads_image2 = $rs->getString($startcol + 22);

			$this->ar_params_id = $rs->getInt($startcol + 23);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 24; 
		} catch (Exception $e) {
			throw new PropelException("Error populating ArInvoice object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(ArInvoicePeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			ArInvoicePeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	public function save($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(ArInvoicePeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	protected function doSave($con)
	{
		$affectedRows = 0; 		if (!$this->alreadyInSave) {
			$this->alreadyInSave = true;


												
			if ($this->aArParty !== null) {
				if ($this->aArParty->isModified()) {
					$affectedRows += $this->aArParty->save($con);
				}
				$this->setArParty($this->aArParty);
			}

			if ($this->aArParams !== null) {
				if ($this->aArParams->isModified()) {
					$affectedRows += $this->aArParams->save($con);
				}
				$this->setArParams($this->aArParams);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = ArInvoicePeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += ArInvoicePeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			$this->alreadyInSave = false;
		}
		return $affectedRows;
	} 
	
	protected $validationFailures = array();

	
	public function getValidationFailures()
	{
		return $this->validationFailures;
	}

	
	public function validate($columns = null)
	{
		$res = $this->doValidate($columns);
		if ($res === true) {
			$this->validationFailures = array();
			return true;
		} else {
			$this->validationFailures = $res;
			return false;
		}
	}

	
	protected function doValidate($columns = null)
	{
		if (!$this->alreadyInValidation) {
			$this->alreadyInValidation = true;
			$retval = null;

			$failureMap = array();


												
			if ($this->aArParty !== null) {
				if (!$this->aArParty->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aArParty->getValidationFailures());
				}
			}

			if ($this->aArParams !== null) {
				if (!$this->aArParams->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aArParams->getValidationFailures());
				}
			}


			if (($retval = ArInvoicePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ArInvoicePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getArPartyId();
				break;
			case 2:
				return $this->getType();
				break;
			case 3:
				return $this->getIsRevenueSharing();
				break;
			case 4:
				return $this->getNr();
				break;
			case 5:
				return $this->getInvoiceDate();
				break;
			case 6:
				return $this->getArCdrFrom();
				break;
			case 7:
				return $this->getArCdrTo();
				break;
			case 8:
				return $this->getTotalBundleWithoutTax();
				break;
			case 9:
				return $this->getTotalCallsWithoutTax();
				break;
			case 10:
				return $this->getTotalWithoutTax();
				break;
			case 11:
				return $this->getVatPerc();
				break;
			case 12:
				return $this->getTotalVat();
				break;
			case 13:
				return $this->getTotal();
				break;
			case 14:
				return $this->getHtmlDetails();
				break;
			case 15:
				return $this->getPdfInvoice();
				break;
			case 16:
				return $this->getPdfCallReport();
				break;
			case 17:
				return $this->getEmailSubject();
				break;
			case 18:
				return $this->getEmailMessage();
				break;
			case 19:
				return $this->getAlreadySent();
				break;
			case 20:
				return $this->getDisplayedOnline();
				break;
			case 21:
				return $this->getInfoOrAdsImage1();
				break;
			case 22:
				return $this->getInfoOrAdsImage2();
				break;
			case 23:
				return $this->getArParamsId();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ArInvoicePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getArPartyId(),
			$keys[2] => $this->getType(),
			$keys[3] => $this->getIsRevenueSharing(),
			$keys[4] => $this->getNr(),
			$keys[5] => $this->getInvoiceDate(),
			$keys[6] => $this->getArCdrFrom(),
			$keys[7] => $this->getArCdrTo(),
			$keys[8] => $this->getTotalBundleWithoutTax(),
			$keys[9] => $this->getTotalCallsWithoutTax(),
			$keys[10] => $this->getTotalWithoutTax(),
			$keys[11] => $this->getVatPerc(),
			$keys[12] => $this->getTotalVat(),
			$keys[13] => $this->getTotal(),
			$keys[14] => $this->getHtmlDetails(),
			$keys[15] => $this->getPdfInvoice(),
			$keys[16] => $this->getPdfCallReport(),
			$keys[17] => $this->getEmailSubject(),
			$keys[18] => $this->getEmailMessage(),
			$keys[19] => $this->getAlreadySent(),
			$keys[20] => $this->getDisplayedOnline(),
			$keys[21] => $this->getInfoOrAdsImage1(),
			$keys[22] => $this->getInfoOrAdsImage2(),
			$keys[23] => $this->getArParamsId(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ArInvoicePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setArPartyId($value);
				break;
			case 2:
				$this->setType($value);
				break;
			case 3:
				$this->setIsRevenueSharing($value);
				break;
			case 4:
				$this->setNr($value);
				break;
			case 5:
				$this->setInvoiceDate($value);
				break;
			case 6:
				$this->setArCdrFrom($value);
				break;
			case 7:
				$this->setArCdrTo($value);
				break;
			case 8:
				$this->setTotalBundleWithoutTax($value);
				break;
			case 9:
				$this->setTotalCallsWithoutTax($value);
				break;
			case 10:
				$this->setTotalWithoutTax($value);
				break;
			case 11:
				$this->setVatPerc($value);
				break;
			case 12:
				$this->setTotalVat($value);
				break;
			case 13:
				$this->setTotal($value);
				break;
			case 14:
				$this->setHtmlDetails($value);
				break;
			case 15:
				$this->setPdfInvoice($value);
				break;
			case 16:
				$this->setPdfCallReport($value);
				break;
			case 17:
				$this->setEmailSubject($value);
				break;
			case 18:
				$this->setEmailMessage($value);
				break;
			case 19:
				$this->setAlreadySent($value);
				break;
			case 20:
				$this->setDisplayedOnline($value);
				break;
			case 21:
				$this->setInfoOrAdsImage1($value);
				break;
			case 22:
				$this->setInfoOrAdsImage2($value);
				break;
			case 23:
				$this->setArParamsId($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ArInvoicePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setArPartyId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setType($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setIsRevenueSharing($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setNr($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setInvoiceDate($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setArCdrFrom($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setArCdrTo($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setTotalBundleWithoutTax($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setTotalCallsWithoutTax($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setTotalWithoutTax($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setVatPerc($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setTotalVat($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setTotal($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setHtmlDetails($arr[$keys[14]]);
		if (array_key_exists($keys[15], $arr)) $this->setPdfInvoice($arr[$keys[15]]);
		if (array_key_exists($keys[16], $arr)) $this->setPdfCallReport($arr[$keys[16]]);
		if (array_key_exists($keys[17], $arr)) $this->setEmailSubject($arr[$keys[17]]);
		if (array_key_exists($keys[18], $arr)) $this->setEmailMessage($arr[$keys[18]]);
		if (array_key_exists($keys[19], $arr)) $this->setAlreadySent($arr[$keys[19]]);
		if (array_key_exists($keys[20], $arr)) $this->setDisplayedOnline($arr[$keys[20]]);
		if (array_key_exists($keys[21], $arr)) $this->setInfoOrAdsImage1($arr[$keys[21]]);
		if (array_key_exists($keys[22], $arr)) $this->setInfoOrAdsImage2($arr[$keys[22]]);
		if (array_key_exists($keys[23], $arr)) $this->setArParamsId($arr[$keys[23]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(ArInvoicePeer::DATABASE_NAME);

		if ($this->isColumnModified(ArInvoicePeer::ID)) $criteria->add(ArInvoicePeer::ID, $this->id);
		if ($this->isColumnModified(ArInvoicePeer::AR_PARTY_ID)) $criteria->add(ArInvoicePeer::AR_PARTY_ID, $this->ar_party_id);
		if ($this->isColumnModified(ArInvoicePeer::TYPE)) $criteria->add(ArInvoicePeer::TYPE, $this->type);
		if ($this->isColumnModified(ArInvoicePeer::IS_REVENUE_SHARING)) $criteria->add(ArInvoicePeer::IS_REVENUE_SHARING, $this->is_revenue_sharing);
		if ($this->isColumnModified(ArInvoicePeer::NR)) $criteria->add(ArInvoicePeer::NR, $this->nr);
		if ($this->isColumnModified(ArInvoicePeer::INVOICE_DATE)) $criteria->add(ArInvoicePeer::INVOICE_DATE, $this->invoice_date);
		if ($this->isColumnModified(ArInvoicePeer::AR_CDR_FROM)) $criteria->add(ArInvoicePeer::AR_CDR_FROM, $this->ar_cdr_from);
		if ($this->isColumnModified(ArInvoicePeer::AR_CDR_TO)) $criteria->add(ArInvoicePeer::AR_CDR_TO, $this->ar_cdr_to);
		if ($this->isColumnModified(ArInvoicePeer::TOTAL_BUNDLE_WITHOUT_TAX)) $criteria->add(ArInvoicePeer::TOTAL_BUNDLE_WITHOUT_TAX, $this->total_bundle_without_tax);
		if ($this->isColumnModified(ArInvoicePeer::TOTAL_CALLS_WITHOUT_TAX)) $criteria->add(ArInvoicePeer::TOTAL_CALLS_WITHOUT_TAX, $this->total_calls_without_tax);
		if ($this->isColumnModified(ArInvoicePeer::TOTAL_WITHOUT_TAX)) $criteria->add(ArInvoicePeer::TOTAL_WITHOUT_TAX, $this->total_without_tax);
		if ($this->isColumnModified(ArInvoicePeer::VAT_PERC)) $criteria->add(ArInvoicePeer::VAT_PERC, $this->vat_perc);
		if ($this->isColumnModified(ArInvoicePeer::TOTAL_VAT)) $criteria->add(ArInvoicePeer::TOTAL_VAT, $this->total_vat);
		if ($this->isColumnModified(ArInvoicePeer::TOTAL)) $criteria->add(ArInvoicePeer::TOTAL, $this->total);
		if ($this->isColumnModified(ArInvoicePeer::HTML_DETAILS)) $criteria->add(ArInvoicePeer::HTML_DETAILS, $this->html_details);
		if ($this->isColumnModified(ArInvoicePeer::PDF_INVOICE)) $criteria->add(ArInvoicePeer::PDF_INVOICE, $this->pdf_invoice);
		if ($this->isColumnModified(ArInvoicePeer::PDF_CALL_REPORT)) $criteria->add(ArInvoicePeer::PDF_CALL_REPORT, $this->pdf_call_report);
		if ($this->isColumnModified(ArInvoicePeer::EMAIL_SUBJECT)) $criteria->add(ArInvoicePeer::EMAIL_SUBJECT, $this->email_subject);
		if ($this->isColumnModified(ArInvoicePeer::EMAIL_MESSAGE)) $criteria->add(ArInvoicePeer::EMAIL_MESSAGE, $this->email_message);
		if ($this->isColumnModified(ArInvoicePeer::ALREADY_SENT)) $criteria->add(ArInvoicePeer::ALREADY_SENT, $this->already_sent);
		if ($this->isColumnModified(ArInvoicePeer::DISPLAYED_ONLINE)) $criteria->add(ArInvoicePeer::DISPLAYED_ONLINE, $this->displayed_online);
		if ($this->isColumnModified(ArInvoicePeer::INFO_OR_ADS_IMAGE1)) $criteria->add(ArInvoicePeer::INFO_OR_ADS_IMAGE1, $this->info_or_ads_image1);
		if ($this->isColumnModified(ArInvoicePeer::INFO_OR_ADS_IMAGE2)) $criteria->add(ArInvoicePeer::INFO_OR_ADS_IMAGE2, $this->info_or_ads_image2);
		if ($this->isColumnModified(ArInvoicePeer::AR_PARAMS_ID)) $criteria->add(ArInvoicePeer::AR_PARAMS_ID, $this->ar_params_id);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(ArInvoicePeer::DATABASE_NAME);

		$criteria->add(ArInvoicePeer::ID, $this->id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		return $this->getId();
	}

	
	public function setPrimaryKey($key)
	{
		$this->setId($key);
	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setArPartyId($this->ar_party_id);

		$copyObj->setType($this->type);

		$copyObj->setIsRevenueSharing($this->is_revenue_sharing);

		$copyObj->setNr($this->nr);

		$copyObj->setInvoiceDate($this->invoice_date);

		$copyObj->setArCdrFrom($this->ar_cdr_from);

		$copyObj->setArCdrTo($this->ar_cdr_to);

		$copyObj->setTotalBundleWithoutTax($this->total_bundle_without_tax);

		$copyObj->setTotalCallsWithoutTax($this->total_calls_without_tax);

		$copyObj->setTotalWithoutTax($this->total_without_tax);

		$copyObj->setVatPerc($this->vat_perc);

		$copyObj->setTotalVat($this->total_vat);

		$copyObj->setTotal($this->total);

		$copyObj->setHtmlDetails($this->html_details);

		$copyObj->setPdfInvoice($this->pdf_invoice);

		$copyObj->setPdfCallReport($this->pdf_call_report);

		$copyObj->setEmailSubject($this->email_subject);

		$copyObj->setEmailMessage($this->email_message);

		$copyObj->setAlreadySent($this->already_sent);

		$copyObj->setDisplayedOnline($this->displayed_online);

		$copyObj->setInfoOrAdsImage1($this->info_or_ads_image1);

		$copyObj->setInfoOrAdsImage2($this->info_or_ads_image2);

		$copyObj->setArParamsId($this->ar_params_id);


		$copyObj->setNew(true);

		$copyObj->setId(NULL); 
	}

	
	public function copy($deepCopy = false)
	{
				$clazz = get_class($this);
		$copyObj = new $clazz();
		$this->copyInto($copyObj, $deepCopy);
		return $copyObj;
	}

	
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new ArInvoicePeer();
		}
		return self::$peer;
	}

	
	public function setArParty($v)
	{


		if ($v === null) {
			$this->setArPartyId(NULL);
		} else {
			$this->setArPartyId($v->getId());
		}


		$this->aArParty = $v;
	}


	
	public function getArParty($con = null)
	{
		if ($this->aArParty === null && ($this->ar_party_id !== null)) {
						include_once 'lib/model/om/BaseArPartyPeer.php';

			$this->aArParty = ArPartyPeer::retrieveByPK($this->ar_party_id, $con);

			
		}
		return $this->aArParty;
	}

	
	public function setArParams($v)
	{


		if ($v === null) {
			$this->setArParamsId(NULL);
		} else {
			$this->setArParamsId($v->getId());
		}


		$this->aArParams = $v;
	}


	
	public function getArParams($con = null)
	{
		if ($this->aArParams === null && ($this->ar_params_id !== null)) {
						include_once 'lib/model/om/BaseArParamsPeer.php';

			$this->aArParams = ArParamsPeer::retrieveByPK($this->ar_params_id, $con);

			
		}
		return $this->aArParams;
	}

} 