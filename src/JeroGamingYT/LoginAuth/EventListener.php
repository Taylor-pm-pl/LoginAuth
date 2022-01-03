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

use pocketmine\event\Listener;
use pocketmine\player\Player;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\inventory\InventoryOpenEvent;
use pocketmine\event\entity\EntityItemPickupEvent ;
use pocketmine\event\player\PlayerCommandPreprocessEvent;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerItemConsumeEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\player\PlayerPreLoginEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\player\PlayerRespawnEvent;
use pocketmine\event\entity\EntityDamageEvent;

class EventListener implements Listener
{
	public Main $plugin;
	/**
	 * @param Main $plugin
	 */
	
	public function __construct(Main $plugin)
	{
		$this->plugin = $plugin;
	}

	public function getMain(): ?Main 
	{
		return $this->plugin;
	}

	/**
	 * @param  PlayerJoinEvent $event
	 */
	public function onJoin(PlayerJoinEvent $event)
	{
		$player = $event->getPlayer();
		$username = $player->getName();
		$this->getMain()->getManager()->setPlayerAuthenticated($username);
		if($this->getMain()->getProvider()->accountExists($player)){
			$player->sendMessage($this->getMain()->getProvider()->getMessage("login.usage"));
		} else{
			$player->sendMessage($this->getMain()->getProvider()->getMessage("register.usage"));
		}
	}	

	/**
	 * @param  PlayerMoveEvent $event
	 */
	public function onMove(PlayerMoveEvent $event)
	{
		$player = $event->getPlayer();
		if($this->getMain()->getManager()->isPlayerAuthenticated($player)){
			$event->cancel();
		}
	}

	/**
	 * @param  PlayerCommandPreprocessEvent $event
	 */
	public function onUseCommand(PlayerCommandPreprocessEvent $event)
    {
        $message = explode(" ", $event->getMessage());
        $player = $event->getPlayer();

        if ($this->getMain()->getManager()->isPlayerAuthenticated($player)) {
            if (!in_array($message[0], ["/login", "/register"])) {
                $event->cancel();
            }
        }
    }

    /**
     * @param  PlayerDropItemEvent $event
     */
    public function onDrop(PlayerDropItemEvent $event)
    {
    	$player = $event->getPlayer();
		if($this->getMain()->getManager()->isPlayerAuthenticated($player)){
			$event->cancel();
		}
    }

    /**
     * @param  BlockBreakEvent $event
     */
    public function onBreak(BlockBreakEvent $event)
    {
    	$player = $event->getPlayer();
		if($this->getMain()->getManager()->isPlayerAuthenticated($player)){
			$event->cancel();
		}
    }

    /**
     * @param  BlockPlaceEvent $event
     */
    public function onPlace(BlockPlaceEvent $event)
    {
    	$player = $event->getPlayer();
		if($this->getMain()->getManager()->isPlayerAuthenticated($player)){
			$event->cancel();
		}
    }

    /**
     * @param  PlayerRespawnEvent $event
     */
    public function onPlayerRespawn(PlayerRespawnEvent $event)
    {	
	    	$player = $event->getPlayer();
		if($this->getMain()->getManager()->isPlayerAuthenticated($player)){
			if($this->getMain()->getProvider()->accountExists($player)){
				$player->sendMessage($this->getMain()->getProvider()->getMessage("login.usage"));
			} else{
				$player->sendMessage($this->getMain()->getProvider()->getMessage("register.usage"));
			}
		}
	}

	/**
	 * @param  PlayerInteractEvent $event
	 */
	public function onInterract(PlayerInteractEvent $event)
	{
		$player = $event->getPlayer();
		if($this->getMain()->getManager()->isPlayerAuthenticated($player)){
			$event->cancel();
		}
	}

	/**
	 * @param  PlayerQuitEvent $event
	 */
	public function onQuit(PlayerQuitEvent $event)
	{
		$player = $event->getPlayer();
		if($this->getMain()->getManager()->isPlayerAuthenticated($player)){
			$this->getMain()->getManager()->unPlayerAuthenticated($player->getName());
		}
	}

	/**
	 * @param  PlayerItemConsumeEvent $event
	 */
	public function onCostume(PlayerItemConsumeEvent $event)
	{
		$player = $event->getPlayer();
		if($this->getMain()->getManager()->isPlayerAuthenticated($player)){
			$event->cancel();
		}
	}

	/**
	 * @param  EntityDamageEvent $event
	 */
	public function onEntityDamage(EntityDamageEvent $event)
	{	
		$player = $event->getEntity();
		if($player instanceof Player and $this->getMain()->getManager()->isPlayerAuthenticated($player)){
			$event->cancel();
		}
	}

	/**
	 * @param  InventoryOpenEvent $event
	 */
	public function onInventoryOpen(InventoryOpenEvent $event){
		$player = $event->getPlayer();
		if($this->getMain()->getManager()->isPlayerAuthenticated($player)){
			$event->cancel();
		}
	}
}
