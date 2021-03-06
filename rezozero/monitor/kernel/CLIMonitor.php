<?php
namespace rezozero\monitor\kernel;

use Psr\Log\LoggerInterface;
use \rezozero\monitor\engine\Collector;
use \rezozero\monitor\engine\PersistedData;
use \rezozero\monitor\view;
use \rezozero\monitor\view\CLIOutput;

class CLIMonitor
{
    private $output;
    private $colors;
    private $collector;
    private $data;

    public function __construct(&$CONF, PersistedData &$data, LoggerInterface $log)
    {
        $this->output = new view\CLIOutput();
        $this->colors = new view\Colors();
        $this->data = $data;

        CLIOutput::echoAT(
            0,
            0,
            $this->colors->getColoredString(
                'Please wait for RZ Monitor to crawl your websites',
                'white',
                'black'
            )
        );

        $this->collector = new Collector('sites.json', $CONF, $this->data, $log);

        $this->output->parseArray($this->collector->getStatuses());
        system("clear");
        echo $this->output->output();

        $this->output->flushContent();
    }
}
