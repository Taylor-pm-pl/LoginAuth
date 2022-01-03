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

namespace JeroGamingYT\LoginAuth\provider;

use pocketmine\player\Player;
use pocketmine\utils\Config;
use pocketmine\Server;
use JeroGamingYT\LoginAuth\Main; 

class Provider
{
	public $configversion = "0.0.1";

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

	public function openConfig()
	{
		$this->password = new Config($this->getMain()->getDataFolder()."password.yml", Config::YAML);
		$this->getMain()->saveResource("config.yml");
		$this->msg = new Config($this->getMain()->getDataFolder()."config.yml", Config::YAML);
		$this->checkConfigUpdate();
	}

	public function save(){
		$this->password->save();
	}

	/**
	 * @param  Player $player
	 */
	public function accountExists(Player $player)
	{
		$user = $player->getName();
		if($this->password->exists($user))
		{
			return true;
		} else{
			return false;
		}
	}

	/**
	 * @param Player $player
	 * @param string $password
	 */
	public function createProfile(Player $player, string $password): bool 
	{
		$user = $player->getName();
		if(!$this->accountExists($player))
		{
			$this->password->set($user, $this->hash($user, $password));
			$this->save();
			return true;
		}
		return false;
	}

	/**
	 * @param  Player $sender
	 */
	public function deleteProfile(Player $sender)
	{
		if($this->accountExists($sender)){
			$this->password->remove($sender->getName());
			$this->save();
		}
	}

	/**
	 * @param  Player $sender
	 */
	public function getPassword(Player $sender)
	{
		$user = $sender->getName();
		$pass = $this->password->get($user);
		return $pass;
	}

	private function checkConfigUpdate(): void{

        if(!$this->msg->exists("config-version")){
            @unlink($this->getMain()->getDataFolder()."config.yml");
            $this->getMain()->saveResource("config.yml");
            $this->getMain()->getLogger()->notice("config version does not match! updated new configuration!");
        }

        if($this->msg->get("config-version") !== $this->configversion){
            @unlink($this->getMain()->getDataFolder()."config.yml");
            $this->getMain()->saveResource("config.yml");
            $this->getMain()->getLogger()->notice("config version does not match! updated new configuration!");
        }
    }

    /**
     * @param  string $salt
     * @param  string $password
     */
	public function hash(string $salt, string $password) : string{
		return bin2hex(hash("sha512", $password . $salt, true) ^ hash("whirlpool", $salt . $password, true));
	}

	/**
	 * @param  string $msg
	 */
	public function getMessage(string $msg){
		$msg = $this->msg->getNested($msg);
		$msg = str_replace("&", "§", (string) $msg);
		return $msg;
	}
}