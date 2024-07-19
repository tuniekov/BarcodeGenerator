<?php
/** @var xPDOTransport $transport */
/** @var array $options */
/** @var modX $modx */
if ($transport->xpdo) {
    $modx =& $transport->xpdo;

    $dev = MODX_BASE_PATH . 'Extras/BarcodeGenerator/';
    /** @var xPDOCacheManager $cache */
    $cache = $modx->getCacheManager();
    if (file_exists($dev) && $cache) {
        if (!is_link($dev . 'assets/components/barcodegenerator')) {
            $cache->deleteTree(
                $dev . 'assets/components/barcodegenerator/',
                ['deleteTop' => true, 'skipDirs' => false, 'extensions' => []]
            );
            symlink(MODX_ASSETS_PATH . 'components/barcodegenerator/', $dev . 'assets/components/barcodegenerator');
        }
        if (!is_link($dev . 'core/components/barcodegenerator')) {
            $cache->deleteTree(
                $dev . 'core/components/barcodegenerator/',
                ['deleteTop' => true, 'skipDirs' => false, 'extensions' => []]
            );
            symlink(MODX_CORE_PATH . 'components/barcodegenerator/', $dev . 'core/components/barcodegenerator');
        }
    }
}

return true;