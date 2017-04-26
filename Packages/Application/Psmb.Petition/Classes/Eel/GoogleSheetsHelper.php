<?php
namespace Psmb\Petition\Eel;

use Neos\Flow\Annotations as Flow;
use Neos\Eel\ProtectedContextAwareInterface;

class GoogleSheetsHelper implements ProtectedContextAwareInterface
{
	/**
	 * Fetches published Google Spreadsheet and converts it into an array of assoc arrays
	 * @return array
	 */
	public function get($documentId) {
		$result = [];
		$url = 'https://docs.google.com/spreadsheets/d/' . $documentId . '/pub?output=csv';
		if (($handle = fopen($url, 'r')) !== FALSE) {
			$headers = null;
			while (($row = fgetcsv($handle)) !== FALSE) {
				if ($row) {
					if (!$headers) {
						$headers = $row;
					} else {
						$newRow = [];
						foreach($row as $i => $column) {
							$newRow[$headers[$i]] = $column;
						}
						$result[] = $newRow;
					}
				}
			}
			fclose($handle);
		}
		return $result;
	}

	/**
	 * All methods are considered safe
	 *
	 * @param string $methodName
	 * @return boolean
	 */
	public function allowsCallOfMethod($methodName)
	{
		return true;
	}
}
