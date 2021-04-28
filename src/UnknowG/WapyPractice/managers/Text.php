<?php

namespace UnknowG\WapyPractice\managers;

class Text{
    const PREFIX = " §9§l» §r§f";
    const PREFIX_REVERSED = " §9§l«";

    const PREFIX_YELLOW = " §e§l» §r§f";
    const PREFIX_REVERSED_YELLOW = " §e§l«";

    const PREFIX_BOOST = " §d§l» §r§f";
    const PREFIX_REVERSED_BOOST = " §d§l«";

    const CONSOLE_COMMAND ="Vous ne pouvez pas éxecuter cette commande dans la console";

    const PRIMARY_COLOR = "§9";
    const SECONDARY_COLOR = "§f";

    const FORMATS = [
        null=>"{PC}[{SC}{rank}{PC}] {PC}[{SC}{OS}{PC}] {SC}{name} {PC}§l»§r {SC}{msg}",
        "GAPPLE_RANKED"=>"{SC}[{PC}{LEAGUE}{SC}] {name} {PC}§l»§r {SC}{msg}",
        "GAPPLE"=>"{SC}[{PC}{KD} K/D{SC}] {SC}{name} {PC}§l»§r {SC}{msg}",
        "FIL"=>"{SC}{name} {PC}§l»§r {SC}{msg}",
        "SUMO"=>"{SC}{name} {PC}§l»§r {SC}{msg}",
    ];

    const GAMES_SB = [
        "GAPPLE"=>"Gapple",
        "GAPPLE_RANKED"=>"Gapple Ranked",
        "FIL"=>"Floor Is Lava",
        "SUMO"=>"Sumo",
    ];
}