<?php

namespace App\Console\Commands;

use Telegram\Bot\Commands\Command;

/**
 * Class HelpCommand.
 */
class Help extends Command
{
    /**
     * @var string Command Name
     */
    protected string $name = 'help';

    /**
     * @var array Command Aliases
     */
    protected array $aliases = ['listcommands'];

    /**
     * @var string Command Description
     */
    protected string $description = 'Ottiene una lista dei comandi disponibili';

    /**
     * {@inheritdoc}
     */
    public function handle(): void
    {
        $commands = \Telegram::getMyCommands();

        $text = '';
        foreach ($commands as $command) {
            $text .= sprintf('/%s - %s'.PHP_EOL, $command['command'], $command['description']);
        }

        $this->replyWithMessage(['text' => $text]);
    }
}
