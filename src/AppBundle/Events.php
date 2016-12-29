<?php

namespace AppBundle;

final class Events
{
    const TASK_CREATED = 'task.created';
    const TASK_FLIP = 'task.flip';
    const TASK_ACTIVATED = 'task.activated';
    const GAME_CREATED = 'game.created';
    const GAME_STARTED = 'game.started';
    const PLAYER_JOINED_GAME = 'player.joined';
    const PLAYER_PICKED_CARD = 'player.picked';
    const PLAYER_DROPOUT = 'player.dropout';
    const PLAYER_ONLINE = 'player.online';
}
