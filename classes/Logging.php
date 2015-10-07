<?php


    class Logging {
        // declare log file and file pointer as private properties
        public $log_file, $fp;
        private $timestamp;
        // set log file (path and name)

        public function lfile($path) {
            $this->log_file = $path;

            $name = explode('/', $this->log_file);
            $name = array_pop($name);

            if($name == 'query.log')
            {
                $this->timestamp = time();
                $this->lwrite('BEGIN: ' . $this->timestamp . "#####");
            }
        }
        // write message to the log file
        public function lwrite($message) {
            // if file pointer doesn't exist, then open log file
            if (!is_resource($this->fp)) {
                $this->lopen();
            }
            // define script name
            if(empty($_SERVER['PHP_SELF']))
            {
                $php_self = 'cron';
            }
            else
            {
                $php_self = $_SERVER['PHP_SELF'];
            }
            $script_name = pathinfo($php_self, PATHINFO_FILENAME);
            // define current time and suppress E_WARNING if using the system TZ settings
            // (don't forget to set the INI setting date.timezone)
            $time = @date('[d/M/Y:H:i:s]');
            // write current time, script name and message to the log file
            fwrite($this->fp, "$time ($script_name) $message" . PHP_EOL);
        }
        // close log file (it's always a good idea to close a file when you're done with it)
        public function lclose() {

            $name = explode('/', $this->log_file);
            $name = array_pop($name);
            if($name  == 'query.log')
            {
                $this->lwrite('END: ' . $this->timestamp . "#####");
            }
            fclose($this->fp);
        }
        // open log file (private method)
        private function lopen() {
            // in case of Windows set default log file
//            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
//                $log_file_default = 'logfile.txt';
//            }
//            // set default log file for Linux and other systems
//            else {
                $log_file_default = '/logs/error.log';
//            }
            // define log file from lfile method or use previously set default
            $lfile = $this->log_file ? $this->log_file : $log_file_default;
            // open log file for writing only and place file pointer at the end of the file
            // (if the file does not exist, try to create it)
            $this->fp = fopen($lfile, 'a') or exit("Can't open $lfile!");
        }

    }
