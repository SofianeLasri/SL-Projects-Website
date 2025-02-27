@servers(['vps1' => 'gitlab-deployer@vps1.sl-projects.com'])

@setup
$repository = 'https://gitlab.sl-projects.com/sl-projects/sl-projects-website.git';
$releases_dir = '/home/serveur-web/sl-projects.com/prod/releases';
$app_dir = '/home/serveur-web/sl-projects.com/prod';
$release = date('YmdHis');
$new_release_dir = $releases_dir .'/'. $release;
@endsetup

@story('deploy')
clone_repository
run_composer
run_npm
update_symlinks
migration
@endstory

@task('clone_repository')
echo 'Cloning repository'
[ -d {{ $releases_dir }} ] || mkdir {{ $releases_dir }}
git clone --depth 1 {{ $repository }} {{ $new_release_dir }}
cd {{ $new_release_dir }}
git reset --hard {{ $commit }}
@endtask

@task('run_composer')
echo "Starting deployment ({{ $release }})"
cd {{ $new_release_dir }}
composer install --no-scripts -q -o
php artisan ziggy:generate
@endtask

@task('run_npm')
echo "Running npm install"
cd {{ $new_release_dir }}
npm install
echo "Building Vite"
npm run build
@endtask

@task('update_symlinks')
echo "Linking storage directory"
rm -rf {{ $new_release_dir }}/storage
ln -nfs {{ $app_dir }}/storage {{ $new_release_dir }}/storage

echo "Linking bootstrap/cache directory"
rm -rf {{ $new_release_dir }}/bootstrap/cache
ln -nfs {{ $app_dir }}/bootstrap/cache {{ $new_release_dir }}/bootstrap/cache

echo 'Linking .env file'
ln -nfs {{ $app_dir }}/.env {{ $new_release_dir }}/.env

echo 'Linking current release'
ln -nfs {{ $new_release_dir }} {{ $app_dir }}/current
@endtask

@task('migration')
cd {{ $new_release_dir }}
php artisan down
echo "Migrating the database"
php artisan migrate --force
echo "Clearing cache"
php artisan optimize:clear
php artisan up
@endtask
