<?php
/**
 * Created by PhpStorm.
 * User: rsi
 * Date: 08-Feb-16
 * Time: 9:30 PM
 */

namespace App\Shell;


use Cake\Console\Shell;
use Cake\Datasource\ConnectionManager;

class BackendShell extends Shell
{

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Artists');
    }

    public function main()
    {
        $this->out('Hello world.');
    }

    public function startArtistProc($schedule = null)
    {
        if (!$schedule) {
            $this->out();
            $this->err('Missing the parameter \'schedule\'');
            $this->out('Please set the parameter along with the command.');
            $this->out();
            $this->out('eg :- backend start_artist_proc "0 * * * *"');
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

            $cron = $schedule . ' ' . BP_ARTISTS_CRON;

            if ($this->cronjobExists(BP_ARTISTS_CRON)) {
                $this->out('Existing backend job found. Removing ...');

                $removeCommand = "crontab -l | grep -v '" . BP_ARTISTS_CRON . "' | crontab -";

                shell_exec($removeCommand);

                $this->out("Removed existing backend job!");
            }

            $this->appendCronjob($cron);
            $this->out('New backend job added successfully!');
        }
    }


    public function artistProc()
    {
        $this->out("Artist proc started!");

        $connection =  ConnectionManager::get('default');
        $totalCommentsPerArtist = $connection->query('SELECT contents.artist_id, COUNT(contents.artist_id) AS total_comments FROM contents INNER JOIN content_comments ON content_comments.content_id = contents.id GROUP BY contents.artist_id');
        $totalLikesPerArtist = $connection->query('SELECT contents.artist_id, COUNT(contents.artist_id) AS total_likes FROM contents INNER JOIN collections ON collections.content_id = contents.id WHERE collections.type = 1 GROUP BY contents.artist_id');
        $totalFollowersPerArtist = $connection->query('SELECT artist_id, COUNT(*) AS total_followers FROM ( SELECT cc.user_id, c.artist_id FROM content_comments cc INNER JOIN contents c on cc.content_id = c.id UNION SELECT ccs.user_id, c.artist_id FROM collections ccs INNER JOIN contents c on ccs.content_id = c.id WHERE ccs.type = 1) AS t GROUP BY artist_id');

        $connection->begin();
        foreach($totalCommentsPerArtist as $totalComments){
            $connection->execute('UPDATE artists SET artists.total_comments = ? WHERE artists.id = ?', [
                $totalComments['total_comments'], $totalComments['artist_id']
            ]);

            $this->out('artist_id - ' . $totalComments['artist_id']. ' total_comments - '. $totalComments['total_comments']);
        }

        foreach($totalLikesPerArtist as $totalLikes){
            $connection->execute('UPDATE artists SET artists.total_likes = ? WHERE artists.id = ?', [
                $totalLikes['total_likes'], $totalLikes['artist_id']
            ]);

            $this->out('artist_id - ' . $totalLikes['artist_id']. ' total_likes - '. $totalLikes['total_likes']);
        }

        foreach($totalFollowersPerArtist as $totalFollowers){
            $connection->execute('UPDATE artists SET artists.total_followers = ? WHERE artists.id = ?', [
                $totalFollowers['total_followers'], $totalFollowers['artist_id']
            ]);

            $this->out('artist_id - ' . $totalFollowers['artist_id']. ' total_followers - '. $totalFollowers['total_followers']);
        }

        $connection->commit();

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