<?php

namespace App\Services;

class CurrencyExchangeService {

	// This can be injected in AppServiceProvider at register method, 
	// but that means request to 'europa.eu' will be done at every request to laravel server
	// That so it will be used on demand, untill results is not cached 
	public function getRates() {
		$url = 'https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml';
		$req = curl_init();
		curl_setopt($req, CURLOPT_URL, $url);
		curl_setopt($req, CURLOPT_RETURNTRANSFER, 1);
		$res = curl_exec($req);
		curl_close($req);

		$parser = xml_parser_create();
		xml_parse_into_struct($parser, $res, $vals, $index);
		xml_parser_free($parser);
		return collect($vals)->filter(function ($item) {
				return $item['level'] === 4;
			})
			->map(function ($item) {
				return [
					$item['attributes']['CURRENCY'] => $item['attributes']['RATE'],
				];
			})
			->collapse()
			->toArray();
	}

	/**
	 * Converts value in EUR into specified currency
	 * 
	 * @param  string $to    3-letter key code of final currency
	 * @param  float  $value value to be calculated
	 * @return float         converted value
	 */
	public function convert(string $to, float $value) {
		$rates = $this->getRates();
		$code = strtoupper($to);
		if (array_key_exists($code, $rates)) {
			return round($rates[$code] * $value, 2);
		} else {
			throw new \Exception("Unknown currency code: {$to}");
		}
	}
}