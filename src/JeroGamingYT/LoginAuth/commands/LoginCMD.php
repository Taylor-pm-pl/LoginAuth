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

namespace JeroGamingYT\LoginAuth\commands;

use JeroGamingYT\LoginAuth\Main;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginOwned;

class LoginCMD extends Command implements PluginOwned
{	
	/** @Var Main $plugin */
	public Main $plugin;
	
	/**
	 * @param Main $plugin
	 */
	public function __construct(Main $plugin)
	{
		$this->plugin = $plugin;
		parent::__construct("login");
		$this->setDescription($this->plugin->getProvider()->getMessage("description.login"));
	}

	public function getMain(): Main
	{
		return $this->plugin;
	}

	public function getOwningPlugin() : Plugin
	{
		return $this->getMain();
	}

	/**
	 * @param  CommandSender $sender
	 * @param  String        $commandLabel
	 * @param  Array         $args
	 * @return void
	 */
	public function execute(CommandSender $sender, String $commandLabel, Array $args): void 
	{
		if(!$sender instanceof Player)
		{
			$sender->sendMessage($this->getMain()->getProvider()->getMessage("error.useingame"));
			return;
		}

		$username = $sender->getName();
    	if(!$this->getMain()->getProvider()->accountExists($sender)){
    		$sender->sendMessage($this->getMain()->getProvider()->getMessage("login.account-not-exists"));
    		return;
    	}
    	if(!isset($args[0])){
    		$sender->sendMessage($this->getMain()->getProvider()->getMessage("login.usage"));
    		return;
    	}
    	$password = $args[0];

		$data = $this->getMain()->getProvider()->getPassword($sender);

		if(hash_equals($data, $this->getMain()->getProvider()->hash($sender->getName(), $password)) and $this->getMain()->getManager()->isPlayerAuthenticated($sender)){
			$this->getMain()->getManager()->unPlayerAuthenticated($username);
			$sender->sendMessage($this->getMain()->getProvider()->getMessage("login.success"));
			return;
		}else{
			$sender->sendMessage($this->getMain()->getProvider()->getMessage("login.password-wrong"));
			return;
		}
	}
}
