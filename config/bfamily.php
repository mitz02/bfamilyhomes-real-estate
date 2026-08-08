<?php

return [
    'company' => [
        'name' => 'B-Family Homes Limited',
        'email' => 'admin@bfamilyhomes.com',
        'phone' => '+234 816 485 6758',
        'whatsapp' => env('WHATSAPP_NUMBER', '+2348164856758'),
        'address' => 'No1, Ananti Jerry Chijioke Street, Awkuzu, Anambra State, Nigeria',
        'jivo_widget_id' => env('JIVO_WIDGET_ID', ''),
    ],
    
    'bank' => [
        'name' => env('COMPANY_BANK_NAME', 'First Bank'),
        'account_number' => env('COMPANY_ACCOUNT_NUMBER', '2046980791'),
        'account_name' => env('COMPANY_ACCOUNT_NAME', 'B-Family Homes Limited'),
    ],
    
    'investor' => [
        'upgrade_amount' => 100000, // Minimum investment amount
    ],
    
    'property' => [
        'types' => ['Rent', 'Sale', 'Investment'],
        'categories' => ['Land', '1 Bedroom', '2 Bedroom', '3 Bedroom', 'Duplex', 'Commercial'],
        'status' => ['Available', 'Pending', 'Sold', 'Rented'],
    ],
    
    'payment' => [
        'schedules' => ['One-time', 'Monthly', 'Quarterly', 'Annually'],
        'max_installments' => 36,
    ],
];
