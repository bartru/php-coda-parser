<?php

namespace Codelicious\Coda\DetailParsers;
use Codelicious\Coda\Data\DataFactory;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class Transaction32Parser implements ParserInterface
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
	 * Parse the given string containing 32 into a Transaction-object
	 *
	 * @param string $coda32_line
	 * @return object
	 */
	public function parse($coda32_line)
	{
		$coda32 = $this->dataFactory->createDataObject(DataFactory::TRANSACTION32);

		$coda32->sequence_number = trim(substr($coda32_line, 2, 4));
		$coda32->sequence_number_detail = trim(substr($coda32_line, 6, 4));
		$coda32->message = trim_space(substr($coda32_line, 10, 105));

		return $coda32;
	}

	public function accept_string($coda_line)
	{
		return strlen($coda_line) == 128 && substr($coda_line, 0, 2) == "32";
	}
}
