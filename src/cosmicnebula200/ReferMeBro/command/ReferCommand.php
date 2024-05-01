<?php

namespace cosmicnebula200\ReferMeBro\command;

use CortexPE\Commando\BaseCommand;
use cosmicnebula200\ReferMeBro\ReferMeBro;
use cosmicnebula200\ReferMeBro\Utils;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use Vecnavium\FormsUI\CustomForm;
use Vecnavium\FormsUI\SimpleForm;

class ReferCommand extends BaseCommand
{

    protected function prepare(): void
    {
     $this->setPermission("refermebro.command.refer");
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        if (!$sender instanceof Player)
            return;
        $form = new SimpleForm(function (Player $player, int|null $data): void {
            if ($data === null)
                return;
            switch ($data)
            {
                case 0:
                    Utils::sendReferForm($player);
                    break;
                case 1:
                    $form = new CustomForm(function (Player $player, ?array $array){

                    });
                    $name = ReferMeBro::getInstance()->getPlayerManager()->getPlayer($player->getName());
                    if($name !== null) {
                    $form->setTitle(TextFormat::colorize(ReferMeBro::$forms->getNested("view-form.title")));
                    $form->addLabel(TextFormat::colorize(str_replace("{CODE}", $name->getReferral(), ReferMeBro::$forms->getNested("view-form.content"))));
                    $form->sendToPlayer($player);
                  }else{
                   $player->sendMessage("§cUnknow Error!!");
                }
            }
        });
        $form->setTitle(TextFormat::colorize(ReferMeBro::$forms->getNested('refer-command.title' , '&l&dReferMeBro')));
        $form->addButton(TextFormat::colorize(ReferMeBro::$forms->getNested('refer-command.enter' , '&l&dEnter')));
        $form->addButton(TextFormat::colorize(ReferMeBro::$forms->getNested('refer-command.view' , '&l&dView')));
        $form->sendToPlayer($sender);
    }

}
