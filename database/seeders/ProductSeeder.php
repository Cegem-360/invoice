<?php

namespace Database\Seeders;

use App\Models\Product;

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
            $reader = XmlReader::fromString($xml);
            $products = $reader->values()['response']['product'];
            $product = $reader->values()['response']['product'][0];

            dump($product);
            dump($product['Arak']);
            foreach ($products as $product) {
                Product::create([
                    'nev' => $this->clear_string($product['Nev']),
                    'sku' => $this->clear_string($product['CikkSzam']),
                    'ean' => $this->clear_string($product['EAN']),
                    'price' => $this->clear_string($product['Arak'][0]['Arcsoport_Ar']),
                    'price_kivitelezok' => $this->clear_string($product['Arak'][6]['Arcsoport_Ar']),
                    'price_kp_elore_harminc' => $this->clear_string($product['Arak'][4]['Arcsoport_Ar']),
                    'price_kp_elore_huszonot' => $this->clear_string($product['Arak'][3]['Arcsoport_Ar']),
                ]);
            }
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
