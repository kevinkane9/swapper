<?php


use Phinx\Migration\AbstractMigration;

class AdditionalDbTables extends AbstractMigration
{
    public function up()
    {
        // sap_revenue_range
        $this->query(
            "CREATE TABLE IF NOT EXISTS `sap_revenue_range` (
              `revenue_range` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
              `index` int(11) NOT NULL,
              `display_name` varchar(255) CHARACTER SET utf8 NOT NULL,
              UNIQUE KEY `revenue_range` (`revenue_range`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;"
        );

        $this->query(
            "INSERT INTO `sap_revenue_range` (`revenue_range`, `index`, `display_name`) VALUES
                ('Sales.under500K', 1, '<$500K'),
                ('Sales.500Kto1M', 2, '$500K-$1M'),
                ('Sales.1Mto5M', 3, '$1M-$5M'),
                ('Sales.5Mto10M', 4, '$5M-$10M'),
                ('Sales.10Mto25M', 5, '$10M-$25M'),
                ('Sales.25Mto50M', 6, '$25M-$50M'),
                ('Sales.50Mto100M', 7, '$50M-$100M'),
                ('Sales.100MMto250M', 8, '$100M-$250M'),
                ('Sales.250Mto500M', 9, '$250M-$500M'),
                ('Sales.500Mto1G', 10, '$500M-$1B'),
                ('Sales.1Gto5G', 11, '$1B-$5B'),
                ('Sales.5GPlus', 12, '$5B+')"
        );

        $this->query(
            "ALTER TABLE `sap_prospect_company` ADD INDEX `revenue_range` (`revenue_range`)"
        );

        $this->query(
            'ALTER TABLE `sap_prospect_company` ADD FOREIGN KEY (`revenue_range`) REFERENCES `sap_revenue_range`(`revenue_range`) ON DELETE NO ACTION ON UPDATE NO ACTION'
        );

        // sap_employee_range
        $this->query(
            "CREATE TABLE IF NOT EXISTS `sap_employee_range` (
              `employees_range` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
              `index` int(11) NOT NULL,
              `display_name` varchar(255) CHARACTER SET utf8 NOT NULL,
              UNIQUE KEY `employees_range` (`employees_range`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;"
        );

        $this->query(
            "INSERT INTO `sap_employee_range` (`employees_range`, `index`, `display_name`) VALUES
                ('Employees.1to4', 1, '1-4'),
                ('Employees.5to9', 2, '5-9'),
                ('Employees.10to19', 3, '10-19'),
                ('Employees.20to49', 4, '20-49'),
                ('Employees.50to99', 5, '50-99'),
                ('Employees.100to249', 6, '100-249'),
                ('Employees.250to499', 7, '250-499'),
                ('Employees.500to999', 8, '500-999'),
                ('Employees.1000to4999', 9, '1,000-4,999'),
                ('Employees.5000to9999', 10, '5,000-9,999'),
                ('Employees.10000plus', 11, '10,000+')"
        );

        $this->query(
            "ALTER TABLE `sap_prospect_company` ADD INDEX `employees_range` (`employees_range`)"
        );

        $this->query(
            'ALTER TABLE `sap_prospect_company` ADD FOREIGN KEY (`employees_range`) REFERENCES `sap_employee_range`(`employees_range`) ON DELETE NO ACTION ON UPDATE NO ACTION'
        );

        // sap_industry
        $this->query(
            "CREATE TABLE IF NOT EXISTS `sap_industry` (
              `hierarchical_category` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
              `display_name` varchar(255) CHARACTER SET utf8 NULL,
              `level_1` varchar(255) CHARACTER SET utf8 NULL,
              `level_2` varchar(255) CHARACTER SET utf8 NULL,
              `level_3` varchar(255) CHARACTER SET utf8 NULL,
              UNIQUE KEY `hierarchical_category` (`hierarchical_category`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;"
        );

        $this->query(
            "INSERT INTO `sap_industry` (`hierarchical_category`, `display_name`, `level_1`, `level_2`, `level_3`) VALUES
                ('Undefined', 'Undefined', 'Undefined', NULL, NULL),
                ('Industry.agriculture', 'agriculture', 'agriculture', NULL, NULL),
                ('Industry.agriculture.animals', 'animals', 'agriculture', 'animals', NULL),
                ('Industry.agriculture.crops', 'crops', 'agriculture', 'crops', NULL),
                ('Industry.bizservice', 'bizservice', 'bizservice', NULL, NULL),
                ('Industry.bizservice.accounting', 'accounting', 'bizservice', 'accounting', NULL),
                ('Industry.bizservice.auction', 'auction', 'bizservice', 'auction', NULL),
                ('Industry.bizservice.callcenter', 'callcenter', 'bizservice', 'callcenter', NULL),
                ('Industry.bizservice.collection', 'collection', 'bizservice', 'collection', NULL),
                ('Industry.bizservice.consulting', 'consulting', 'bizservice', 'consulting', NULL),
                ('Industry.bizservice.datamgmt', 'datamgmt', 'bizservice', 'datamgmt', NULL),
                ('Industry.bizservice.hr', 'hr', 'bizservice', 'hr', NULL),
                ('Industry.bizservice.janitor', 'janitor', 'bizservice', 'janitor', NULL),
                ('Industry.bizservice.language', 'language', 'bizservice', 'language', NULL),
                ('Industry.bizservice.marketing', 'marketing', 'bizservice', 'marketing', NULL),
                ('Industry.bizservice.printing', 'printing', 'bizservice', 'printing', NULL),
                ('Industry.bizservice.security', 'security', 'bizservice', 'security', NULL),
                ('Industry.chamber', 'chamber', 'chamber', NULL, NULL),
                ('Industry.construction', 'construction', 'construction', NULL, NULL),
                ('Industry.construction.architecture', 'architecture', 'construction', 'architecture', NULL),
                ('Industry.construction.construction', 'construction', 'construction', 'construction', NULL),
                ('Industry.consumerservices', NULL, 'consumerservices', NULL, NULL),
                ('Industry.consumerservices.auto', 'auto', 'consumerservices', 'auto', NULL),
                ('Industry.consumerservices.carrental', 'carrental', 'consumerservices', 'carrental', NULL),
                ('Industry.consumerservices.funeralhome', 'funeralhome', 'consumerservices', 'funeralhome', NULL),
                ('Industry.consumerservices.hairsalon', 'hairsalon', 'consumerservices', 'hairsalon', NULL),
                ('Industry.consumerservices.laundry', 'laundry', 'consumerservices', 'laundry', NULL),
                ('Industry.consumerservices.photo', 'photo', 'consumerservices', 'photo', NULL),
                ('Industry.consumerservices.travel', 'travel', 'consumerservices', 'travel', NULL),
                ('Industry.consumerservices.veterinary', 'veterinary', 'consumerservices', 'veterinary', NULL),
                ('Industry.consumerservices.weight', 'weight', 'consumerservices', 'weight', NULL),
                ('Industry.cultural', 'cultural', 'cultural', NULL, NULL),
                ('Industry.cultural.museum', 'museum', 'cultural', 'museum', NULL),
                ('Industry.education.k12', 'k12', 'education', 'k12', NULL),
                ('Industry.education.training', 'training', 'education', 'training', NULL),
                ('Industry.education.university', 'university', 'education', 'university', NULL),
                ('Industry.energy', 'energy', 'energy', NULL, NULL),
                ('Industry.energy.energy', 'energy', 'energy', 'energy', NULL),
                ('Industry.energy.environment', 'environment', 'energy', 'environment', NULL),
                ('Industry.energy.services', 'services', 'energy', 'services', NULL),
                ('Industry.energy.water', 'water', 'energy', 'water', NULL),
                ('Industry.finance', 'finance', 'finance', NULL, NULL),
                ('Industry.finance.banking', 'banking', 'finance', 'banking', NULL),
                ('Industry.finance.brokerage', 'brokerage', 'finance', 'brokerage', NULL),
                ('Industry.finance.creditcards', 'creditcards', 'finance', 'creditcards', NULL),
                ('Industry.finance.investment', 'investment', 'finance', 'investment', NULL),
                ('Industry.finance.venturecapital', 'venturecapital', 'finance', 'venturecapital', NULL),
                ('Industry.government', 'government', 'government', NULL, NULL),
                ('Industry.healthcare', 'healthcare', 'healthcare', NULL, NULL),
                ('Industry.healthcare.healthcare', 'healthcare', 'healthcare', 'healthcare', NULL),
                ('Industry.healthcare.medicaltesting', 'medicaltesting', 'healthcare', 'medicaltesting', NULL),
                ('Industry.healthcare.pharmaceuticals', 'pharmaceuticals', 'healthcare', 'pharmaceuticals', NULL),
                ('Industry.healthcare.pharmaceuticals.biotech', 'biotech', 'healthcare', 'pharmaceuticals', 'biotech'),
                ('Industry.healthcare.pharmaceuticals.drugs', 'drugs', 'healthcare', 'pharmaceuticals', 'drugs'),
                ('Industry.hospitality', 'hospitality', 'hospitality', NULL, NULL),
                ('Industry.hospitality.lodging', 'lodging', 'hospitality', 'lodging', NULL),
                ('Industry.hospitality.recreation', 'recreation', 'hospitality', 'recreation', NULL),
                ('Industry.hospitality.recreation.cinema', 'cinema', 'hospitality', 'recreation', 'cinema'),
                ('Industry.hospitality.recreation.fitness', 'fitness', 'hospitality', 'recreation', 'fitness'),
                ('Industry.hospitality.recreation.gaming', 'gaming', 'hospitality', 'recreation', 'gaming'),
                ('Industry.hospitality.recreation.park', 'park', 'hospitality', 'recreation', 'park'),
                ('Industry.hospitality.recreation.zoo', 'zoo', 'hospitality', 'recreation', 'zoo'),
                ('Industry.hospitality.restaurant', 'restaurant', 'hospitality', 'restaurant', NULL),
                ('Industry.hospitality.sports', 'sports', 'hospitality', 'sports', NULL),
                ('Industry.insurance', 'insurance', 'insurance', NULL, NULL),
                ('Industry.legal', 'legal', 'legal', NULL, NULL),
                ('Industry.media.broadcasting', 'broadcasting', 'media', 'broadcasting', NULL),
                ('Industry.media.broadcasting.film', 'film', 'media', 'broadcasting', 'film'),
                ('Industry.media.broadcasting.radio', 'radio', 'media', 'broadcasting', 'radio'),
                ('Industry.media.broadcasting.tv', 'tv', 'media', 'broadcasting', 'tv'),
                ('Industry.media.information', 'information', 'media', 'information', NULL),
                ('Industry.media.internet', 'internet', 'media', 'internet', NULL),
                ('Industry.media.music', 'music', 'media', 'music', NULL),
                ('Industry.media.news', 'news', 'media', 'news', NULL),
                ('Industry.media.publishing', 'publishing', 'media', 'publishing', NULL),
                ('Industry.mfg', 'mfg', 'mfg', NULL, NULL),
                ('Industry.mfg.aerospace', 'aerospace', 'mfg', 'aerospace', NULL),
                ('Industry.mfg.boat', 'boat', 'mfg', 'boat', NULL),
                ('Industry.mfg.building', 'building', 'mfg', 'building', NULL),
                ('Industry.mfg.building.concrete', 'concrete', 'mfg', 'building', 'concrete'),
                ('Industry.mfg.building.lumber', 'lumber', 'mfg', 'building', 'lumber'),
                ('Industry.mfg.building.other', 'other', 'mfg', 'building', 'other'),
                ('Industry.mfg.building.plumbing', 'plumbing', 'mfg', 'building', 'plumbing'),
                ('Industry.mfg.car', 'car', 'mfg', 'car', NULL),
                ('Industry.mfg.chemicals', 'chemicals', 'mfg', 'chemicals', NULL),
                ('Industry.mfg.chemicals.chemicals', 'chemicals', 'mfg', 'chemicals', 'chemicals'),
                ('Industry.mfg.chemicals.gas', 'gas', 'mfg', 'chemicals', 'gas'),
                ('Industry.mfg.chemicals.glass', 'glass', 'mfg', 'chemicals', 'glass'),
                ('Industry.mfg.chemicals.petrochemicals', 'petrochemicals', 'mfg', 'chemicals', 'petrochemicals'),
                ('Industry.mfg.computers', 'computers', 'mfg', 'computers', NULL),
                ('Industry.mfg.computers.computers', 'computers', 'mfg', 'computers', 'computers'),
                ('Industry.mfg.computers.networking', 'networking', 'mfg', 'computers', 'networking'),
                ('Industry.mfg.computers.security', 'security', 'mfg', 'computers', 'security'),
                ('Industry.mfg.computers.storage', 'storage', 'mfg', 'computers', 'storage'),
                ('Industry.mfg.consumer', 'consumer', 'mfg', 'consumer', NULL),
                ('Industry.mfg.consumer.appliances', 'appliances', 'mfg', 'consumer', 'appliances'),
                ('Industry.mfg.consumer.cleaning', 'cleaning', 'mfg', 'consumer', 'cleaning'),
                ('Industry.mfg.consumer.clothes', 'clothes', 'mfg', 'consumer', 'clothes'),
                ('Industry.mfg.consumer.electronics', 'electronics', 'mfg', 'consumer', 'electronics'),
                ('Industry.mfg.consumer.health', 'health', 'mfg', 'consumer', 'health'),
                ('Industry.mfg.consumer.household', 'household', 'mfg', 'consumer', 'household'),
                ('Industry.mfg.consumer.petproducts', 'petproducts', 'mfg', 'consumer', 'petproducts'),
                ('Industry.mfg.consumer.photo', 'photo', 'mfg', 'consumer', 'photo'),
                ('Industry.mfg.consumer.sport', 'sport', 'mfg', 'consumer', 'sport'),
                ('Industry.mfg.consumer.watch', 'watch', 'mfg', 'consumer', 'watch'),
                ('Industry.mfg.electronics', 'electronics', 'mfg', 'electronics', NULL),
                ('Industry.mfg.electronics.batteries', 'batteries', 'mfg', 'electronics', 'batteries'),
                ('Industry.mfg.electronics.electronics', 'electronics', 'mfg', 'electronics', 'electronics'),
                ('Industry.mfg.electronics.powerequip', 'powerequip', 'mfg', 'electronics', 'powerequip'),
                ('Industry.mfg.electronics.semiconductors', 'semiconductors', 'mfg', 'electronics', 'semiconductors'),
                ('Industry.mfg.food', 'food', 'mfg', 'food', NULL),
                ('Industry.mfg.food.food', 'food', 'mfg', 'food', 'food'),
                ('Industry.mfg.food.tobacco', 'tobacco', 'mfg', 'food', 'tobacco'),
                ('Industry.mfg.food.winery', 'winery', 'mfg', 'food', 'winery'),
                ('Industry.mfg.furniture', 'furniture', 'mfg', 'furniture', NULL),
                ('Industry.mfg.industrialmachinery', 'industrialmachinery', 'mfg', 'industrialmachinery', NULL),
                ('Industry.mfg.medical', 'medical', 'mfg', 'medical', NULL),
                ('Industry.mfg.paper', 'paper', 'mfg', 'paper', NULL),
                ('Industry.mfg.plastic', 'plastic', 'mfg', 'plastic', NULL),
                ('Industry.mfg.rubber', 'rubber', 'mfg', 'rubber', NULL),
                ('Industry.mfg.telecom', 'telecom', 'mfg', 'telecom', NULL),
                ('Industry.mfg.testequipment', 'testequipment', 'mfg', 'testequipment', NULL),
                ('Industry.mfg.toys', 'toys', 'mfg', 'toys', NULL),
                ('Industry.mfg.wire', 'wire', 'mfg', 'wire', NULL),
                ('Industry.mm.metals', 'metals', 'mm', 'metals', NULL),
                ('Industry.mm.mining', 'mining', 'mm', 'mining', NULL),
                ('Industry.municipal', 'municipal', 'municipal', NULL, NULL),
                ('Industry.municipal.publicsafety', 'publicsafety', 'municipal', 'publicsafety', NULL),
                ('Industry.orgs.association', 'association', 'orgs', 'association', NULL),
                ('Industry.orgs.foundation', 'foundation', 'orgs', 'foundation', NULL),
                ('Industry.orgs.religion', 'religion', 'orgs', 'religion', NULL),
                ('Industry.realestate', 'realestate', 'realestate', NULL, NULL),
                ('Industry.retail', 'retail', 'retail', NULL, NULL),
                ('Industry.retail.auto', 'auto', 'retail', 'auto', NULL),
                ('Industry.retail.autoparts', 'autoparts', 'retail', 'autoparts', NULL),
                ('Industry.retail.book', 'book', 'retail', 'book', NULL),
                ('Industry.retail.clothes', 'clothes', 'retail', 'clothes', NULL),
                ('Industry.retail.conveniencestore', 'conveniencestore', 'retail', 'conveniencestore', NULL),
                ('Industry.retail.departmentstore', 'departmentstore', 'retail', 'departmentstore', NULL),
                ('Industry.retail.gifts', 'gifts', 'retail', 'gifts', NULL),
                ('Industry.retail.grocery', 'grocery', 'retail', 'grocery', NULL),
                ('Industry.retail.hardware', 'hardware', 'retail', 'hardware', NULL),
                ('Industry.retail.health', 'health', 'retail', 'health', NULL),
                ('Industry.retail.jewelry', 'jewelry', 'retail', 'jewelry', NULL),
                ('Industry.retail.office', 'office', 'retail', 'office', NULL),
                ('Industry.retail.pharmacy', 'pharmacy', 'retail', 'pharmacy', NULL),
                ('Industry.retail.rental', 'rental', 'retail', 'rental', NULL),
                ('Industry.retail.sports', 'sports', 'retail', 'sports', NULL),
                ('Industry.retail.videorental', 'videorental', 'retail', 'videorental', NULL),
                ('Industry.software.consulting', 'consulting', 'software', 'consulting', NULL),
                ('Industry.software.mfg', 'mfg', 'software', 'mfg', NULL),
                ('Industry.software.mfg.eng', 'eng', 'software', 'mfg', 'eng'),
                ('Industry.software.mfg.erp', 'erp', 'software', 'mfg', 'erp'),
                ('Industry.software.mfg.finance', 'finance', 'software', 'mfg', 'finance'),
                ('Industry.software.mfg.health', 'health', 'software', 'mfg', 'health'),
                ('Industry.software.mfg.network', 'network', 'software', 'mfg', 'network'),
                ('Industry.software.mfg.security', 'security', 'software', 'mfg', 'security'),
                ('Industry.telecom.cable', 'cable', 'telecom', 'cable', NULL),
                ('Industry.telecom.internet', 'internet', 'telecom', 'internet', NULL),
                ('Industry.telecom.telephone', 'telephone', 'telecom', 'telephone', NULL),
                ('Industry.transportation', 'transportation', 'transportation', NULL, NULL),
                ('Industry.transportation.airline', 'airline', 'transportation', 'airline', NULL),
                ('Industry.transportation.freight', 'freight', 'transportation', 'freight', NULL),
                ('Industry.transportation.marine', 'marine', 'transportation', 'marine', NULL),
                ('Industry.transportation.moving', 'moving', 'transportation', 'moving', NULL),
                ('Industry.transportation.railandbus', 'railandbus', 'transportation', 'railandbus', NULL)"
        );

        $this->query(
            "ALTER TABLE `sap_prospect_industry` ADD INDEX `hierarchical_category` (`hierarchical_category`)"
        );

        $this->query(
            'ALTER TABLE `sap_prospect_industry` ADD FOREIGN KEY (`hierarchical_category`) REFERENCES `sap_industry`(`hierarchical_category`) ON DELETE NO ACTION ON UPDATE NO ACTION'
        );
    }

    public function down()
    {
        // sap_revenue_range
        $this->query('ALTER TABLE sap_prospect_company DROP FOREIGN KEY sap_prospect_company_ibfk_1');
        $this->query('ALTER TABLE sap_prospect_company DROP INDEX revenue_range');
        $this->query('DROP TABLE sap_revenue_range');

        // sap_employee_range
        $this->query('ALTER TABLE sap_prospect_company DROP FOREIGN KEY sap_prospect_company_ibfk_2');
        $this->query('ALTER TABLE sap_prospect_company DROP INDEX employees_range');
        $this->query('DROP TABLE sap_employee_range');

        // sap_industry
        $this->query('ALTER TABLE sap_prospect_industry DROP FOREIGN KEY sap_prospect_industry_ibfk_1');
        $this->query('ALTER TABLE sap_prospect_industry DROP INDEX hierarchical_category');
        $this->query('DROP TABLE sap_industry');
    }
}
