<?php
/**
 * NOVIUS OS - Web OS for digital communication
 *
 * @copyright  2011 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */

namespace Nos\TaskManager;

class Controller_Admin_Application extends \Nos\Controller_Admin_Application
{
    public function action_index()
    {
        $path_to_module = array();
        foreach (array_keys(\Nos\Config_Data::get('app_installed')) as $module) {
            //\Module::load($module);
            $path = \Module::exists($module);
            \Finder::instance()->add_path($path);
            $path_to_module[$path] = $module;
        }

        $path_to_module[NOSPATH] = 'nos';

        $site_key = \Arr::get(\Config::load('crypt', true), 'crypto_key');

        $tasks = array();
        $raw_tasks = \Finder::instance()->list_files('tasks');
        foreach ($raw_tasks as $task) {
            if (!\Str::starts_with($task, COREPATH)) {
                $task_filename = pathinfo($task, PATHINFO_FILENAME);
                $module_path = substr($task, 0, strlen($task) - strlen('tasks/'.$task_filename.'.php'));
                if (isset($path_to_module[$module_path])) {
                    $module = $path_to_module[$module_path];
                } else {
                    $module = 'local';
                }
                $task_identifier = $module.'::'.$task_filename;
                if (!isset($tasks[$module])) {
                    $tasks[$module] = array();
                }
                $hash = md5($site_key.'_'.$task_identifier);
                $tasks[$module][$task_identifier] = array(
                    'identifier' => $task_identifier,
                    'relative_url' => 'apps/novius_taskmanager/execute_task.php?task='.$task_identifier.'&check='.$hash
                );
            }
        }

        return \View::forge('novius_taskmanager::admin/list', array('tasks' => $tasks), false);
    }
}
