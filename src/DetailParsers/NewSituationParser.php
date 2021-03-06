<?php

namespace Codelicious\Coda\DetailParsers;
use Codelicious\Coda\Data\DataFactory;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class NewSituationParser implements ParserInterface
{
	/**
	 * @var DataFactory
	 */
	private $dataFactory;

	/**
	 * @param DataFactory $dataFactory
	 */
	public function __construct(DataFactory $dataFactory)
	{
		$this->dataFactory = $dataFactory;
	}
	/**
	 * Parse the given string containing 8 into an NewSituation-object
	 *
	 * @param string $coda8_line
	 * @return object
	 */
	public function parse($coda8_line)
	{
		$coda8 = $this->dataFactory->createDataObject(DataFactory::NEW_SITUATION);

		$this->add_account_info($coda8, substr($coda8_line, 4, 37));
		$coda8->statement_sequence_number = trim(substr($coda8_line, 1, 3));
		$coda8->date = "20" . substr($coda8_line, 61, 2) . "-" . substr($coda8_line, 59, 2) . "-" . substr($coda8_line, 57, 2);

		$negative = substr($coda8_line, 41, 1) == "1" ? -1 : 1;
		$coda8->balance = substr($coda8_line, 42, 15)*$negative / 1000;

		return $coda8;
	}

	private function add_account_info(&$coda8, $account_info)
	{
		if (substr($account_info, 0, 1) == "0") {
			$coda8->account_number = substr($account_info, 0, 12);
			$coda8->account_currency = substr($account_info, 13, 3);
			$coda8->account_country = substr($account_info, 17, 2);
		}
		else if (substr($account_info, 0, 1) == "1") {
			$coda8->account_number = substr($account_info, 0, 34);
			$coda8->account_currency = substr($account_info, 34, 3);
		}
		else if (substr($account_info, 0, 1) == "2") {
			$coda8->account_number_is_iban = TRUE;
			$coda8->account_number = substr($account_info, 0, 31);
			$coda8->account_currency = substr($account_info, 34, 3);
			$coda8->account_country = "BE";
		}
		else if (substr($account_info, 0, 1) == "3") {
			$coda8->account_number_is_iban = TRUE;
			$coda8->account_number = substr($account_info, 0, 34);
			$coda8->account_currency = substr($account_info, 34, 3);
		}
	}

	public function accept_string($coda_line)
	{
		return strlen($coda_line) == 128 && substr($coda_line, 0, 1) == "8";
	}
}
