<?php

/**
 * Created by PhpStorm.
 * User: rsi
 * Date: 08-Feb-16
 * Time: 9:30 PM
 */

namespace App\Shell;

use Cake\Console\Shell;
use Cake\ORM\TableRegistry;

class RetriveCountryShell extends Shell {

    public function initialize() {
        parent::initialize();
    }
    
    public function preMain($schedule = null)
    {
        if (!$schedule) {
            $this->out();
            $this->err('Missing the parameter \'schedule\'');
            $this->out('Please set the parameter along with the command.');
            $this->out();
            $this->out('eg :- backend start pre main "*/60 * * * *"');
            $this->out();
            $this->out('*    *    *    *    *');
            $this->out('|    |    |    |    |');
            $this->out('|    |    |    |    |');
            $this->out('|    |    |    |    \----- day of week (0 - 6) (0 to 6 are Sunday to Saturday,');
            $this->out('|    |    |    |           or use names)');
            $this->out('|    |    |    \---------- month (1 - 12)');
            $this->out('|    |    \--------------- day of month (1 - 31)');
            $this->out('|    \-------------------- hour (0 - 23)');
            $this->out('\------------------------- min (0 - 59)');
            $this->out();

            $schedule = $this->in('Please pass in the schedule in the above mentioned format');
            $this->clear();
        }

        $schedule = trim($schedule);

        if ($this->validateSchedule($schedule)) {
            $this->out('Setting up...');

            $cron = $schedule . ' ' . USER_COUNTRY_NAME_CODE;

            if ($this->cronjobExists(USER_COUNTRY_NAME_CODE)) {
                $this->out('Existing backend job found. Removing ...');

                $removeCommand = "crontab -l | grep -v '" . USER_COUNTRY_NAME_CODE . "' | crontab -";

                shell_exec($removeCommand);

                $this->out("Removed existing backend job!");
            }

            $this->appendCronjob($cron);
            $this->out('New backend job added successfully!');
        }
    }
    
    public function main() {

        $this->out('Start');

        $userIpsTable = TableRegistry::get('user_ips');
        $usersTable = TableRegistry::get('users');
        $userIpsHistoryTable = TableRegistry::get('user_ip_histories');
        
        $users_ips = $userIpsTable->find('all')->toArray();

        $total_rec = count($users_ips);
        $total_steps = ceil($total_rec / LIMIT_FOR_IPS);
        $offset = 0;

        if ($total_rec > 0) {

            for ($i = 1; $i <= $total_steps; $i++) {

                $users_ips = $userIpsTable->find('all', array('limit' => LIMIT_FOR_IPS))
                        ->offset($offset)
                        ->toArray();

//               echo "<pre>";
//                print_r($users_ips);
//                echo "<pre>";

                foreach ($users_ips as $users_ip) {

                    $ip_data = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $users_ip['ip']));

                    if ($ip_data->geoplugin_countryCode != null && $ip_data->geoplugin_countryName != null) {

                        $userIpsHistoryTable->query()
                                ->insert(['id', 'user_id','ip','created_on','modified_on'])
                                ->values([
                                    'id'=>$users_ip['id'],
                                    'user_id' => $users_ip['user_id'],
                                    'ip'=> $users_ip['ip'],
                                    'created_on'=> date("Y-m-d H:i:s"),
                                    'modified_on' => date("Y-m-d H:i:s")
                                ])
                                ->execute();
                        
                                              
                        $usersTable->query()
                                ->update()
                                ->set(['country_code' => $ip_data->geoplugin_countryCode, 'country_name' => $ip_data->geoplugin_countryName])
                                ->where(['id' => $users_ip['user_id']])
                                ->execute();
                        
                        $users_ips_processed[] = $users_ip['id'];
                    }
                }

                $offset += LIMIT_FOR_IPS;
            }

            foreach ($users_ips_processed as $user_ip_processed) {
                $userIpsTable->query()
                        ->delete()
                        ->where(['id' => $user_ip_processed])
                        ->execute();
            }

            $this->out('End.');
        } else {
            $this->out('There is no record');
        }
    }
    
    function validateSchedule($schedule)
    {
        $scheduleParamArray = preg_split('/\s+/', $schedule);
        $count = count($scheduleParamArray);
        if ($count != 5) {
            $this->error("Invalid schedule");
        }

        return true;
    }
    
    function cronjobExists($command)
    {
        $cronjob_exists = false;
        $crontab = null;

        exec('crontab -l', $crontab);


        if (isset($crontab) && is_array($crontab)) {

            foreach ($crontab as $tab) {
                if (strpos($tab, $command) !== false) {
                    $cronjob_exists = true;
                }
            }
        }
        return $cronjob_exists;
    }
    
    function appendCronjob($command)
    {
        $output = null;
        if (is_string($command) && !empty($command)) {
            $executingCommand = 'echo -e "`crontab -l`\n' . $command . '" | crontab -';

            exec($executingCommand, $output);
        }

        return $output;
    }
    
}
