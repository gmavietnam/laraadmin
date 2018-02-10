<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Data translate
    |--------------------------------------------------------------------------
    */
    'not_found' => 'User not found',

	'POSITION' => ['staff' => 'Staff',
				  'manager' => 'Manager',
				  'director' => 'Director'],

	'BUSINESS_MODEL' => ['producer' => 'Producer',
						'trading-company' => 'Trading company',
						'agent' => 'Agent',
						'distributor' => 'Distributor',
						'wholesaler' => 'Wholesaler',
						'business' => 'Business service',
						'other' => 'Other'],
	'TOTAL_EMPLOYEES' => ['fewer5' => 'Fewer than 5 People',
						 '5to10' => '5 - 10 People',
						 '11to50' => '11 - 50 People',
						 '51to100' => '51 - 100 People',
						 '101to200' => '101 - 200 People',
						 '201to300' => '201 - 300 People',
						 '301to500' => '301 - 500 People',
						 '501to1000' => '501 - 1000 People',
						 'above1000' => 'Above 1000 People'
				],
	'COMPANY_TYPE' => ['limitedliability' => 'Limited liability',
					  '1memberlimitedliability' => '1 member limited liability ',
					  'jointstock' => 'Joint stock',
					  'jointventure' => 'Joint venture'
				],
	'COMPANY_ANNUAL_TURNOVER' => ['fewer1' => 'Fewer than 1M USD',
								 '1to2' => '1M - 2M USD',
								 '2to10' => '2,5M - 10M USD',
								 '10to50' => '10M - 50M USD',
								 '50to100' => '50M - 100M USD',
								 'above100' => 'Above 100M USD'],
	'COMPANY_PERCENT_EXPORT' => ['1to10' => '1% - 10%',
								 '11to20' => '11% - 20%',
								 '21to30' => '21% - 30%',
								 '31to40' => '31% - 40%',
								 '41to50' => '41% - 50%',
								 '51to60' => '51% - 60%',
								 '61to70' => '61% - 70%',
								 '71to80' => '71% - 80%',
								 '81to100' => '81% - 100%'],

	'COMPANY_EXPORT_MARKET' => ['domestic' => 'Domestic',
							    'south-america' => 'South America',
							    'north-america' => 'North America',
							    'south-east-asia' => 'South East Asia',
							    'africa' => 'Africa',
							    'australia' => 'Australia',
							    'middle-east' => 'Middle East',
							    'east-asia' => 'East Asia',
							    'south-asia' => 'South Asia',
							    'northern-europe' => 'Northern Europe',
							    'east-europe' => 'East of Europe',
							    'west-europe' => 'West Europe',
							    'southern-europe' => 'Southern Europe'],
];
