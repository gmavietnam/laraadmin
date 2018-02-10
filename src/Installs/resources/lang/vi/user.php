<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Data translate
    |--------------------------------------------------------------------------
    */
    'not_found' => 'Không tìm thấy người dùng',

    'POSITION' => ['staff' => 'Nhân viên',
                  'manager' => 'Trưởng phòng',
                  'director' => 'Giám đốc'],

    'BUSINESS_MODEL' => ['producer' => 'Nhà sản xuất',
						'trading-company' => 'Công ty Thương Mại',
						'agent' => 'Đại lý độc quyền',
						'distributor' => 'Nhà phân phối',
						'wholesaler' => 'Nhà bán sỉ',
						'business' => 'Dịch vụ kinh doanh',
						'other' => 'Khác'],
	'TOTAL_EMPLOYEES' => ['fewer5' => 'Nhỏ hơn 5 người',
						 '5to10' => '5 - 10 người',
						 '11to50' => '11 - 50 người',
						 '51to100' => '51 - 100 người',
						 '101to200' => '101 - 200 người',
						 '201to300' => '201 - 300 người',
						 '301to500' => '301 - 500 người',
						 '501to1000' => '501 - 1000 người',
						 'above1000' => 'Lớn hơn 1000 người'
				],
	'COMPANY_TYPE' => ['limitedliability' => 'TNHH',
					  '1memberlimitedliability' => 'TNHH 1 thành viên',
					  'jointstock' => 'Cổ phần',
					  'jointventure' => 'Liên doanh'
				],
	'COMPANY_ANNUAL_TURNOVER' => ['fewer1' => 'Dưới 1 triệu Đô',
								 '1to2' => '1 triệu- 2 triệu đô',
								 '2to10' => '2,5 triệu - 10 triệu đô',
								 '10to50' => '10 triệu - 50 triệu đô',
								 '50to100' => '50 triệu - 100 triệu đô',
								 'above100' => 'Trên 100 triệu Đô'],
	'COMPANY_PERCENT_EXPORT' => ['1to10' => '1% - 10%',
								 '11to20' => '11% - 20%',
								 '21to30' => '21% - 30%',
								 '31to40' => '31% - 40%',
								 '41to50' => '41% - 50%',
								 '51to60' => '51% - 60%',
								 '61to70' => '61% - 70%',
								 '71to80' => '71% - 80%',
								 '81to100' => '81% - 100%'],

	'COMPANY_EXPORT_MARKET' => ['domestic' => 'Trong nước',
							    'south-america' => 'Nam Mỹ',
							    'north-america' => 'Bắc Mỹ',
							    'south-east-asia' => 'Đông Nam Á',
							    'africa' => 'Châu Phi',
							    'australia' => 'Úc',
							    'middle-east' => 'Trung Đông',
							    'east-asia' => 'Đông Á',
							    'south-asia' => 'Nam Á',
							    'northern-europe' => 'Bắc Âu',
							    'east-europe' => 'Đông Âu',
							    'west-europe' => 'Tây Âu',
							    'southern-europe' => 'Nam Âu'],
];
