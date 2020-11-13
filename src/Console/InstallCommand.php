<?php

namespace Wink\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Wink\WinkAuthor;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wink:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install all of the Wink resources';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->comment('Publishing Wink Assets...');
        $this->callSilent('vendor:publish', ['--tag' => 'wink-assets']);

        $this->comment('Publishing Wink Migrations...');
        $this->callSilent('vendor:publish', ['--tag' => 'wink-migrations']);

        $this->comment('Publishing Wink Configuration...');
        $this->callSilent('vendor:publish', ['--tag' => 'wink-config']);

        $this->info('Wink was installed successfully.');

        $shouldCreateNewAuthor =
            ! Schema::connection(config('wink.database_connection'))->hasTable('wink_authors') ||
            ! WinkAuthor::count();

        if ($shouldCreateNewAuthor) {
            $email = ! $this->argument('email') ? 'admin@mail.com' : $this->argument('email');
            $password = ! $this->argument('password') ? Str::random() : $this->argument('password');

            WinkAuthor::create([
                'id' => (int) Str::random(),
                'name' => 'HERA Admin',
                'slug' => 'hera-admin',
                'bio' => 'HERA administration',
                'email' => $email,
                'password' => Hash::make($password),
            ]);

            $this->line('');
            $this->line('');
            $this->line('Wink is ready for use. Enjoy!');
            $this->line('You may log in using <info>'.$email.'</info> and password: <info>'.$password.'</info>');

        }
    }
}
