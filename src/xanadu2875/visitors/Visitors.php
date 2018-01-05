<?php

namespace xanadu2875\visitors;

use pocketmine\plugin\PluginBase;
use pocketmine\event;
use pocketmine\utils\Config;
use pocketmine\utils\Utils;

class Visitors extends PluginBase implements event\Listener
{
  private $numberDB;
  private $total;
  private static $server;
  private $logger;

  public function onLoad()
  {
    self::$server = $this;

    @mkdir($this->getDataFolder(), 777);

    $this->total = (new Config($this->getDataFolder()."Total.json", Config::JSON, ["total" => 0]))->get("total");

    try{
      $this->numberDB = new \SQLite3($this->getDataFolder() . "Number.db");
    }
    catch(\Exception $e)
    {
      $this->getServer()->getLogger()->critical("Couldn't connect to SQLite3 database: " . $this->numberDB->connect_error);
      $this->getServer()->getPluginManager()->disabelPlugin($this);
    }
    try {
      $this->numberDB->query("CREATE TABLE IF NOT EXISTS number(
        user_name TEXT PRIMARY KEY
      )");
    } catch (\Exception $e) {
      $this->getServer()->getLogger()->critical("Couldn't create table: " . $this->numberDB->error);
      $this->getServer()->getPluginManager()->disabelPlugin($this);
    }

    $this->logger = $this->getServer()->getLogger();
  }

  public function onEnable()
  {
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
    $this->logger->info("実参加人数は{$this->getNumber()}、延べ参加人数は{$this->getTotal()}です。");
  }

  public function onDisable()
  {
    ($config = new Config($this->getDataFolder()."Total.json", Config::JSON))->set("total", $this->total);
    $config->save();
  }

  public static function getInstance() : PluginBase
  {
    return self::server();
  }

  private function checkUpdata(): bool
  {
    $res = str_replace('\n', "", Utils::getURL("https://raw.githubusercontent.com/Xanadu2875/VersionManager/master/RuleBook"));
    return $res === $this->getDescription()->getVersion() ? false : true;
  }

  public function getTotal() : int { return $this->total; }

  public function getNumber() : int { return $this->numberDB->querySingle("SELECT COUNT(*) FROM number"); }

  public function onJoin(event\player\PlayerJoinEvent $event)
  {
    $this->total++;
    $player = $event->getPlayer();
    $name = strtolower($player->getName());
    if(!($this->numberDB->query("SELECT * FROM number WHERE user_name='" . $this->numberDB->escapeString($name) . "'")->fetchArray()))
    {
      $this->numberDB->query("INSERT INTO number (user_name) VALUES ('" . $this->numberDB->escapeString($name) . "')");
    }
  }
}
