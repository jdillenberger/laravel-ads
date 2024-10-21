<?php

namespace Jdillenberger\LaravelBaseline\Commands;

class ImpersonateAuthCommand extends \Illuminate\Console\Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auth:impersonate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create impersonification tokens for users by id. ';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        do {

            $user_id = $this->ask('Enter the Id of the user, you want to impersonate:');

            if (getBaselineUserModel()::withoutGlobalScopes()->where('id', $user_id)->exists()) {
                break;
            }

            $this->error('This user does not exist. Please try again!');

        } while (true);

        $user = getBaselineUserModel()::withoutGlobalScopes()->find($user_id);

        $this->line('Selected User: '.($user->email ?? 'Anonymous User')."\n\n");

        $token = str()->random(45);

        \Illuminate\Support\Facades\Cache::put("impersonate-$token", $user_id, now()->addDay());

        $this->info('Please use the the following token to impersonate the target user:');
        $this->line($token);
    }
}
