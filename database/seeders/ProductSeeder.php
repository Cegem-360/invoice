<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\WoocommerceProduct;
use Automattic\WooCommerce\Client;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Saloon\XmlWrangler\XmlReader;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $regnev = 'pa2006';
        $password = 'rL9bxiDcJgGUfe71Mvtu4rd6T6xcGVjxRmUyF1GgFgoOapdyzD';

        // Example usage of httpGet method
        $response = $this->httpGet('http://api.innvoice.hu/'.$regnev.'/product', $regnev, $password);
        if ($response->successful()) {
            $xml = $response->body();
            // dump($xml);
            $reader = XmlReader::fromString($xml);
            $products = $reader->values()['response']['product'];
            $product = $reader->values()['response']['product'][0];

            // dump($product);
            // dump($product['Arak']);
            foreach ($products as $product) {
                $storage = 0;
                $storage = (int) $product['Keszletek']['Keszlet'][0]['Raktar_Keszlet'];
                $storage += (int) $product['Keszletek']['Keszlet'][1]['Raktar_Keszlet'];
                Product::create([
                    'nev' => $this->clear_string($product['Nev']),
                    'sku' => $this->clear_string($product['CikkSzam']),
                    'ean' => $this->clear_string($product['EAN']),
                    'price' => $this->clear_string($product['Arak'][0]['Arcsoport_Ar']),
                    'price_kivitelezok' => $this->clear_string($product['Arak'][6]['Arcsoport_Ar']),
                    'price_kp_elore_harminc' => $this->clear_string($product['Arak'][4]['Arcsoport_Ar']),
                    'price_kp_elore_huszonot' => $this->clear_string($product['Arak'][3]['Arcsoport_Ar']),
                    'storage' => $storage,
                ]);
            }
            $woocommerce = new Client(
                'https://rodelux.hu',
                'ck_77f062e6c6b0bf7e352e813d15d0dd6f469213ff',
                'cs_b063aae48e96abb2ae11906db921013bd5b7cfcd',
                [
                    'version' => 'wc/v3',
                ]

            );
            // 1700 product
            $total_products = $woocommerce->get('products/count')->count;
            $pages = ceil($total_products / 100);
            for ($i = 1; $i <= $pages; $i++) {
                $woocommerce_products = $woocommerce->get('products', ['per_page' => 100, 'page' => $i]);
                foreach ($woocommerce_products as $product) {
                    $product = WoocommerceProduct::create([
                        'wordpress_id' => $product->id,
                        'name' => $product->name,
                        'sku' => $product->sku,
                    ]);
                }
            }
            foreach (WoocommerceProduct::all() as $product) {
                $woocommerce_products = $woocommerce->get('products/'.$product->wordpress_id.'/variations', ['per_page' => 50]);
                foreach ($woocommerce_products as $variation) {
                    $product_inner = Product::whereSku($variation->sku)->first();
                    $product->woocommerceProductVariation()->create([
                        'wordpress_id' => $variation->id,
                        'product_id' => $product_inner ? $product_inner->id : null,
                        'name' => $variation->name,
                        'sku' => $variation->sku,
                    ]);
                }
            }

            /*  foreach (Product::wherehas('woocomerceProductVariation')->get() as $product) {
                 $woocommerce->put('products/'.$product->wordpress_id, [
                     'regular_price' => $product->price,
                     'sale_price' => $product->price_kp_elore_huszonot,
                 ]);
             } */

            // $woocommerce_products = $woocommerce->get('products', ['per_page' => 100]);

        } else {
            dump('GET request failed: '.$response->status());
            dump('Response body: '.$response->body());
            dump('Response headers: '.json_encode($response->headers()));
        }

    }

    /**
     * Send a GET request with basic authentication.
     */
    public function httpGet(string $url, string $username, string $password)
    {
        $response = Http::withBasicAuth($username, $password)->get($url);

        if ($response->failed()) {
            dump('GET request failed: '.$response->status());
            dump('Response body: '.$response->body());
            dump('Response headers: '.json_encode($response->headers()));
            dump('Used credentials: '.$username.' / '.$password);

            return null;
        }

        return $response;
    }

    /**
     * Send a GET request with basic authentication using cURL.
     */
    public function customCurlGet(string $url, string $username, string $password)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_USERPWD, $username.':'.$password);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);

        $output = curl_exec($ch);

        if (curl_errno($ch)) {
            dump('cURL error: '.curl_error($ch));
            curl_close($ch);

            return null;
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($httpCode == 401) {
            dump('GET request failed: 401 Unauthorized');
            curl_close($ch);

            return null;
        }

        curl_close($ch);

        return $output;
    }

    public function clear_string($string)
    {
        return trim(preg_replace('/\s+/', ' ', $string));
    }
}
