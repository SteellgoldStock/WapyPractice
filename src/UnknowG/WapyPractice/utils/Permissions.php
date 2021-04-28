<?php

namespace UnknowG\WapyPractice\utils;

class Permissions{
    const PLAYER = [""];
    const VIP = ["options_plus","vip"];
    const VIP_PLUS = ["options_plus","vip_plus"];
    const PREMIUM = ["options_plus","vip_plus","premium"];
    const BOOSTER = [""];
    const YOUTUBER = [""];
    const HELPER = ["kick","mute"];
    const MODERATOR = ["ban","kick","mute","say","gamemode"];
    const ADMINISTRATOR = ["npc","say","gamemode","buildBreak","buildPlace"];
    const OWNER = ["*"];
}