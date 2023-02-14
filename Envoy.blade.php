
@setup
    require __DIR__.'/vendor/autoload.php';
	$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
	try {
		$dotenv->load();
		$dotenv->required(['DEPLOY_SERVER_DEV', 'DEPLOY_PATH_DEV'])->notEmpty();
	} catch ( Exception $e )  {
		echo $e->getMessage();
		exit;
	}


    $repository = 'git@gitlab.sib.swiss:mark16-vre-group/etalk.git';

    $server_dev = $_ENV['DEPLOY_SERVER_DEV'] ?? null;
    $server_prod = $_ENV['DEPLOY_SERVER_PROD'] ?? null;

    $deploy_path_dev = $_ENV['DEPLOY_PATH_DEV'] ?? null;
    $deploy_path_prod = $_ENV['DEPLOY_PATH_PROD'] ?? null;
    
    $app_dir = $server === 'prod' ?  $deploy_path_prod :  $deploy_path_dev ;
    
    $server = isset($server) ? $server : 'dev' ;

@endsetup


@servers(['dev' => $server_dev, 'prod' => $server_prod])


@story('deploy', ['on' => $server])
    pull_repository
    run_composer
    migrate_database
    restart_queue_workers
@endstory


@task('pull_repository')
    cd {{ $app_dir }}
    git pull
@endtask


@task('run_composer')
    echo "Running composer"
    cd {{ $app_dir }}    
    composer install --prefer-dist --no-scripts -q -o
@endtask


@task('migrate_database')
    echo "Migrating database"
    cd {{ $app_dir }}
    php artisan migrate --force
@endtask


@task('restart_queue_workers')
    echo "Restart Queue Workers"
    cd {{ $app_dir }}
    php artisan queue:restart
@endtask

