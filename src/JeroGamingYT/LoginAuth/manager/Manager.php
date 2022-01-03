<?php 

/*
 * LoginAuth plugin for PocketMine-MP
 * Copyright (C) 2022 JeroGamingYT-pm-pl <https://github.com/JeroGamingYT-pm-pl/LoginAuth>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
*/

declare(strict_types=1);

namespace JeroGamingYT\LoginAuth\manager;

use pocketmine\player\Player;
use pocketmine\Server;
use JeroGamingYT\LoginAuth\Main;

class Manager 
{

	public $login = [];

	public function __construct()
	{
		//TODO
	}

	public function getMain(): ?Main 
	{
		$loader = Server::getInstance()->getPluginManager()->getPlugin("LoginAuth");
		if($loader instanceof Main){
			return $loader;
		}
		return null;
	}

	/**
	 * @param string $username
	 */
	public function setPlayerAuthenticated(string $username)
	{
		$this->login[$username] = true;
	}

	/**
	 * @param  string $username
	 */
	public function unPlayerAuthenticated(string $username)
	{
		unset($this->login[$username]);
	}

	/**
	 * @param  Player  $player
	 * @return boolean
	 */
	public function isPlayerAuthenticated(Player $player)
	{
		return in_array($player->getName(), $this->login);
	}
}
