<?php 

/*
 * This file is part of the naminator\cstrike package.
 *
 * (c) Lachezar Tsochev <ltsochev@live.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

 namespace naminator\cstrike\contracts;

interface Jsonable {

	/**
	 * Convert the object to its JSON representation.
	 *
	 * @param  int  $options
	 * @return string
	 */
	public function toJson($options = 0);

}