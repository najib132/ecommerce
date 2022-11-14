<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class EcommerceInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ecommerce:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'install dummy data for the ecommerce Application';

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
     * @return mixed
     */
    public function handle()
    {
        if ($this->confirm('this well delete all you current data and install the dummy default data, Are you sure ?')) {

                File::deleteDirectory(public_path('storage/products/dummy'));
                $this->callSilent('storage:link');
                $copySuccess = File::copyDirectory(public_path('img/products'),public_path('storage/products/dummy'));
                if($copySuccess){
                    $this->info('images succefully copied to storage folder');
                }
                $this->call('migrate:fresh', [
                    '--seed' => true,
                ]);

                $this->call('db:seed',[
                '--class' => 'VoyagerDatabaseSeeder',
                ]);

                $this->call('db:seed',[
                    '--class' => 'VoyagerDummyDatabaseSeeder',
                ]);

                $this->call('db:seed', [
                    '--class' => 'DataTypesTableSeederCustom'
                ]);

                $this->call('db:seed', [
                    '--class' => 'DataRowsTableSeederCustom'
                ]);

                $this->call('db:seed', [
                    '--class' => 'MenusTableSeederCustom'
                ]);

                 $this->call('db:seed', [
                    '--class' => 'MenuItemsTableSeederCustom'
                ]);

                $this->call('db:seed', [
                    '--class' => 'RolesTableSeederCustom'
                ]);

                $this->call('db:seed', [
                    '--class' => 'PermissionsTableSeederCustom'
                ]);

                $this->call('db:seed', [
                    '--class' => 'PermissionRoleTableSeeder'
                ]);

                $this->call('db:seed', [
                    '--class' => 'PermissionRoleTableSeederCustom'
                ]);


                $this->call('db:seed', [
                    '--class' => 'UsersTableSeederCustom'
                ]);

                $this->info('Dummy data installed');
           
        }
    }
}
