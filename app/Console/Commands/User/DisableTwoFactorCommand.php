<?php

namespace Pterodactyl\Console\Commands\User;

use Illuminate\Console\Command;
use Pterodactyl\Contracts\Repository\UserRepositoryInterface;

class DisableTwoFactorCommand extends Command
{
    protected $description = 'Désactive l’authentification à deux facteurs pour un utilisateur spécifique du Panel.';

    protected $signature = 'p:user:disable2fa {--email= : Adresse e-mail de l’utilisateur pour lequel désactiver l’authentification à deux facteurs.}';

    /**
     * DisableTwoFactorCommand constructor.
     */
    public function __construct(private UserRepositoryInterface $repository)
    {
        parent::__construct();
    }

    /**
     * Handle command execution process.
     *
     * @throws \Pterodactyl\Exceptions\Model\DataValidationException
     * @throws \Pterodactyl\Exceptions\Repository\RecordNotFoundException
     */
    public function handle()
    {
        if ($this->input->isInteractive()) {
            $this->output->warning(trans('command/messages.user.2fa_help_text'));
        }

        $email = $this->option('email') ?? $this->ask(trans('command/messages.user.ask_email'));
        $user = $this->repository->setColumns(['id', 'email'])->findFirstWhere([['email', '=', $email]]);

        $this->repository->withoutFreshModel()->update($user->id, [
            'use_totp' => false,
            'totp_secret' => null,
        ]);
        $this->info(trans('command/messages.user.2fa_disabled', ['email' => $user->email]));
    }
}
