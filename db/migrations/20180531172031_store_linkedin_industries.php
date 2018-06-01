<?php

use Phinx\Migration\AbstractMigration;

class StoreLinkedinIndustries extends AbstractMigration
{
    public function up()
    {
        $this->query(
            'CREATE TABLE `sap_prospect_industry_condensed` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `name` VARCHAR(255) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci'
        );

        $this->query(
            'ALTER TABLE `sap_prospect_industry`
             ADD `condensed_id` INT NULL DEFAULT NULL AFTER `second_industry_hierarchical_category`,
             ADD INDEX `condensed_id` (`condensed_id`)'
        );

        $this->query(
            'ALTER TABLE `sap_prospect_industry`
             ADD CONSTRAINT `sap_prospect_industry_condensed_id` FOREIGN KEY (`condensed_id`)
             REFERENCES `sap_prospect_industry_condensed`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT'
        );

        $mappings = [
            'Debt Collection' => 'Accounting',
            'Accounting & Accounting Services' => 'Accounting',
            'Airlines, Airports & Air Services' => 'Airlines/Aviation',
            'Medical Testing & Clinical Laboratories' => 'Alternative Medicine',
            'Architecture & Planning' => 'Architecture & Planning',
            'Architecture &amp; Planning' => 'Architecture & Planning',
            'Architecture, Engineering & Design' => 'Architecture & Planning',
            'Automobile Parts Stores' => 'Automotive',
            'Automobiles' => 'Automotive',
            'Automotive' => 'Automotive',
            'Automotive Service & Collision Repair' => 'Automotive',
            'Car & Truck Rental' => 'Automotive',
            'Aerospace & Defense' => 'Aviation & Aerospace',
            'Aviation &amp; Aerospace' => 'Aviation & Aerospace',
            'Banking' => 'Banking',
            'Brokerage' => 'Banking',
            'Biotechnology' => 'Biotechnology',
            'Broadcasting' => 'Broadcast Media',
            'Television Stations' => 'Broadcast Media',
            'Building Materials' => 'Building Materials',
            'Miscellaneous Building Materials - Flooring, Cabinets, etc.' => 'Building Materials',
            'Business Supplies and Equipment' => 'Business Supplies and Equipment',
            'Power Conversion & Protection Equipment' => 'Business Supplies and Equipment',
            'Chemicals' => 'Chemicals',
            'Chemicals, Petrochemicals, Glass & Gases' => 'Chemicals',
            'Petrochemicals' => 'Chemicals',
            'Engineering' => 'Civil Engineering',
            'Civil Engineering' => 'Civil Engineering',
            'Electronics' => 'Electronics',
            'Electronic Components' => 'Electronics',
            'Security Products & Services' => 'Computer & Network Security',
            'Network Security Hardware & Software' => 'Computer & Network Security',
            'Personal Computers & Peripherals' => 'Computer Hardware',
            'Computer Equipment & Peripherals' => 'Computer Hardware',
            'Computer Networking Equipment' => 'Computer Networking',
            'Computer Services' => 'Computer Software',
            'Engineering Software' => 'Computer Software',
            'Computer Software' => 'Computer Software',
            'Software' => 'Computer Software',
            'Software Development & Design' => 'Computer Software',
            'Custom Software & Technical Consulting' => 'Computer Software',
            'Concrete' => 'Construction',
            'Construction' => 'Construction',
            'Commercial & Residential Construction' => 'Construction',
            'Home Improvement & Hardware' => 'Construction',
            'Consumer Electronics' => 'Consumer Electronics',
            'Consumer Electronics & Computers' => 'Consumer Electronics',
            'Consumer Goods' => 'Consumer Goods',
            'Household Goods' => 'Consumer Goods',
            'Business and Consumer Services' => 'Consumer Services',
            'Business Services' => 'Consumer Services',
            'Consumer Services' => 'Consumer Services',
            'Cosmetics, Beauty Supply & Personal Care Products' => 'Cosmetics',
            'Hair Salons' => 'Cosmetics',
            'Electrical/Electronic Manufacturing' => 'Electrical/Electronic Manufacturing',
            'Waste Treatment, Environmental Services & Recycling' => 'Environmental Services',
            'Facilities Management & Commercial Cleaning' => 'Facilities Services',
            'Crops' => 'Farming',
            'Finance' => 'Financial Services',
            'Financial Services' => 'Financial Services',
            'Food & Beverages' => 'Food & Beverages',
            'Food &amp; Beverages' => 'Food & Beverages',
            'Food Production' => 'Food & Beverages',
            'Food, Beverages & Tobacco' => 'Food & Beverages',
            'Furniture' => 'Furniture',
            'Gambling & Gaming' => 'Gambling & Casinos',
            'Aggregates, Concrete & Cement' => 'Glass, Ceramics & Concrete',
            'Glass & Clay' => 'Glass, Ceramics & Concrete',
            'Government' => 'Government Relations',
            'Graphic Design' => 'Graphic Design',
            'Multimedia & Graphic Design' => 'Graphic Design',
            'Health & Nutrition Products' => 'Health, Wellness and Fitness',
            'Fitness & Dance Facilities' => 'Health, Wellness and Fitness',
            'Colleges & Universities' => 'Higher Education',
            'Higher Education' => 'Higher Education',
            'Hospital & Health Care' => 'Hospital & Health Care',
            'Hospitals & Clinics' => 'Hospital & Health Care',
            'Healthcare' => 'Hospital & Health Care',
            'Hospitality' => 'Hospitality',
            'Human Resources' => 'Human Resources',
            'Individual & Family Services' => 'Individual & Family Services',
            'Individual &amp; Family Services' => 'Individual & Family Services',
            'Information & Document Management' => 'Information Technology and Services',
            'Information Collection & Delivery' => 'Information Technology and Services',
            'Information Technology and Services' => 'Information Technology and Services',
            'Finance and Insurance' => 'Insurance',
            'Insurance' => 'Insurance',
            'Internet' => 'Internet',
            'Internet Service Providers, Website Hosting & Internet-related Services' => 'Internet',
            'Search Engines & Internet Portals' => 'Internet',
            'Investment Banking' => 'Investment Banking',
            'Investment Management' => 'Investment Management',
            'Law Firms & Legal Services' => 'Law Practice',
            'Law Practice' => 'Law Practice',
            'Leisure' => 'Leisure, Travel & Tourism',
            'Leisure, Travel & Tourism' => 'Leisure, Travel & Tourism',
            'Travel & Tourism' => 'Leisure, Travel & Tourism',
            'Travel Agencies & Services' => 'Leisure, Travel & Tourism',
            'Lodging & Resorts' => 'Leisure, Travel & Tourism',
            'Libraries' => 'Libraries',
            'Logistics and Supply Chain' => 'Logistics and Supply Chain',
            'Jewelry & Watches' => 'Luxury Goods & Jewelry',
            'Industrial Machinery & Equipment' => 'Machinery',
            'Machinery' => 'Machinery',
            'Management Consulting' => 'Management Consulting',
            'Boats & Submarines' => 'Maritime',
            'Market Research' => 'Market Research',
            'Advertising & Marketing' => 'Marketing and Advertising',
            'Marketing and Advertising' => 'Marketing and Advertising',
            'Mechanical or Industrial Engineering' => 'Mechanical or Industrial Engineering',
            'Film/Video Production & Services' => 'Media Production',
            'Medical Devices & Equipment' => 'Medical Devices',
            'Metals & Minerals' => 'Mining & Metals',
            'Mining' => 'Mining & Metals',
            'Mining &amp; Metals' => 'Mining & Metals',
            'Movie Theaters' => 'Motion Pictures and Film',
            'Museums & Art Galleries' => 'Museums and Institutions',
            'Music & Music Related Services' => 'Music',
            'Newspapers & News Services' => 'Newspapers',
            'Non-Profit' => 'Non-Profit Organization Management',
            'Non-Profit Organization Management' => 'Non-Profit Organization Management',
            'Non-Profits' => 'Non-Profit Organization Management',
            'Nonprofit Organization Management' => 'Non-Profit Organization Management',
            'Charitable Organizations & Foundations' => 'Non-Profit Organization Management',
            'Batteries, Power Storage Equipment & Generators' => 'Oil & Energy',
            'Oil & Energy' => 'Oil & Energy',
            'Oil & Gas Exploration & Services' => 'Oil & Energy',
            'Electricity, Oil & Gas' => 'Oil & Energy',
            'Media & Internet' => 'Online Media',
            'Freight & Logistics Services' => 'Package/Freight Delivery',
            'Office Products' => 'Paper & Forest Products',
            'Paper & Forest Products' => 'Paper & Forest Products',
            'Pulp & Paper' => 'Paper & Forest Products',
            'Lumber & Wood Production' => 'Paper & Forest Products',
            'Drug Manufacturing & Research' => 'Pharmaceuticals',
            'Drug Stores & Pharmacies' => 'Pharmaceuticals',
            'Pharmaceuticals' => 'Pharmaceuticals',
            'Photographic & Optical Equipment' => 'Photography',
            'Photography Studio' => 'Photography',
            'Plastic, Packaging & Containers' => 'Plastics',
            'Education' => 'Primary/Secondary Education',
            'K-12 Schools' => 'Primary/Secondary Education',
            'Commercial Printing' => 'Printing',
            'Training' => 'Professional Training & Coaching',
            'Professional Training &amp; Coaching' => 'Professional Training & Coaching',
            'Public Safety' => 'Public Safety',
            'Publishing' => 'Publishing',
            'Real Estate' => 'Real Estate',
            'Zoos & National Parks' => 'Recreational Facilities and Services',
            'Recreation' => 'Recreational Facilities and Services',
            'Religious Organizations' => 'Religious Institutions',
            'Renewables & Environment' => 'Renewables & Environment',
            'Research' => 'Research',
            'Restaurants' => 'Restaurants',
            'Appliances' => 'Retail',
            'Tires & Rubber' => 'Retail',
            'Toys & Games' => 'Retail',
            'Pet Products' => 'Retail',
            'Apparel & Accessories' => 'Retail',
            'Department Stores & Superstores' => 'Retail',
            'Retail' => 'Retail',
            'Records, Videos & Books' => 'Retail',
            'Rental - Other - Furniture, A/V, Construction & Industrial Equipment' => 'Retail',
            'Rental - Video & DVD' => 'Retail',
            'Flowers, Gifts & Specialty' => 'Retail',
            'Semiconductor & Semiconductor Equipment' => 'Semiconductors',
            'Sporting & Recreational Equipment' => 'Sporting Goods',
            'Sporting Goods' => 'Sporting Goods',
            'Sports Teams & Leagues' => 'Sports',
            'Human Resources & Staffing' => 'Staffing & Recruiting',
            'Staffing and Recruiting' => 'Staffing and Recruiting',
            'Gas Stations, Convenience & Liquor Stores' => 'Supermarkets',
            'Grocery' => 'Supermarkets',
            'Telecommunication Equipment' => 'Telecommunications',
            'Telecommunications' => 'Telecommunications',
            'Telephony & Wireless' => 'Telecommunications',
            'Textiles' => 'Textiles',
            'Textiles & Apparel' => 'Textiles',
            'Tobacco' => 'Tobacco',
            'Translation & Linguistic Services' => 'Translation and Localization',
            'Transportation' => 'Transportation/Trucking/Railroad',
            'Transportation/Trucking/Railroad' => 'Transportation/Trucking/Railroad',
            'Trucking, Moving & Storage' => 'Transportation/Trucking/Railroad',
            'Rail, Bus & Taxi' => 'Transportation/Trucking/Railroad',
            'Marine Shipping & Transportation' => 'Transportation/Trucking/Railroad',
            'Emergency Medical Transportation & Services' => 'Transportation/Trucking/Railroad',
            'Cable & Satellite' => 'Utilities',
            'Wire & Cable' => 'Utilities',
            'Utilities' => 'Utilities',
            'Energy, Utilities & Waste Treatment' => 'Utilities',
            'Water & Water Treatment' => 'Utilities',
            'Plumbing & HVAC Equipment' => 'Utilities',
            'Venture Capital & Private Equity' => 'Venture Capital & Private Equity',
            'Animals & Livestock' => 'Veterinary',
            'Veterinary Care' => 'Veterinary',
            'Wholesale' => 'Wholesale',
            'Wineries & Breweries' => 'Wine and Spirits'
        ];

        $i=0;
        foreach (array_unique(array_values($mappings)) as $name) {
            $this->insert(
                'sap_prospect_industry_condensed',
                ['name' => $name]
            );
            $i++;
        }

        $industries = $this->fetchAll('SELECT * FROM `sap_prospect_industry`');

        foreach ($industries as $industry) {

            if (array_key_exists($industry['name'], $mappings)) {
                $convertedName = $mappings[$industry['name']];
            } else {
                $convertedName = $industry['name'];
            }

            $query = sprintf(
                "SELECT * FROM `sap_prospect_industry_condensed` WHERE `name` ='%s'",
                addslashes($convertedName)
            );

            $match = $this->fetchRow($query);

            if (0 == $match['id']) {
                $this->insert(
                    'sap_prospect_industry_condensed',
                    ['name' => $convertedName]
                );

                $match = $this->fetchRow($query);
            }

            $query = sprintf(
                'UPDATE `sap_prospect_industry` SET `condensed_id` = %d WHERE `id` = %d',
                $match['id'],
                $industry['id']
            );

            $this->query($query);
        }
    }

    public function down()
    {
        $this->query('ALTER TABLE sap_prospect_industry DROP FOREIGN KEY sap_prospect_industry_condensed_id');
        $this->query('ALTER TABLE `sap_prospect_industry` DROP `condensed_id`');
        $this->query('DROP TABLE `sap_prospect_industry_condensed`');
    }
}
