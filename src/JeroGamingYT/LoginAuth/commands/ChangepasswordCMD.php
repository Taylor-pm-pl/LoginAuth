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

class ChangepasswordCMD extends Command implements PluginOwned
{	
	/**
	 * @param Main $plugin
	 */
	public function __construct(Main $plugin)
	{
		$this->plugin = $plugin;
		parent::__construct("changepassword");
		$this->setDescription($this->plugin->getProvider()->getMessage("description.changepassword"));
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
    	if(!isset($args[0]) or !isset($args[1]))
    	{
    		$sender->sendMessage($this->getMain()->getProvider()->getMesage("changepassword.usage"));
    		return;
    	}

    	if(8 > strlen($args[0]))
    	{
    		$sender->sendMessage($this->getMain()->getProvider()->getMessage("changepassword.if"));
    		return;
    	}

    	if($args[0] !== $args[1])
    	{
    		$sender->sendMessage($this->getMain()->getProvider()->getMessage("changepassword.error"));
    		return;
    	}
    	$this->getMain()->getProvider()->deleteProfile($sender);
    	$this->getMain()->getProvider()->createProfile($sender, $args[0]);
    	$sender->sendMessage($this->getMain()->getProvider()->getMessage("changepassword.success"));
	}
}