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

namespace JeroGamingYT\LoginAuth;

use pocketmine\plugin\PluginBase;
use JeroGamingYT\LoginAuth\manager\Manager;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat as TF;
use JeroGamingYT\LoginAuth\provider\Provider;
use JeroGamingYT\LoginAuth\commands\{LoginCMD, RegisterCMD, ChangepasswordCMD};

class Main extends PluginBase
{

	public function onEnable(): void 
	{
		$this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
		$this->provider = new Provider();
		$this->provider->openConfig();

		$this->manager = new Manager();
		$this->getServer()->getCommandMap()->register("login", new LoginCMD($this));
		$this->getServer()->getCommandMap()->register("register", new RegisterCMD($this));
		$this->getServer()->getCommandMap()->register("changepassword", new ChangepasswordCMD($this));
		$this->getServer()->getAsyncPool()->submitTask(new checkUpdate());
	}

	public function getProvider(): ?Provider
	{
		return $this->provider;
	}

	public function getManager(): ?Manager 
	{
		return $this->manager;
	}
}