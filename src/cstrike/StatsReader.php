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

use InvalidArgumentException;
use Exception;

use naminator\cstrike\BinaryReader;
use naminator\cstrike\PlayerEntry;
use naminator\cstrike\Collection;

class StatsReader
{
	/**
	 * Library version
	 * 
	 * @var int
	 */
	const VERSION = "1.0.0";

	/**
	 * Library supported version
	 * 
	 * @var int
	 */
	const RANK_VERSION = 11;

	/**
	 * Instance of naminatr\cstrike\BinaryReader
	 * 
	 * @var naminator\cstrike\BinaryReader
	 */
	protected $reader;

	/**
	 * Instance of naminator\cstrike\Collection
	 * 
	 * @var naminator\cstrike\Collection
	 */
	private $players;

	/**
	 * In-Memory cache of the user's count
	 * 
	 * @var int
	 */
	private $playerCount = 0;

	/**
	 * Creates an instance of the reader
	 * 
	 * @param string $filePath
	 * @return void
	 */
	public function __construct($filePath)
	{
		/*if (!file_exists($filePath))
		{
			throw new InvalidArgumentException("The specified file path is invalid.");
		}*/

		if (!is_readable($filePath))
		{
			throw new InvalidArgumentException("The specified file path is not readable by the PHP script.");
		}

		$contents = file_get_contents($filePath);
		if ($contents === false)
		{
			throw new Exception("Unable to open the file for reading.");
		}

		$this->reader = new BinaryReader($contents);
		$this->players = new Collection();

		if (!$this->validateRankVersion())
		{
			throw new Exception("Unsupported rank version for the StatsReader.");
		}

		$this->readPlayers();
		$this->playerCount = $this->players->count();
	}

	/**
	 * The number of people in the csstats.dat
	 * file
	 * 
	 * @return int
	 */
	public function getPlayerCount()
	{
		return $this->playerCount;
	}

	/**
	 * Retrieves the collection of players
	 * 
	 * @return naminator\cstrike\Collection
	 */
	public function getPlayers()
	{
		return $this->players;
	}

	/**
	 * Retrieves the Top X Player entries
	 * 
	 * @param int $limit (default: 15)
	 * @return naminator\cstrike\Collection
	 */
	public function getTopPlayers($limit = 15)
	{
		$orderMap = array(
			'kills'		=> 'desc',
			'deaths'	=> 'asc',
			'shots'		=> 'asc');

		return $this->players->sort(function($playerA, $playerB) use($orderMap) {

			foreach($orderMap as $key=>$sortDirection)
			{
				switch($sortDirection)
				{
					case 'desc':
						$direction = -1;
						break;
					case 'asc':
					default:
						$direction = 1;
						break;
				}

				if ($playerA->{$key} > $playerB->{$key})
				{
					return $direction;
				}
				else if ($playerA->{$key} < $playerB->{$key})
				{
					return $direction * -1;
				}
			}
			
			return 0;
		});
	}

	/**
	 * Checks whether the current passed
	 * CSStats.dat file is a valid file format
	 * and version
	 * 
	 * @return bool
	 */
	private function validateRankVersion()
	{
		$version = $this->reader->readShort();
		return ($version == static::RANK_VERSION);
	}

	/**
	 * Reads the CSStats.dat file and
	 * parses all the players in it into.
	 * naminator\cstrike\Collections
	 * 
	 * @return void
	 */
	private function readPlayers()
	{
		$num = $this->reader->readShort();

		while($num != 0)
		{
			$entry = new PlayerEntry;

			// $num equals the length of the username
			$entry->name = $this->reader->readStringData($num);

			// $num equals the length of the unique name
			$num = $this->reader->readShort();

			$entry->unique 		= $this->reader->readStringData($num);
			$entry->tks 		= $this->reader->readIntData();
			$entry->damage 		= $this->reader->readIntData();
			$entry->deaths 		= $this->reader->readIntData();
			$entry->kills 		= $this->reader->readIntData();
			$entry->shots 		= $this->reader->readIntData();
			$entry->hits 		= $this->reader->readIntData();
			$entry->hs 			= $this->reader->readIntData();
			$entry->bDefusions 	= $this->reader->readIntData();
			$entry->bDefused 	= $this->reader->readIntData();
			$entry->bPlants 	= $this->reader->readIntData();
			$entry->bExplosions	= $this->reader->readIntData();

			$this->reader->readIntData();

			// Body hits
			$entry->bodyHits['head'] 		= $this->reader->readIntData();
			$entry->bodyHits['chest'] 		= $this->reader->readIntData();
			$entry->bodyHits['stomach'] 	= $this->reader->readIntData();
			$entry->bodyHits['leftarm'] 	= $this->reader->readIntData();
			$entry->bodyHits['rightarm'] 	= $this->reader->readIntData();
			$entry->bodyHits['leftleg'] 	= $this->reader->readIntData();
			$entry->bodyHits['rightleg'] 	= $this->reader->readIntData();

			$this->reader->readIntData();
			$num = $this->reader->readShort();

			$this->players[] = $entry;
		}
	}
}