<?php 

/*
 * This file is part of the naminator\cstrike package.
 *
 * (c) Lachezar Tsochev <ltsochev@live.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

 namespace naminator\cstrike;

class PlayerEntry
{
	private $columns = array('name', 'unique', 'tks', 'damage', 
		'deaths', 'kills', 'shots', 'hits', 'hs', 'bDefusions', 'bDefused',
		'bPlants', 'bExplosions', 'bodyHits' => array(
			'head', 'chest', 'stomach', 'leftarm', 'rightarm', 'leftleg', 'rightleg'
		));

	public $name; // string
	public $unique; // string
	public $tks; // uint
	public $damage; // uint
	public $deaths; // unit
	public $kills; // int
	public $shots; // short
	public $hits; // short
	public $hs; // short
	public $bDefusions; // short
	public $bDefused; // short
	public $bPlants; // short
	public $bExplosions; // short
	public $bodyHits = array();

	public function getColumns()
	{
		return $this->columns;
	}
}