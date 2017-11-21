<?php
namespace Dfe\AlphaCommerceHub;
use Dfe\AlphaCommerceHub\Source\Option as Opt;
use Magento\Framework\Phrase;
/**
 * 2017-11-20
 * 1) "Show the chosen payment option in the Magento's «Payment Information» blocks
 * (backend, frontend, emails)": https://github.com/mage2pro/alphacommercehub/issues/40
 * 2) "What is the recommended way to detect the chosen payment option from a `SuccessURL` response?"
 * https://mage2.pro/t/4978
 * 3) "What is the recommended way to detect the chosen payment option from a `CancelURL` response?"
 * https://mage2.pro/t/4979
 */
final class Choice extends \Df\Payment\Choice {
	/**
	 * 2017-11-21
	 * @used-by \Dfe\AlphaCommerceHub\Block\Info::prepare()
	 * @return bool
	 */
	function isBankCard() {return 'CC' === $this->id();}

	/**
	 * 2017-11-20
	 * @override
	 * @see \Df\Payment\Choice::title()
	 * @used-by \Df\Payment\Block\Info::choiceT()
	 * @used-by \Df\Payment\Observer\DataProvider\SearchResult::execute()
	 * @see \Dfe\AlphaCommerceHub\Charge::pCharge():
	 * 		'Method' => $this->m()->option() ?: (!$o->isLimited() ? 'ALL' : df_csv($o->allowed()))
	 * https://github.com/mage2pro/alphacommercehub/blob/0.3.6/Charge.php#L243-L261
	 * @return Phrase|string|null
	 */
	function title() {return dfc($this, function() {return dftr($this->id(), Opt::s()->map());});}

	/**
	 * 2017-11-21
	 * @used-by isBankCard()
	 * @used-by title()
	 * @return string
	 */
	private function id() {return $this->req('Method');}
}