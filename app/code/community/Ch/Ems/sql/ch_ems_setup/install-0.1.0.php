<?php
/**
 * @copyright Copyright (c) 2013 Sergey Cherepanov. (http://www.cherepanov.org.ua)
 * @license Creative Commons Attribution 3.0 License
 */

/* @var $this Mage_Core_Model_Resource_Setup */
$this->startSetup();
/** @var Varien_Db_Adapter_Pdo_Mysql $connection */
$connection = $this->getConnection();

$regions = array(
    array("Москва", "MOW", ""),
    array("Санкт-Петербург", "SPE", ""),
    array("Республика Адыгея", "AD", "respublika-adygeja"),
    array("Республика Башкортостан", "BA", "respublika-bashkortostan"),
    array("Республика Бурятия", "BU", "respublika-burjatija"),
    array("Республика Алтай", "AL", "respublika-altaj"),
    array("Республика Дагестан", "DA", "respublika-dagestan"),
    array("Республика Ингушетия", "IN", "respublika-ingushetija"),
    array("Кабардино-Балкарская республика", "KB", "kabardino-balkarskaja-respublika"),
    array("Республика Калмыкия", "KL", "respublika-kalmykija"),
    array("Карачаево-Черкесская республика", "KC", "karachaevo-cherkesskaja-respublika"),
    array("Республика Карелия", "KR", "respublika-karelija"),
    array("Республика Коми", "KO", "respublika-komi"),
    array("Республика Марий Эл", "ME", "respublika-marij-el"),
    array("Республика Мордовия", "MO", "respublika-mordovija"),
    array("Республика Саха (Якутия)", "SA", "respublika-saha-yakutija"),
    array("Республика Северная Осетия — Алания", "SE", "respublika-sev.osetija-alanija"),
    array("Республика Татарстан", "TA", "respublika-tatarstan"),
    array("Республика Тыва", "TY", "respublika-tyva"),
    array("Удмуртская республика", "UD", "udmurtskaja-respublika"),
    array("Республика Хакасия", "KK", "respublika-khakasija"),
    array("Чеченская республика", "CE", "chechenskaya-respublika"),
    array("Чувашская республика", "CU", "chuvashskaja-respublika"),
    array("Алтайский край", "ALT", "altajskij-kraj"),
    array("Забайкальский край", "ZAB", "zabajkalskij-kraj"),
    array("Камчатский край", "KAM", "kamchatskij-kraj"),
    array("Краснодарский край", "KDA", "krasnodarskij-kraj"),
    array("Красноярский край", "KYA", "krasnojarskij-kraj"),
    array("Пермский край", "PER", "permskij-kraj"),
    array("Приморский край", "PRI", "primorskij-kraj"),
    array("Ставропольский край", "STA", "stavropolskij-kraj"),
    array("Хабаровский край", "KHA", "khabarovskij-kraj"),
    array("Амурская область", "AMU", "amurskaja-oblast"),
    array("Архангельская область", "ARK", "arhangelskaja-oblast"),
    array("Астраханская область", "AST", "astrahanskaja-oblast"),
    array("Белгородская область", "BEL", "belgorodskaja-oblast"),
    array("Брянская область", "BRY", "brjanskaja-oblast"),
    array("Владимирская область", "VLA", "vladimirskaja-oblast"),
    array("Волгоградская область", "VGG", "volgogradskaja-oblast"),
    array("Вологодская область", "VLG", "vologodskaja-oblast"),
    array("Воронежская область", "VOR", "voronezhskaja-oblast"),
    array("Ивановская область", "IVA", "ivanovskaja-oblast"),
    array("Иркутская область", "IRK", "irkutskaja-oblast"),
    array("Калининградская область", "KGD", "kaliningradskaja-oblast"),
    array("Калужская область", "KLU", "kaluzhskaja-oblast"),
    array("Кемеровская область", "KEM", "kemerovskaja-oblast"),
    array("Кировская область", "KIR", "kirovskaja-oblast"),
    array("Костромская область", "KOS", "kostromskaja-oblast"),
    array("Курганская область", "KGN", "kurganskaja-oblast"),
    array("Курская область", "KRS", "kurskaja-oblast"),
    array("Ленинградская область", "LEN", "leningradskaja-oblast"),
    array("Липецкая область", "LIP", "lipeckaja-oblast"),
    array("Магаданская область", "MAG", "magadanskaja-oblast"),
    array("Московская область", "MOS", "moskovskaja-oblast"),
    array("Мурманская область", "MUR", "murmanskaja-oblast"),
    array("Нижегородская область", "NIZ", "nizhegorodskaja-oblast"),
    array("Новгородская область", "NGR", "novgorodskaja-oblast"),
    array("Новосибирская область", "NVS", "novosibirskaja-oblast"),
    array("Омская область", "OMS", "omskaja-oblast"),
    array("Оренбургская область", "ORE", "orenburgskaja-oblast"),
    array("Орловская область", "ORL", "orlovskaja-oblast"),
    array("Пензенская область", "PNZ", "penzenskaja-oblast"),
    array("Псковская область", "PSK", "pskovskaja-oblast"),
    array("Ростовская область", "ROS", "rostovskaja-oblast"),
    array("Рязанская область", "RYA", "rjazanskaja-oblast"),
    array("Самарская область", "SAM", "samarskaja-oblast"),
    array("Саратовская область", "SAR", "saratovskaja-oblast"),
    array("Сахалинская область", "SAK", "sahalinskaja-oblast"),
    array("Свердловская область", "SVE", "sverdlovskaja-oblast"),
    array("Смоленская область", "SMO", "smolenskaja-oblast"),
    array("Тамбовская область", "TAM", "tambovskaja-oblast"),
    array("Тверская область", "TVE", "tverskaja-oblast"),
    array("Томская область", "TOM", "tomskaja-oblast"),
    array("Тульская область", "TUL", "tulskaja-oblast"),
    array("Тюменская область", "TYU", "tjumenskaja-oblast"),
    array("Ульяновская область", "ULY", "uljanovskaja-oblast"),
    array("Челябинская область", "CHE", "cheljabinskaja-oblast"),
    array("Ярославская область", "YAR", "yaroslavskaja-oblast"),
    array("Еврейская автономная область", "YEV", "evrejskaja-ao"),
    array("Ненецкий автономный округ", "NEN", "neneckij-ao"),
    array("Ханты-Мансийский автономный округ - Югра", "KHM", "khanty-mansijskij-ao"),
    array("Чукотский автономный округ", "CHU", "chukotskij-ao"),
    array("Ямало-Ненецкий автономный округ", "YAN", "yamalo-neneckij-ao"),
);

