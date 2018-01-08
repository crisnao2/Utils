<?php
namespace Crisnao2\Utils;

/**
* class implement to formatted and conversion between currencies
* 
* @author Cristiano Soares
* @site comerciobr.com
* @version 1.0
*/
class Currency
{
    /**
    * @var string $code current currency in use
    */
	private $code;

    /**
    * @var array $currencies setting currencies
    */
	private $currencies = array();

    /**
    * Method start, popular all currencies disponible to formatted and conversion
    *
    * @param array $currencies
    *        array(['BRL'] =>
    *        'symbol_left'   => 'R$ ',
    *        'symbol_right'   => '',
    *        'decimal_place' => 2,
    *        'decimal_point' => ',',
    *        'thousand_point' => '.',
    *        'value' => 1
    *    );
    * @param string $default_code if omitted, the last currency code will be used
    */
	public function __construct(array $currencies, $default_code = null)
    {
		foreach ($currencies as $code => $currency) {
			$this->currencies[$code] = array(
				'symbol_left'   => isset($currency['symbol_left']) ? $currency['symbol_left'] : '',
				'symbol_right'  => isset($currency['symbol_right']) ? $currency['symbol_right'] : '',
				'decimal_place'  => isset($currency['decimal_place']) ? $currency['decimal_place'] : 2,
				'decimal_point'  => isset($currency['decimal_point']) ? $currency['decimal_point'] : '.',
				'thousand_point'  => isset($currency['thousand_point']) ? $currency['thousand_point'] : '',
				'value'  => isset($currency['value']) ? $currency['value'] : 1
			);
		}

        if (!is_null($default_code)) {
            $this->set($default_code);
        } else {
            $this->set($code);
        }
	}

    /*
    * Set currency to use
    *
    * @param string $currency code currency to use
    *
    * @return void
    */
	public function set($currency)
    {
		$this->code = $currency;
	}

    /*
    * Formatted and/or convert number
    *
    * @param float $number value to formatted
    * @param string $currency (optional) code currency to use
    * @param float $value (optional) value base to used only to conversion
    * @param float $format (optional) used only to formatted
    *
    * @return string
    */
	public function format($number, $currency = '', $value = '', $format = true)
    {
		if ($currency && $this->has($currency)) {
			$symbol_left   = $this->currencies[$currency]['symbol_left'];
			$symbol_right  = $this->currencies[$currency]['symbol_right'];
			$decimal_place = $this->currencies[$currency]['decimal_place'];
		} else {
			$symbol_left   = $this->currencies[$this->code]['symbol_left'];
			$symbol_right  = $this->currencies[$this->code]['symbol_right'];
			$decimal_place = $this->currencies[$this->code]['decimal_place'];

			$currency = $this->code;
		}

		if ($value) {
			$value = $value;
		} else {
			$value = $this->currencies[$currency]['value'];
		}

		if ($value) {
			$value = (float)$number * $value;
		} else {
			$value = $number;
		}

		$string = '';

		if (($symbol_left) && ($format)) {
			$string .= $symbol_left;
		}

		if ($format) {
			$decimal_point = $this->currencies[$currency]['decimal_point'];
		} else {
			$decimal_point = '.';
		}

		if ($format) {
			$thousand_point = $this->currencies[$currency]['thousand_point'];
		} else {
			$thousand_point = '';
		}

		$string .= number_format(round($value, (int)$decimal_place), (int)$decimal_place, $decimal_point, $thousand_point);

		if (($symbol_right) && ($format)) {
			$string .= $symbol_right;
		}

		return $string;
	}

    /*
    * Convert value in one currency to other currency
    *
    * @param float $value value base to used only to conversion
    * @param string $from currency origin
    * @param string $to currency destiny
    *
    * @return float
    */
	public function convert($value, $from, $to)
    {
		if (isset($this->currencies[$from])) {
			$from = $this->currencies[$from]['value'];
		} else {
			$from = 1;
		}

		if (isset($this->currencies[$to])) {
			$to = $this->currencies[$to]['value'];
		} else {
			$to = 1;
		}

		return $value * ($to / $from);
	}

    /*
    * Get symbol the left the of currency
    *
    * @param string $currency (optional) currency to get symbol
    *
    * @return string
    */
	public function getSymbolLeft($currency = '')
    {
		if (!$currency) {
			return $this->currencies[$this->code]['symbol_left'];
		} elseif ($currency && isset($this->currencies[$currency])) {
			return $this->currencies[$currency]['symbol_left'];
		} else {
			return '';
		}
	}

    /*
    * Get symbol the right the of currency
    *
    * @param string $currency (optional) currency to get symbol
    *
    * @return string
    */
	public function getSymbolRight($currency = '')
    {
		if (!$currency) {
			return $this->currencies[$this->code]['symbol_right'];
		} elseif ($currency && isset($this->currencies[$currency])) {
			return $this->currencies[$currency]['symbol_right'];
		} else {
			return '';
		}
	}

    /*
    * Get decimals places
    *
    * @param string $currency (optional) currency to get decimal place
    *
    * @return integer
    */
	public function getDecimalPlace($currency = '')
    {
		if (!$currency) {
			return $this->currencies[$this->code]['decimal_place'];
		} elseif ($currency && isset($this->currencies[$currency])) {
			return $this->currencies[$currency]['decimal_place'];
		} else {
			return 0;
		}
	}

    /*
    * Get code currency in use
    *
    * @return string
    */
	public function getCode()
    {
		return $this->code;
	}

    /*
    * Get value base used to conversion
    *
    * @param string $currency (optional)
    *
    * @return integer
    */
	public function getValue($currency = '')
    {
		if (!$currency) {
			return $this->currencies[$this->code]['value'];
		} elseif ($currency && isset($this->currencies[$currency])) {
			return $this->currencies[$currency]['value'];
		} else {
			return 0;
		}
	}

    /*
    * Check if currency this registered
    *
    * @param string $currency
    *
    * @return boolean
    */
	public function has($currency)
    {
		return isset($this->currencies[$currency]);
	}
}