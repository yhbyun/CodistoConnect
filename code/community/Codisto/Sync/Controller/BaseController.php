<?php
/**
 * Codisto eBay Sync Extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * @category    Codisto
 * @package     Codisto_Sync
 * @copyright   Copyright (c) 2015 On Technology Pty. Ltd. (http://codisto.com/)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

abstract class Codisto_Sync_Controller_BaseController extends Mage_Core_Controller_Front_Action
{
	protected function checkHash($HostKey, $Nonce, $Hash)
	{
		$response = $this->getResponse();
		$r = $HostKey . $Nonce;
		$base = hash('sha256', $r, true);
		$checkHash = base64_encode($base);
		if ($Hash != $checkHash)
		{
			$response->setBody('Hash Mismatch Error.');
		}
		return true;
	}

	private function getAllHeaders($extra = false)
	{
		$server = $this->getRequest()->getServer();

		foreach ($server as $name => $value)
		{
			if (substr($name, 0, 5) == 'HTTP_')
			{
				$name = str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))));
				$headers[$name] = $value;
			} else if ($name == 'CONTENT_TYPE') {
				$headers['Content-Type'] = $value;
			} else if ($name == 'CONTENT_LENGTH') {
				$headers['Content-Length'] = $value;
			}
		}
		if($extra)
			$headers = array_merge($headers, $extra);
		return $headers;
	}
}
