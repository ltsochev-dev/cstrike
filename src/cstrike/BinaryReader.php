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

class BinaryReader
{
	protected $contents;
	private $offset = 0;

	public function __construct($contents)
	{
		if (empty($contents))
		{
			throw new InvalidArgumentException("Empty content passed to the BinaryReader.");
		}

		$this->contents = $contents;
	}

	public function readIntData()
	{
		$data = substr($this->contents, $this->offset, 4);
		$this->offset += 4;
		$unpack = unpack('V', $data);

		return $unpack[1];
	}

	public function readShort()
	{
		$data = substr($this->contents, $this->offset, 2);
		$this->offset += 2;
		$unpack = unpack('v', $data);

		return $unpack[1];
	}

	public function readStringData($len) 
	{
		$data = substr($this->contents, $this->offset, $len);
		$this->offset += $len;
		$str = trim($data);

		return $str;
	}

	public function getOffset()
	{
		return $this->offset;
	}
}