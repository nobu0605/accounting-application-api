<?php

return [
    'DEFAULT_ACCOUNTS' => [
        'sales'=> [
            'name' => '売上',
            'classification' => 'sales',
            'account_key' => 'sales'
        ],
        'purchases'=> [
            'name' => '仕入',
            'classification' => 'cost_of_goods_sold',
            'account_key' => 'purchases'
        ],
        'salaries_expense'=> [
            'name' => '給料',
            'classification' => 'selling_general_admin_expenses',
            'account_key' => 'salaries_expense'
        ],
        'bonuses'=> [
            'name' => '賞与',
            'classification' => 'selling_general_admin_expenses',
            'account_key' => 'bonuses'
        ],
        'advertising_expense'=> [
            'name' => '広告宣伝費',
            'classification' => 'selling_general_admin_expenses',
            'account_key' => 'advertising_expense'
        ],
        'traveling_expense'=> [
            'name' => '旅費交通費',
            'classification' => 'selling_general_admin_expenses',
            'account_key' => 'traveling_expense'
        ],
        'entertainment_expense'=> [
            'name' => '交際費',
            'classification' => 'selling_general_admin_expenses',
            'account_key' => 'entertainment_expense'
        ],
        'depreciation_expense'=> [
            'name' => '減価償却費',
            'classification' => 'selling_general_admin_expenses',
            'account_key' => 'depreciation_expense'
        ],
        'interest_income'=> [
            'name' => '受取利息',
            'classification' => 'non_operating_income',
            'account_key' => 'interest_income'
        ],
        'dividend_income'=> [
            'name' => '受取配当金',
            'classification' => 'non_operating_income',
            'account_key' => 'dividend_income'
        ],
        'gain_on_sale_of_securities'=> [
            'name' => '有価証券売却益',
            'classification' => 'non_operating_income',
            'account_key' => 'gain_on_sale_of_securities'
        ],
        'miscellaneous_income'=> [
            'name' => '雑収入',
            'classification' => 'non_operating_income',
            'account_key' => 'miscellaneous_income'
        ],
        'interest_expense'=> [
            'name' => '支払利息',
            'classification' => 'non_operating_expenses',
            'account_key' => 'interest_expense'
        ],
        'loss_on_sale_of_securities'=> [
            'name' => '有価証券売却損',
            'classification' => 'non_operating_expenses',
            'account_key' => 'loss_on_sale_of_securities'
        ],
        'miscellaneous_loss'=> [
            'name' => '雑損失',
            'classification' => 'non_operating_expenses',
            'account_key' => 'miscellaneous_loss'
        ],
        'gain_on_sale_of_fixed_assets'=> [
            'name' => '固定資産売却益',
            'classification' => 'special_income',
            'account_key' => 'gain_on_sale_of_fixed_assets'
        ],
        'gain_on_sale_of_investment_securities'=> [
            'name' => '投資有価証券売却益',
            'classification' => 'special_income',
            'account_key' => 'gain_on_sale_of_investment_securities'
        ],
        'loss_on_disposal_of_fixed_assets'=> [
            'name' => '固定資産除却損',
            'classification' => 'special_expenses',
            'account_key' => 'loss_on_disposal_of_fixed_assets'
        ],
        'loss_on_sale_of_fixed_assets'=> [
            'name' => '固定資産売却損',
            'classification' => 'special_expenses',
            'account_key' => 'loss_on_sale_of_fixed_assets'
        ],
        'loss_on_impairment'=> [
            'name' => '減損損失',
            'classification' => 'special_expenses',
            'account_key' => 'loss_on_impairment'
        ],
        'loss_on_devaluation_of_investment_securities'=> [
            'name' => '投資有価証券評価損',
            'classification' => 'special_expenses',
            'account_key' => 'loss_on_devaluation_of_investment_securities'
        ],
        'loss_on_sale_of_investment_securities'=> [
            'name' => '投資有価証券売却損',
            'classification' => 'special_expenses',
            'account_key' => 'loss_on_sale_of_investment_securities'
        ],
    ]
];
