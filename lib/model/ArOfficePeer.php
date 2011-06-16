<?php

/**
 * Subclass for performing query and update operations on the 'ar_office' table.
 *
 * 
 *
 * @package lib.model
 */ 
class ArOfficePeer extends BaseArOfficePeer
{
    
    	static public function translateFieldName($name, $fromType, $toType)
	{
            if ($name == "party_name") {
                return "ar_party.name";
            } else {
                return BaseArOfficePeer::translateFieldName($name, $fromType, $toType);
            }
	}

}
