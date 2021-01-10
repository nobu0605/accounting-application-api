<?php

return [
    'CLASSIFICATIONS' => [
        'sales',
        'cost_of_goods_sold',
        'selling_general_admin_expenses',
        'non_operating_income',
        'non_operating_expenses',
        'special_income',
        'special_expenses',
        'income_taxes',
        'current_assets',
        'non_current_assets',
        'current_liabilities',
        'non_current_liabilities',
        'equity'
    ],
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
        'cash'=> [
            'name' => '現金',
            'classification' => 'current_assets',
            'account_key' => 'cash'
        ],
        'checking_account'=> [
            'name' => '当座預金',
            'classification' => 'current_assets',
            'account_key' => 'checking_account'
        ],
        'savings_accounts'=> [
            'name' => '普通預金',
            'classification' => 'current_assets',
            'account_key' => 'savings_accounts'
        ],
        'notes_receivable'=> [
            'name' => '受取手形',
            'classification' => 'current_assets',
            'account_key' => 'notes_receivable'
        ],
        'accounts_receivable'=> [
            'name' => '売掛金',
            'classification' => 'current_assets',
            'account_key' => 'accounts_receivable'
        ],
        'merchandise'=> [
            'name' => '商品',
            'classification' => 'current_assets',
            'account_key' => 'merchandise'
        ],
        'work_in_process'=> [
            'name' => '仕掛品',
            'classification' => 'current_assets',
            'account_key' => 'work_in_process'
        ],
        'loans_receivable'=> [
            'name' => '貸付金',
            'classification' => 'current_assets',
            'account_key' => 'loans_receivable'
        ],
        'interest_receivable'=> [
            'name' => '未収利息',
            'classification' => 'current_assets',
            'account_key' => 'interest_receivable'
        ],
        'prepaid_expenses'=> [
            'name' => '前払費用',
            'classification' => 'current_assets',
            'account_key' => 'prepaid_expenses'
        ],
        'buildings'=> [
            'name' => '建物',
            'classification' => 'non_current_assets',
            'account_key' => 'buildings'
        ],
        'structures'=> [
            'name' => '構築物',
            'classification' => 'non_current_assets',
            'account_key' => 'structures'
        ],
        'vehicles'=> [
            'name' => '運搬具',
            'classification' => 'non_current_assets',
            'account_key' => 'vehicles'
        ],
        'land'=> [
            'name' => '土地',
            'classification' => 'non_current_assets',
            'account_key' => 'land'
        ],
        'goodwill'=> [
            'name' => 'のれん',
            'classification' => 'non_current_assets',
            'account_key' => 'goodwill'
        ],
        'patents'=> [
            'name' => '特許権',
            'classification' => 'non_current_assets',
            'account_key' => 'patents'
        ],
        'copyrights'=> [
            'name' => '著作権',
            'classification' => 'non_current_assets',
            'account_key' => 'copyrights'
        ],
        'investment_securities'=> [
            'name' => '投資有価証券',
            'classification' => 'non_current_assets',
            'account_key' => 'investment_securities'
        ],
        'organization_costs'=> [
            'name' => '創立費',
            'classification' => 'non_current_assets',
            'account_key' => 'organization_costs'
        ],
        'notes_payable'=> [
            'name' => '支払手形',
            'classification' => 'current_liabilities',
            'account_key' => 'notes_payable'
        ],
        'accounts_payable'=> [
            'name' => '買掛金',
            'classification' => 'current_liabilities',
            'account_key' => 'accounts_payable'
        ],
        'short_term_loans_payable'=> [
            'name' => '短期借入金',
            'classification' => 'current_liabilities',
            'account_key' => 'short_term_loans_payable'
        ],
        'income_taxes_payable'=> [
            'name' => '未払法人税等',
            'classification' => 'current_liabilities',
            'account_key' => 'income_taxes_payable'
        ],
        'accrued_expenses'=> [
            'name' => '未払費用',
            'classification' => 'current_liabilities',
            'account_key' => 'accrued_expenses'
        ],
        'advances_from_customers'=> [
            'name' => '前受金',
            'classification' => 'current_liabilities',
            'account_key' => 'advances_from_customers'
        ],
        'deferred_revenues'=> [
            'name' => '前受収益',
            'classification' => 'current_liabilities',
            'account_key' => 'deferred_revenues'
        ],
        'bonds_payable'=> [
            'name' => '社債',
            'classification' => 'non_current_liabilities',
            'account_key' => 'bonds_payable'
        ],
        'long_term_loans_payable'=> [
            'name' => '長期借入金',
            'classification' => 'non_current_liabilities',
            'account_key' => 'long_term_loans_payable'
        ],
        'deposits_received'=> [
            'name' => '受入保証金',
            'classification' => 'non_current_liabilities',
            'account_key' => 'deposits_received'
        ],
        'common_stock'=> [
            'name' => '資本金',
            'classification' => 'equity',
            'account_key' => 'common_stock'
        ],
        'retained_earnings'=> [
            'name' => '利益剰余金',
            'classification' => 'equity',
            'account_key' => 'retained_earnings'
        ],
        'income_taxes_current'=> [
            'name' => '法人税・住民税および事業税',
            'classification' => 'income_taxes',
            'account_key' => 'income_taxes_current'
        ],
    ]
];
