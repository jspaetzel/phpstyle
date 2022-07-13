<?php

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

require dirname(__DIR__) . '/vendor/autoload.php';

function run_process($process)
{
    $process->run();

    if (!$process->isSuccessful()) {
        throw new ProcessFailedException($process);
    }
}

function create_composer_json($package_dir): string
{
    $package_dir = json_encode($package_dir);

    return <<<JSON
        {
            "repositories": [
                {
                    "type": "path",
                    "url": {$package_dir},
                    "options": {
                        "symlink": false
                    }
                }
            ],
            "require":{
                "jspaetzel/phpstyle": "dev-main"
            }
        }
        JSON;
}

function install()
{
    $project_dir = realpath(sys_get_temp_dir()) . DIRECTORY_SEPARATOR . uniqid('', true);
    $package_dir = dirname(__DIR__);

    if (!mkdir($project_dir) && !is_dir($project_dir)) {
        throw new RuntimeException(sprintf('Directory "%s" was not created', $project_dir));
    }

    echo "Installing to: {$project_dir}\n";

    $fs = new Filesystem();

    try {
        $fs->dumpFile("{$project_dir}/composer.json", create_composer_json($package_dir));

        run_process(new Process(['composer', 'install'], $project_dir));
    } catch (Exception $e) {
        throw $e;
    } finally {
        $fs->remove($project_dir);
    }
}

install();
