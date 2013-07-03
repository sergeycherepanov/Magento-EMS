<?php
/**
 * @copyright Copyright (c) 2013 Sergey Cherepanov. (http://www.cherepanov.org.ua)
 * @license Creative Commons Attribution 3.0 License
 */

class Ch_Ems_Model_Resource_Ems_Region
    extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('ch_ems/ems_region', 'region_id');
    }
}