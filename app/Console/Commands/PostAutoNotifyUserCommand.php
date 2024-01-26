<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class PostAutoNotifyUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'post-auto-notify-user:manage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto Notify All Users About New Post Update';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // $users = User::where('role','=','Student')->get(['email'])->pluck('email')->toArray();
        // foreach ($users as $email) {
        //     \Log::info('email sent to :  '.$email);
        // }
        // \Log::info('Total Email Sent :  '.count($users));
    }
}
