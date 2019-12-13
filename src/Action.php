<?php

namespace Kingsquare\Trello;

/**
*
* API Reference: https://developers.trello.com/advanced-reference/action
*/
class Action extends Trello
{
	/**
	 * The string of collection on Trello API.
	 * Will be used to generate the URLs for requests.
	 * @var string
	 */
	public $collection = "action";

	public $id = "";

}
