<?php
/**
 * @copyright Copyright (c) 2013 Sergey Cherepanov. (http://www.cherepanov.org.ua)
 * @license Creative Commons Attribution 3.0 License
 */

class Ch_Ems_Model_Carrier_Ems_Ru
    extends Mage_Shipping_Model_Carrier_Abstract
    implements Mage_Shipping_Model_Carrier_Interface
{
    const CARRIER_CODE  = 'ch_ems_ru';

    /** @var  Ch_Ems_Helper_Data */
    protected $_helper;
    /** @var  Ch_Ems_Model_Api_Ru */
    protected $_api;

    /**
     * @param array $data
     */
    public function __construct(array $data = array())
    {
        $this->_helper = Mage::helper('ch_ems');
        $this->_code   = self::CARRIER_CODE;
        parent::__construct($data);
    }

    /**
     * @return Ch_Ems_Model_Api_Ru
     */
    public function getApi()
    {
        if (is_null($this->_api)) {
            $this->_api = Mage::getModel('ch_ems/api_ru');
            $this->_api->setUri(trim(trim($this->getConfigData('api_uri')), '/'));
        }

        return $this->_api;
    }

    /**
     * CHeck is carrier enabled and service api available
     *
     * @return bool
     */
    protected function _isCarrierAvailable()
    {
        if ($this->getConfigFlag('active') && 'RU' == Mage::getStoreConfig('shipping/origin/country_id')) {
            return $this->getApi()->isAvailable();
        }

        return false;
    }

    /**
     * @param int $regionId
     * @param string $regionCode
     * @return bool|string
     */
    protected function _getEmsLocation($regionId, $regionCode)
    {
        $result = false;

        /** @var Ch_Ems_Model_Ems_Region $emsRegion */
        $emsRegion = Mage::getModel('ch_ems/ems_region');
        $emsRegion->load($regionId);
        if ($emsRegion->getId()) {
            $emsRegionCode = $emsRegion->getData('ems_code');
            if ($emsRegionCode) {
                $result = 'region--' . $emsRegionCode;
            } else if ($regionCode) {
                switch ($regionCode) {
                    case 'MOW':
                        // Is Moscow or Petersburg
                        $result = 'city--moskva';
                        break;
                    case 'SPE':
                        // Is Petersburg
                        $result = 'city--sankt-peterburg';
                        break;
                }
            }
        }

        return $result;
    }

    /**
     * @param Mage_Shipping_Model_Rate_Request $request
     * @return Mage_Shipping_Model_Rate_Result
     */
    public function collectRates(Mage_Shipping_Model_Rate_Request $request)
    {
        if (!$this->_isCarrierAvailable()) {
            return false;
        }


        /** @var Mage_Directory_Model_Region $storeRegion */
        $storeRegion = Mage::getModel('directory/region');
        $storeRegion->load(Mage::getStoreConfig('shipping/origin/region_id'));

        $emsFrom = $this->_getEmsLocation($storeRegion->getId(), $storeRegion->getCode());
        $emsTo   = $this->_getEmsLocation($request->getDestRegionId(), $request->getDestRegionCode());
        $packageWeight  = $request->getPackageWeight();


        if (!$emsFrom || !$emsTo) {
            return false;
        }

        $emsWeightInfo = $this->getApi()->makeRequest(array(
            'method' => Ch_Ems_Model_Api_Ru::REST_METHOD_GET_MAX_WEIGHT,
            'from'   => $emsFrom,
            'to'     => $emsTo,
        ));

        if ($packageWeight > $emsWeightInfo['max_weight']) {
            return false;
        }

        /** @var $result Mage_Shipping_Model_Rate_Result */
        $result = Mage::getModel('shipping/rate_result');

        $emsResponse = $this->getApi()->makeRequest(array(
            'method' => Ch_Ems_Model_Api_Ru::REST_METHOD_CALCULATE,
            'from'   => $emsFrom,
            'to'     => $emsTo,
            'weight' => $packageWeight
        ));

        /** @var $method Mage_Shipping_Model_Rate_Result_Method */
        $method = Mage::getModel('shipping/rate_result_method');
        $method->addData(array(
            'carrier'       => $this->_code,
            'carrier_title' => $this->getConfigData('name'),
            'method'        => 'default',
            'method_title'  => Mage::helper('ch_ems')->__(
                'Delivery %d - %d day(s)',
                $emsResponse['term']['min'],
                $emsResponse['term']['max']
            ),
            'price'         => (float) $emsResponse['price'],
            'cost'          => (float) $emsResponse['price'],
        ));
        $result->append($method);

        return $result;
    }

    public function getAllowedMethods()
    {
        return array($this->_code => $this->_helper->__('EMS Post'));
    }
}