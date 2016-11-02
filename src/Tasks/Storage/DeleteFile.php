<?php namespace BackupManager\Tasks\Storage;

use League\Flysystem\Filesystem;
use BackupManager\Tasks\Task;

/**
 * Class DeleteFile
 * @package BackupManager\Tasks\Storage
 */
class DeleteFile implements Task {

    /** @var Filesystem */
    private $filesystem;
    /** @var string*/
    private $filePath;

    /**
     * @param Filesystem $filesystem
     * @param $filePath
     */
    public function __construct(Filesystem $filesystem, $filePath) {
        $this->filesystem = $filesystem;
        $this->filePath = $filePath;
    }

    /**
     * @return bool
     */
    public function execute() {
        if ($this->filesystem->getMimetype($this->filePath) == 'application/x-gzip') {

            if ($this->filesystem->getMimetype(str_replace('.tar.gz', '', $this->filePath)) == 'directory') {
                $this->filesystem->deleteDir(str_replace('.tar.gz', '', $this->filePath));
            }
        }

        if ($this->filesystem->getMimetype($this->filePath) == 'directory') {
            return $this->filesystem->deleteDir($this->filePath);

        } else {
            return $this->filesystem->delete($this->filePath);
        }
    }
}
