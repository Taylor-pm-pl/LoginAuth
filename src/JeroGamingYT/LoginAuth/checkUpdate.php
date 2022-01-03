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

use pocketmine\scheduler\AsyncTask;
use pocketmine\Server;

class checkUpdate extends AsyncTask
{
	
    public function onRun(): void
    {
        $link = 'https://raw.githubusercontent.com/JeroGamingYT-pm-pl/Key-Login/master/key.yml';
        $file = @fopen($link, "rb");
        if ($file == false) {
        	#print("Fail to get new info");
            return;
        }

        $content = "";
        while (!feof($file)) {
            $line_of_text = fgets($file);
            $content = $content . " " . $line_of_text;
        }
        fclose($file);
        
        $content = yaml_parse($content);
        $this->setResult($content);
    }

    public function onCompletion(): void
    {    
        if(is_null($login = Server::getInstance()->getPluginManager()->getPlugin("LoginAuth"))){
            return;
        }
        
        $content = $this->getResult();
        if(!isset($content)) {
            Server::getInstance()->getLogger()->info("§6[LoginAuth] Cant get update information");
            return;
        }
        
        $version = $content["version"];
        if (version_compare($login->getDescription()->getVersion(), $version) < 0) {
            Server::getInstance()->getLogger()->info("§b[LoginAuth] New version $version has been released, download at: https://poggit.pmmp.io/p/LoginAuth/");
        }
    }
}
