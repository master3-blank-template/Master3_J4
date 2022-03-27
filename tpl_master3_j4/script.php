<?php

/**
 * @package     Joomla.Site
 * @subpackage  Templates.Master3_J4
 * @copyright   Copyright (C) Aleksey A. Morozov. All rights reserved.
 * @license     GNU General Public License version 3 or later; see http://www.gnu.org/licenses/gpl-3.0.txt
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Version;
use Joomla\CMS\Filesystem\Path;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Installer\Installer;
use Joomla\CMS\Installer\InstallerHelper;
use Joomla\Archive\Archive;

class master3_j4InstallerScript
{
    public function preflight($type, $parent)
    {
        $minJoomlaVersion = $parent->getManifest()->attributes()->version[0];

        if (!class_exists('Joomla\CMS\Version')) {
            \JFactory::getApplication()->enqueueMessage(
                \JText::sprintf('J_JOOMLA_COMPATIBLE', \JText::_($parent->getName()), $minJoomlaVersion),
                'error'
            );
            return false;
        }

        if (strtolower($type) === 'install' && Version::MAJOR_VERSION < 4) {
            $msg = '';
            $name = Text::_($parent->getName());
            $minPhpVersion = $parent->getManifest()->php_minimum[0];

            $ver = new Version();

            if (version_compare($ver->getShortVersion(), $minJoomlaVersion, 'lt')) {
                $msg .= Text::sprintf('J_JOOMLA_COMPATIBLE', $name, $minJoomlaVersion);
            }

            if (version_compare(phpversion(), $minPhpVersion, 'lt')) {
                $msg .= Text::sprintf('J_PHP_COMPATIBLE', $name, $minPhpVersion);
            }

            if ($msg) {
                $app = Factory::getContainer()->get(Joomla\CMS\Application\AdministratorApplication::class);
                $app->enqueueMessage($msg, 'error');
                return false;
            }
        }
    }

    public function postflight($type, $parent)
    {
        if (strtolower($type) === 'uninstall') {
            return;
        }

        $msg = '';

        $res = $this->copyLayouts($parent->getParent());
        if (!$res) {
            $msg .= Text::_('TPL_MASTER3_UNABLE_TO_COPY');
        }

        $res = $this->installUikit3($parent);
        if ($res !== true) {
            $msg .= Text::sprintf('TPL_MASTER3_UIKIT3_INSTALLATION_ERROR', $res);
        }

        $customCss = Path::clean(JPATH_ROOT . '/templates/master3_j4/css/custom.css');
        if (!file_exists($customCss)) {
            try {
                $dir = pathinfo($customCss, PATHINFO_DIRNAME);
                if (!is_dir($dir)) {
                    mkdir($dir);
                    file_put_contents($customCss, "/* Master3_J4 custom CSS */\n");
                }
            } catch (\Exception $e) {}
        }

        $customJs = Path::clean(JPATH_ROOT . '/templates/master3_j4/js/custom.js');
        if (!file_exists($customJs)) {
            try {
                $dir = pathinfo($customJs, PATHINFO_DIRNAME);
                if (!is_dir($dir)) {
                    mkdir($dir);
                    file_put_contents($customJs, "/* Master3_J4 custom JS */\n");
                }
            } catch (\Exception $e) {}
        }

        if ($msg) {
            $app = Factory::getContainer()->get(Joomla\CMS\Application\AdministratorApplication::class);
            $app->enqueueMessage($msg, 'error');
            return false;
        }
    }

    private function copyLayouts($installer)
    {
        $folder = Path::clean(JPATH_ROOT . '/templates/master3_j4/layouts/');

        $files = [
            'template.default-original.php' => 'template.default.php',
            'template.offline-original.php' => 'template.offline.php',
            'template.error-original.php'   => 'template.error.php',
        ];

        $copyFiles = [];
        foreach ($files as $fo => $f) {
            $path         = [];
            $path['src']  = Path::clean($folder . $fo);
            $path['dest'] = Path::clean($folder . $f);
            $path['type'] = 'file';
            if (!file_exists($path['dest'])) {
                $copyFiles[] = $path;
            }
        }

        return $installer->copyFiles($copyFiles);
    }

    private function installUikit3($parent)
    {
        $isUikit3 = false;
        $actualVersion = (string) $parent->getManifest()->uikit_actual[0];

        $manifestFile = Path::clean(JPATH_ADMINISTRATOR . '/manifests/files/file_uikit3.xml');

        if (file_exists(Path::clean($manifestFile))) {
            $xml = simplexml_load_file($manifestFile);
            if ($xml) {
                $xml = (array) $xml;
                $uikitVersion = $xml['version'];
                if (!version_compare($actualVersion, $uikitVersion, 'gt')) {
                    $isUikit3 = true;
                }
            }
            unset($xml);
        }

        if (!$isUikit3) {
            $app = Factory::getContainer()->get(Joomla\CMS\Application\AdministratorApplication::class);

            $tmp = $app->getConfig()->get('tmp_path');
            $uikitFile = 'https://master3.alekvolsk.info/files/uikit3_v' . $actualVersion . '_j4.zip';
            $tmpFile = Path::clean($tmp . '/uikit3_v' . $actualVersion . '_j4.zip');
            $extDir = Path::clean($tmp . '/' . uniqid('install_'));

            $contents = file_get_contents($uikitFile);
            if ($contents === false) {
                return Text::sprintf('TPL_MASTER3_UIKIT3_IE_FAILED_DOWNLOAD', $uikitFile);
            }

            $resultContents = file_put_contents($tmpFile, $contents);
            if ($resultContents == false) {
                return Text::sprintf('TPL_MASTER3_UIKIT3_IE_FAILED_INSTALLATION', $tmpFile);
            }

            if (!file_exists($tmpFile)) {
                return Text::sprintf('TPL_MASTER3_UIKIT3_IE_NOT_EXISTS', $tmpFile);
            }

            $archive = new Archive(['tmp_path' => $tmp]);
            try {
                $archive->extract($tmpFile, $extDir);
            } catch (\Exception $e) {
                return Text::sprintf('TPL_MASTER3_UIKIT3_IE_FAILER_UNZIP', $tmpFile, $extDir, $e->getMessage());
            }

            $installer = new Installer();
            $installer->setPath('source', $extDir);
            if (!$installer->findManifest()) {
                InstallerHelper::cleanupInstall($tmpFile, $extDir);
                return Text::_('TPL_MASTER3_UIKIT3_IE_INCORRECT_MANIFEST');
            }

            if (!$installer->install($extDir)) {
                InstallerHelper::cleanupInstall($tmpFile, $extDir);
                return Text::_('TPL_MASTER3_UIKIT3_IE_INSTALLER_ERROR');
            }

            InstallerHelper::cleanupInstall($tmpFile, $extDir);
        }

        return true;
    }
}
