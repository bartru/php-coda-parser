<?php

namespace Codelicious\Coda\SimplifiedData;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class AccountTransactions
{
	public $date;
	public $account;
	public $original_balance;
	public $new_balance;
	public $free_message;

	public $transactions = array();
}