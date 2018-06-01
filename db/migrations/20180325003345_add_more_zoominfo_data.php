<?php


use Phinx\Migration\AbstractMigration;

class AddMoreZoominfoData extends AbstractMigration
{
    public function change()
    {
        $prospectTable = $this->table('sap_prospect');

        $prospectTable
            ->addColumn('middle_name', 'string', ['null' => true, 'after' => 'first_name'])
            ->addColumn('suffix', 'string', ['null' => true, 'after' => 'last_name'])
            ->addColumn('salutation', 'string', ['null' => true, 'after' => 'suffix'])
            ->addColumn('title_code', 'string', ['null' => true, 'after' => 'title'])
            ->addColumn('title_hierarchy_level', 'string', ['null' => true, 'after' => 'title_code'])
            ->addColumn('job_function', 'string', ['null' => true, 'after' => 'title_hierarchy_level'])
            ->addColumn('management_level', 'string', ['null' => true, 'after' => 'job_function'])
            ->addColumn('source_count', 'string', ['null' => true, 'after' => 'management_level'])
            ->addColumn('highest_level_job_function', 'string', ['null' => true, 'after' => 'source_count'])
            ->addColumn('person_pro_url', 'string', ['null' => true, 'after' => 'highest_level_job_function'])
            ->addColumn('encrypted_email_address', 'string', ['null' => true, 'after' => 'person_pro_url'])
            ->addColumn('email_domain', 'string', ['null' => true, 'after' => 'encrypted_email_address'])
            ->update();

        $prospectCompanyTable = $this->table('sap_prospect_company');

        $prospectCompanyTable
            ->addColumn('division_name', 'string', ['null' => true, 'after' => 'name'])
            ->addColumn('sic1', 'string', ['null' => true, 'after' => 'division_name'])
            ->addColumn('sic2', 'string', ['null' => true, 'after' => 'sic1'])
            ->addColumn('naics1', 'string', ['null' => true, 'after' => 'sic2'])
            ->addColumn('naics2', 'string', ['null' => true, 'after' => 'naics1'])
            ->addColumn('domain_name', 'string', ['null' => true, 'after' => 'naics2'])
            ->addColumn('phone_number', 'string', ['null' => true, 'after' => 'domain_name'])
            ->addColumn('street_address', 'string', ['null' => true, 'after' => 'phone_number'])
            ->addColumn('city_id', 'string', ['null' => true, 'after' => 'street_address'])
            ->addColumn('state_id', 'string', ['null' => true, 'after' => 'city_id'])
            ->addColumn('zip', 'string', ['null' => true, 'after' => 'state_id'])
            ->addColumn('country_id', 'string', ['null' => true, 'after' => 'zip'])
            ->addColumn('revenue', 'string', ['null' => true, 'after' => 'country_id'])
            ->addColumn('revenue_range', 'string', ['null' => true, 'after' => 'revenue'])
            ->addColumn('employees', 'string', ['null' => true, 'after' => 'revenue_range'])
            ->addColumn('employees_range', 'string', ['null' => true, 'after' => 'employees'])
            ->update();

        $prospectIndustryTable = $this->table('sap_prospect_industry');

        $prospectIndustryTable
            ->addColumn('hierarchical_category', 'string', ['null' => true, 'after' => 'name'])
            ->addColumn('second_industry_label', 'string', ['null' => true, 'after' => 'hierarchical_category'])
            ->addColumn('second_industry_hierarchical_category', 'string', ['null' => true, 'after' => 'second_industry_label'])
            ->update();
    }
}