$regionTableName    = $this->getTable('directory/country_region');
$emsRegionTableName = $this->getTable('ch_ems/ems_region');
$table = $connection->newTable($emsRegionTableName);

$table->addColumn('region_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 10, array(
    'nullable'  => false,
    'identity'  => false,
    'unsigned'  => true,
    'primary'   => true,
), 'Region Id');

$table->addColumn('ems_code', Varien_Db_Ddl_Table::TYPE_VARCHAR, 32, array(
    'nullable'  => false,
    'identity'  => false,
    'unsigned'  => true,
    'primary'   => true,
), 'Region Id');

$table->addForeignKey(
    $this->getFkName('ch_ems/ems_region', 'region_id', 'directory/country_region', 'region_id'),
    'region_id', $this->getTable('directory/country_region'), 'region_id',
    Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_NO_ACTION);

$connection->createTable($table);

$connection->beginTransaction();
try {
    $connection->delete($regionTableName, 'country_id = "RU"');

    foreach ($regions as $regionData) {
        $name    = $regionData[0];
        $isoCode = $regionData[1];
        $emsCode = $regionData[2];

        $connection->insert($regionTableName, array(
            'country_id' => 'RU',
            'code'         => $isoCode,
            'default_name' => $name,
        ));

        $connection->insert($emsRegionTableName, array(
            'region_id' => $connection->lastInsertId(),
            'ems_code'  => $emsCode,
        ));

        $connection->lastInsertId();
    }
    $connection->commit();
} catch (Exception $e) {
    $connection->rollBack();
    throw $e;
}
$this->endSetup();