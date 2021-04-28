<?php

namespace UnknowG\WapyPractice\langs;

use UnknowG\WapyPractice\managers\Text;

class FR{
    public static $tr = [
        "PLAYER_NAME" => "Nom du joueur",
        "MESSAGE" => "Message",
        "PLAYERS"=>"joueurs",
        "RANK"=>"Grade",
        "PET"=>"Animal de compagnie",
        "TAG"=>"Tag",

        "DURING"=>"pendant",
        "DURING_TEXT"=>"pendant §9{TIME} {FORMAT}",

        "DAYS"=>"jours",
        "HOURS"=>"heures",
        "MINUTES"=>"minutes",
        "SECONDS"=>"secondes",

        "BACK"=>"Retour",
        "SECOND"=>"secondes",
        "END_IN"=>"Fin dans",
        "LEVEL"=>"Niveau ",
        "UNLOCKED"=>"Débloqué",
        "LOCKED"=>"Bloqué",

        "PLAYTIME"=>"Vous jouez depuis",

        "TP_COOLDOWN" => Text::PREFIX . "§fTéléportation dans §9{SECONDS} §fseconde(s)" . Text::PREFIX_REVERSED,
        "TP_SUCCESS" => Text::PREFIX . "§fTéléportation réussie" . Text::PREFIX_REVERSED,
        "TP_FAIL" => Text::PREFIX . "§fTéléportation annulée" . Text::PREFIX_REVERSED,

        "TIP_BOOST_WAPASS_XP"=>Text::PREFIX_BOOST . "§f+{EXP_SUPP} EXP (Niveau: §d{LEVEL}§f)" . Text::PREFIX_REVERSED_BOOST,
        "TIP_WAPASS_XP"=>Text::PREFIX . "§f+{EXP_SUPP} EXP (Niveau: §9{LEVEL}§f)" . Text::PREFIX_REVERSED,
        "WAPASS_HOME"=>"Vous êtes palier §9{LEVEL} §favec §9{EXP} exp §fvotre prochaine récompense sera §9{NEXT_REWARD}",
        "BOOST_END" => "§fPlus que §d{TIME} secondes §fde boost",
        "NO_BOOST" => Text::PREFIX_BOOST . "Vous n'avez actuellement aucun boosters de disponibles, vous pouvez en acheter sur la §dboutique §fou alors en gagner dans le §dcoffre de récompense",
        "BOOSTERS_COUNT_CHOOSE"=>"Combien voulez vous activer de booster(s) ?",
        "BOOSTERS_DESCRIPTION"=>"Qu'es ce que c'est ?\n\n".
            "§9§l- §r§fLes §9boosters §fsont des points qui permette de doubler, tripler, quadrupler vos experience gagner pendant §930 minutes§f, au nombre de points que vous utiliserer\n\n".
            "§9§l» §r§fComment en avoir ?\n".
            "§9§l- §r§fVous devez en acheter sur la boutique du serveur ou alors les gagner pendant des évènement ou dans des coffres de récompenses",
        "BOOST_ENDING_RECAP" => Text::PREFIX_BOOST . "Avec votre multiplicateur d'experience vous avez accumulez §d{XP} experience §fsupplémentaire !",
        "BOOSTERS"=>"Boosters",
        "BOOSTERS_USE"=>"Utiliser des boosters",
        "WAPASS_REWARD_LIST"=>"Récompenses",
        "WAPASS_TITLE"=>"Passe de récompenses",
        "PERMISSION_ERROR" => Text::PREFIX . "Vous n'avez pas les permissions requises pour executer cette action (§9{ACTION}§f)",
        "PERMISSIONS_ERROR" => Text::PREFIX . "Vous n'avez pas les permissions requises pour executer cette action (§9{ACTION}§f)",
        "ARGUMENT_ERROR" => Text::PREFIX . "Votre argument n'est pas valide, voici la liste d'argument possible: §9{LIST}",
        "ARGUMENT_MISSING" => Text::PREFIX . "Vous avez oublié l'argument §9{ARG} §fqui est §9{ARG_TYPE}",
        "ACTION_REFUSED" => Text::PREFIX . "Votre action a été refusé (§9{ACTION}§f)",
        "GAMEMODE_CHANGE" => Text::PREFIX . "Vous venez de modifier votre mode de jeu (§9{NEW}§f)",
        "SAME_PLAYER" => Text::PREFIX . "Vous ne pouvez pas vous envoyé(e) un message à vous même",
        "MONEY_MORE"=> Text::PREFIX . "Vous n'avez pas assez d'argent (Il vous faut encore §9{MORE}@§f)",

        "BOX_REWARD"=>"Voici la liste des récompenses que vous pouvez obtenir",
        "BOX_ALREADY"=> Text::PREFIX . "Vous êtes tombé sur la récompense, §9{REWARD}§f, mais vous l'êtes déjà, nous vous donnons §9{COINS}@ §fen échange !",
        "BOX_PICK"=> Text::PREFIX . "Quel chance incroyable, vous vennez de récuperer la récompense §9{REWARD} §ffaite-en bonne usage !",
        "BOX_PICK_RANK"=> Text::PREFIX . "Quel chance incroyable, vous vennez de récuperer le grade §9{RANK}§f, il expirera dans §9{HOURS} heures§f, faite-en bonne usage !",
        "NO_CHANCE"=> Text::PREFIX . "Oups, pas de chance, vous êtes tombé sur une case vide, pour te consoler nous te donner §9500@ §fj'espère que cela te fait plaisir",

        "PLAYER_DISCONNECTED" => Text::PREFIX . "Le joueur §9{PLAYER} §fn'est actuellement pas connecté(e)",
        "IN_COMBAT" => Text::PREFIX . "Vous êtes en combat, patientez §9{SECONDS} secondes §fpour quitter",
        "END_COMBAT" => Text::PREFIX . "Encore §9{SECONDS} secondes §fde combat" . Text::PREFIX_REVERSED,

        "LOBBY_TELEPORT_WAIT" => Text::PREFIX . "Vous allez être téléporter au serveur principal dans quelques instants, veuillez patienter...",

        "PATIENT_ITEM_CLICK" => Text::PREFIX . "Patienter encore §9{SECONDS} secondes §favant de recliquer" . Text::PREFIX_REVERSED,

        "PLAYER_JOIN" => Text::PREFIX . "Bienvenue sur §9Wapy Practice",

        "FRIEND_CONNECTED" => "connecté(e)",
        "FRIEND_DISCONNECTED" => "déconnecté(e)",
        "FRIEND_DESCRIPTION" => "Votre ami §9{NAME} §fest actuellement §9{STATUS}",
        "FRIEND_CLICK_HELP" => "Cliquer sur vos amis pour plus d'informations et de possblitées",

        "ITEMS_CUSTOM_NAMES" => [
            "SETTINGS" => "Paramètres",
            "COSMETICS" => "Cosmétiques",
            "GAMES" => "Jeux",
            "STATS" => "Statistiques",
            "PROFILE" => "Profil",
            "FRIENDS" => "Amis",
            "WAPASS"=>"Passe de récompenses"
        ],

        "FORMS_GAMES_HOME_TITLE" => "Accueil des jeux",
        "FORMS_GAMES_HOME_DESCRIPTION" => "A quel type de jeux voulez vous jouer ?",
        "FORMS_GAMES_HOME_BUTTONS_MINIGAMES" => "Mini-Jeux",
        "FORMS_GAMES_HOME_BUTTONS_EVENTS" => "Évènements",
        "FORMS_GAMES_HOME_BUTTONS_RANKED" => "Jeux classées",

        "NO_GAMES_FOUND"=> Text::PREFIX . "Actuellement aucun jeux n'est disponible dans la catégorie §9{CATEGORY}",

        "FORMS_GAMES_PVP_TITLE" => "Catégorie PvP",
        "FORMS_GAMES_PVP_RANKED_TITLE" => "Catégorie Jeux classées",
        "FORMS_GAMES_PVP_MG_TITLE" => "Catégorie Mini-Jeux",
        "FORMS_GAMES_PVP_EVENTS_TITLE" => "Catégorie Évènements",
        "FORMS_GAMES_PVP_DESCRIPTION" => "Les jeux de PvP sont des modes basiques, un équipement, de la nourriture et au combat, pratique pour s'entrainer",

        "FORMS_FRIENDS_TITLE" => "Amis",
        "FORMS_FRIENDS_CHOOSE" => "Quel est votre ambition de cette demande ?",
        "FORMS_FRIENDS_DESCRIPTION" => "Vous avez §9{COUNT} amis§f\n\n\n\n§9§l-§r §f{CONNECTED} sont connecté(e)s\n§9§l-§r §f{DISCONNECTED} sont déconnecté(e)s\n",
        "FORMS_FRIENDS_ADD" => "Ajouter un(e) ami(e)",
        "FORMS_FRIENDS_REMOVE" => "Supprimer un(e) ami(e)",
        "FORMS_FRIENDS_REMOVE_FRIENDLIST" => "Supprimer cet ami",
        "FORMS_FRIENDS_INVITE_PARTY" => "Inviter dans un mode de jeux",

        "FORMS_FRIENDS_ACCEPT" => "Accepter la demande\nde {NAME}",
        "FORMS_FRIENDS_CLAIM" => "Ajouter en ami (Accepter)",
        "FORMS_FRIENDS_DECLINE" => "Décliner la demande",
        "FORMS_FRIENDS_LIST" => "Voir ma liste d'ami(e)s",
        "FORMS_FRIENDS_ADD_INPUT" => "Préciser le nom de ami(e) à ajouter",

        "FRIENDS_ALREADY" => Text::PREFIX . "Vous êtes déjà ami(e) avec §9{NAME}",
        "FRIENDS_REQUEST_SEND" => Text::PREFIX . "Vous avez envoyé(e) une demande d'ami à §9{NAME}§f",
        "FRIENDS_REQUEST_RECEIVED" => Text::PREFIX . "Vous avez reçu une demande d'ami de la part de §9{NAME}",
        "FRIENDS_REQUEST_ACCEPT" => Text::PREFIX . "Vous êtes maintenant ami(e) avec §9{NAME}",
        "FRIENDS_REQUEST_ACCEPTED" => Text::PREFIX . "§9{NAME} §fa accepter votre demande, vous avez un nouvel ami à présent !",
        "FRIENDS_REQUEST_DECLINE" => Text::PREFIX . "Vous avez refusé(e) la demande d'ami de §9{NAME}",
        "FRIENDS_REQUEST_DECLINED" => Text::PREFIX . "§9{NAME} §fa refusé(e) votre demande !",

        "SETTINGS_SHOW_OS"=>"Afficher votre OS",
        "SETTINGS_PRIVATE_MESSAGES"=>"Recevoir des messages privées",
        "SETTINGS_FRIEND_REQUEST"=>"Recevoir des demandes d'ami(e)s",
        "SETTINGS_FLY"=>"Activer le vol",
        "SETTINGS_ANIMATION_LEVEL_UP"=>"Animation de niveau supérieur",
        "SETTINGS_TIMER_BOOST"=>"Afficher le temp restant d'un duplicateur d'exp",
        "SETTINGS_COMBAT_TIP"=>"Message du temp de combat",
        "SETTINGS_SAVED"=> Text::PREFIX . "Vos modifications ont étés prisent en compte !",
        "SETTINGS_FAKE_OS"=>"Modifier votre platforme de jeu",
        "SETTINGS_TITLE"=>"Paramètres",

        "SETTINGS_ON"=>" (§lON§r§f)",
        "SETTINGS_OFF"=>" (§lOFF§r§f)",

        "EFFECT_APPLY"=> Text::PREFIX . "L'effet §9{EFFECT} §fvous a été appliqué(e)",
        "EFFECT_BUY"=> Text::PREFIX . "Bravo pour ce magnifique achat (§9{EFFECT}§f), l'effet vous a été appliqué",
        "EFFECT_BUY_STORE"=> Text::PREFIX . "L'effet §9{EFFECT} §fest achetable sur la boutique au prix d'§9un euro",
        "EFFECT_BUY_TEXT"=>"L'achat de l'effet §9{EFFECT} §fest possible en jeu, au prix de §91000",

        "HAVE"=>"§2Possédé(e)",
        "NOT_HAVE"=>"§cNon possédé(e)",

        "BUY"=>"Acheter",
        "TEST"=>"Tester m'effet",

        "COSMETICS"=>"Cosmétiques",

        "DISABLED_PRIVATES_MESSAGE"=> Text::PREFIX . "Les messages privées de §9{PLAYER} §fsont actuellement désactivées !",
        "DISABLED_FRIEND_REQUEST"=> Text::PREFIX . "Les demandes d'ami(e)s de §9{PLAYER} §fsont actuellement désactivées !",

        "REPLAY_TITLE" => "Rejouer",
        "REPLAY_QUESTION" => "Voulez vous rejouer au jeu §9{GAME} §f?",
        "REPLAY_YES" => "Oui",
        "REPLAY_NO" => "Non",

        "NO_KEYS"=> Text::PREFIX . "Vous n'avez aucune clef",
        "ENDER_PEARL"=> Text::PREFIX . "Patientez §9{TIME} secondes §favant d'en relancer une !". Text::PREFIX_REVERSED,

        "LOBBY_RETURN" => "Lobby",
        "LOBBY_RETURN_QUESTION" => "Voulez vous vraiment quitter le serveur §9{SERVER} §fpour retourner au lobby ?",

        "NPC_SPAWN" => Text::PREFIX . "Vous venez de faire apparaître le PNJ §9{NAME}§f, avec succès !",

        "KILLS" => "Meurtres",
        "DEATHS" => "Morts",
        "RATIO" => "Ratio (K/D)",
        "RANKED" => "Classé",
        "STATS_OF" => "Statistiques de",
        "THIS_GAME" => "cette partie",

        "RANK_EXPIRATION"=> Text::PREFIX ."Le grade de §9{PLAYER} §fqui est §9{RANK} §fexpirera dans §9{DAY}d{HOURS}h{MINUTES}m{SECONDS}s",
        "NO_RANK_EXPIRATION"=> Text::PREFIX ."le grade de §9{PLAYER} §fqui est §9{RANK} §fn'a actuellement aucune restriction d'expiration !",

        ////////////////// BOOSTERS //////////////////////////
        "BOOSTER_XP"=>"Duplicateur d'XP",
        ////////////////// CAPES //////////////////////////
        "CAPE"=>"Cape",
        ////////////////// PERMISSIONS //////////////////////////
        "PERMISSION"=>"Permission",
        "PERM_FLY_LOBBY"=>"Permission de voler dans le lobby et dans les sales d'attentes",
        ////////////////// COINS //////////////////////////
        "COINS"=>"coins",
        "COINS_MAJ"=>"Coins",
        ////////////////// TAGS //////////////////////////
        "TAG_TEXT"=>"affiché devant votre pseudo",
        "OBSIDIAN"=>"Obsidienne",
        ////////////////// PETS //////////////////////////
        "PARROT"=>"Perroquet",

        ////////////////// REWARDS ///////////////////////
        "RW_1"=>"Cape Nutella",
        "RW_2"=>"Compagnon renard",
        "RW_3"=>"Lanceur de TNT",
        "RW_4"=>"Boules de neige",
        "RW_5"=>"Boule de slime",

        "NUTELLA"=>"La cape §9Nutella §fne donne aucun avantage à par de la beauté(e) à votre magnifique personnage",
        "FOX"=>"Qu'il est mignonnn, le compagnon §9Renard§f ne donne aucun avantage à par de la mignonerrie dans l'air !",
        "TNT_LAUNCHER"=>"Si tu cherche des embrouilles le §9Lanceur de TNT §fest fait pour toi, explose des TNT la ou tu veut et qu'en tu veut, un temp de rechargement de §910 secondes §fest appliqué",
        "SNOWBALL"=>"Tu veut rendre malade les autres joueurs, c'est pas gentil mais possible",
        "SLIMEBALL"=>"Saute, saute, saute, comme un Slime !",

        "REWARD_PICK"=>Text::PREFIX . "Vous venez de récuperer la récompense du §9niveau {LEVEL} §fdu passe de récompense, qui est §9{REWARD}",

        "GAPPLE_DEATH"=>Text::PREFIX . "Vous êtes mort(e) pour quitter le mode de jeu executer la commande, §9/leave",
        "SUMO_WIN"=>Text::PREFIX . "Vous avez vaincu §9{PLAYER}§f, vous l'avez fait tomber §9{KILLS} fois§f, et il vous a fait tomber §9{DEATHS} fois §f!",
        "SUMO_LOOSE"=>Text::PREFIX . "Vous avez perdu contre §9{PLAYER}§f, vous l'avez fait tomber §9{KILLS} fois§f, et il vous a fait tomber §9{DEATHS} fois §f!"
    ];
}