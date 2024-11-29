<?php

namespace Database\Seeders;

use Automattic\WooCommerce\Client;
use Illuminate\Database\Seeder;

class WoocommerceProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $woocommerce = new Client(
            'https://rodelux.hu',
            'ck_6e243ce716b7616ffdc3cc7c0b9818fef11f9151',
            'cs_db7dbd8bf661ee5075ba950b22ca37462b25c827',
            [
                'version' => 'wc/v3',
            ]
        );
    }
}
