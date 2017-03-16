<?php

namespace infomcpe;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\utils\Config;
use pocketmine\event\Listener;
use pocketmine\utils\Utils; 
use pocketmine\Server;
use pocketmine\item\Item;
use pocketmine\block\Block;
use pocketmine\scheduler\PluginTask;
use pocketmine\tile\Sign;
use pocketmine\math\Vector3;
use pocketmine\level\particle\AngryVillagerParticle;
use pocketmine\level\particle\BubbleParticle;
use pocketmine\level\particle\CriticalParticle;
use pocketmine\level\particle\DustParticle;
use pocketmine\level\particle\EnchantmentTableParticle;
use pocketmine\level\particle\FloatingTextParticle;
use pocketmine\level\particle\EntityFlameParticle;
use pocketmine\level\particle\ExplodeParticle;
use pocketmine\level\particle\GenericParticle;
use pocketmine\level\particle\HappyVillagerParticle;
use pocketmine\level\particle\ItemBreakParticle;
use pocketmine\level\particle\WaterParticle; //12
use pocketmine\level\Location;

class IParticle extends PluginBase implements Listener {
     const Prfix = '§f[§aIParticle§f]§e ';

    public function onEnable(){
        $this->saveDefaultConfig();
        @mkdir($this->getDataFolder().'particle');
            $this->session = $this->getServer()->getPluginManager()->getPlugin("SessionAPI");
            if ($this->getServer()->getPluginManager()->getPlugin("PluginDownloader")) {
            $this->getServer()->getScheduler()->scheduleAsyncTask(new CheckVersionTask($this, 334));
                    
            if($this->session == NULL){
               if($this->getServer()->getPluginManager()->getPlugin("PluginDownloader")->getDescription()->getVersion() >= '1.4'){
                   $this->getServer()->getPluginManager()->getPlugin("PluginDownloader")->installByID('SessionAPI');
               }
            }
                        }
	    $this->getServer()->getPluginManager()->registerEvents($this, $this);
            $this->getServer()->getScheduler()->scheduleRepeatingTask(new ParticleTimer($this), 20*0.5);
   }
     public function onCommand(CommandSender $sender, Command $command, $label, array $args){
		switch($command->getName()){
                    case 'iparticle':
                        if($sender->isOP()){
                        switch ($args[0]) {
                            case "add":
                                $this->session->createSession($sender->getName(), 'scope', 1);
                                $sender->sendMessage(IParticle::Prfix."Нажмите на блок на котором хотите размистить партикл");
                                break;
                            default:
                                $sender->sendMessage(IParticle::Prfix.'Суб-Команда не найдена');
                                break;
                        }
                         if($args[0] == null){
                        $sender->sendMessage(IParticle::Prfix.'/iparticle add - Добавить партикл');
                    }
                        break;
                   
                }
                }
     }
     public function onPlayerTouch(PlayerInteractEvent $event){
        $player = $event->getPlayer();
         $block = $event->getBlock();
         if($this->session->getSessionData($player->getName(), 'scope') == 1){
             $this->session->createSession($player->getName(), 'scope', 2);
             $player->sendMessage(IParticle::Prfix.'Успешно теперь выберете партикл:');
             $player->sendMessage(IParticle::Prfix.'1 = AngryVillagerParticle (Злой житель)'); 
             $player->sendMessage(IParticle::Prfix.'2 = BubbleParticle');
             $player->sendMessage(IParticle::Prfix.'3 = CriticalParticle');
             $player->sendMessage(IParticle::Prfix.'4 = DustParticle');
             $player->sendMessage(IParticle::Prfix.'5 = EnchantmentTableParticle');
             $player->sendMessage(IParticle::Prfix.'6 = FloatingTextParticle (Летаюший текст)');
             $player->sendMessage(IParticle::Prfix.'7 = EntityFlameParticle (Полный огонь)');
             $player->sendMessage(IParticle::Prfix.'8 = ExplodeParticle (Взрыв)');
             $player->sendMessage(IParticle::Prfix.'9 = GenericParticle');
             $player->sendMessage(IParticle::Prfix.'10 = HappyVillagerParticle  (Счастливый житель)');
             $player->sendMessage(IParticle::Prfix.'11 = ItemBreakParticle');
             $player->sendMessage(IParticle::Prfix.'12 = WaterParticle');
             $this->session->createSession($player->getName(), 'iparticle_data', ":".$block->getX().":".$block->getY().":".$block->getZ().':'.$block->getID());
            }
         
     }
           public function onChat(PlayerChatEvent $event) {
            $player = $event->getPlayer();
            $message = $event->getMessage();
            if($this->session->getSessionData($player->getName(), 'scope') == 2){
                if(is_numeric($message)){
                    switch ($message) {
                        case '1':
                        $this->dataSave($this->session->getSessionData($player->getName(), 'iparticle_data').':'.$message, 'xyz', NULL);
                        $player->sendMessage(IParticle::Prfix.'Успешно. Партикл AngryVillagerParticle добавлен в список');
                        $this->session->createSession($player->getName(), 'scope', null);  
                            break;
                        case 2:
                        $this->dataSave($this->session->getSessionData($player->getName(), 'iparticle_data').':'.$message, 'xyz', NULL);
                        $player->sendMessage(IParticle::Prfix.'Успешно. Партикл BubbleParticle добавлен в список');
                        $this->session->createSession($player->getName(), 'scope', null);  
                            break;
                        case 3:
                        $this->dataSave($this->session->getSessionData($player->getName(), 'iparticle_data').':'.$message, 'xyz', NULL);
                        $player->sendMessage(IParticle::Prfix.'Успешно. Партикл CriticalParticle добавлен в список');
                        $this->session->createSession($player->getName(), 'scope', null);  
                            break;
                        case 4:
                        $this->dataSave($this->session->getSessionData($player->getName(), 'iparticle_data').':'.$message, 'xyz', NULL);
                        $player->sendMessage(IParticle::Prfix.'Успешно. Партикл DustParticle добавлен в список');
                        $this->session->createSession($player->getName(), 'scope', null);  
                            break;
                         case 5:
                        $this->dataSave($this->session->getSessionData($player->getName(), 'iparticle_data').':'.$message, 'xyz', NULL);
                        $player->sendMessage(IParticle::Prfix.'Успешно. Партикл EnchantmentTableParticle добавлен в список');
                        $this->session->createSession($player->getName(), 'scope', null);  
                            break;
                        case 6:
                        $player->sendMessage(IParticle::Prfix.'Поскольку вы выбрали FloatingTextParticle, пожалуйста напишите текст');
                        $this->session->createSession($player->getName(), 'iparticle_text', $this->session->getSessionData($player->getName(), 'iparticle_data').':'.$message);
                        $this->session->createSession($player->getName(), 'scope', 3);
                            break;
                        case 7:
                        $this->dataSave($this->session->getSessionData($player->getName(), 'iparticle_data').':'.$message, 'xyz', NULL);
                        $player->sendMessage(IParticle::Prfix.'Успешно. Партикл EntityFlameParticle добавлен в список');
                        $this->session->createSession($player->getName(), 'scope', null);  
                            break;
                         case 8:
                        $this->dataSave($this->session->getSessionData($player->getName(), 'iparticle_data').':'.$message, 'xyz', NULL);
                        $player->sendMessage(IParticle::Prfix.'Успешно. Партикл ExplodeParticle добавлен в список');
                        $this->session->createSession($player->getName(), 'scope', null);  
                            break;
                        case 9:
                            $this->session->createSession($player->getName(), 'scope', 5);
                            $this->session->createSession($player->getName(), 'iparticle_block', $this->session->getSessionData($player->getName(), 'iparticle_data').':'.$message);
                             $player->sendMessage(IParticle::Prfix.'Поскольку вы выбрали GenericParticle, пожалуйста напишите id ефекта');
                             $player->sendMessage('Список: (https://infomcpe.ru/resources/IParticle.334/)');
                            break;
                        case 10:
                        $this->dataSave($this->session->getSessionData($player->getName(), 'iparticle_data').':'.$message, 'xyz', NULL);
                        $player->sendMessage(IParticle::Prfix.'Успешно. Партикл HappyVillagerParticle добавлен в список'); 
                        break;
                     case 11:
                        $this->session->createSession($player->getName(), 'iparticle_break', $this->session->getSessionData($player->getName(), 'iparticle_data').':'.$message);        
                        $player->sendMessage(IParticle::Prfix.'Поскольку вы выбрали ItemBreakParticle пожалуйста укажите id блока');
                        $this->session->createSession($player->getName(), 'scope', 6);
                            break;
                         case 12:
                        $this->dataSave($this->session->getSessionData($player->getName(), 'iparticle_data').':'.$message, 'xyz', NULL);
                        $player->sendMessage(IParticle::Prfix.'Успешно. Партикл WaterParticle добавлен в список');
                        $this->session->createSession($player->getName(), 'scope', null);  
                            break;
                        default:
                             $player->sendMessage(IParticle::Prfix.'Партикл не найден');
                            break;
                        
                    }
                
                }else{
                  $player->sendMessage(IParticle::Prfix.'Пожалуйста напишите цыфру');
                }
                          
                $event->setCancelled();
            } elseif ($this->session->getSessionData($player->getName(), 'scope') == 4) {
                $this->session->createSession($player->getName(), 'iparticle_text', $this->session->getSessionData($player->getName(), 'iparticle_text').':'.$message);
                 $this->dataSave($this->session->getSessionData($player->getName(), 'iparticle_text'), 'xyz', NULL);
                $player->sendMessage(IParticle::Prfix.'Успешно. Партикл FloatingTextParticle добавлен в список');
                $event->setCancelled();
                $this->session->createSession($player->getName(), 'scope', null);      
            } elseif ($this->session->getSessionData($player->getName(), 'scope') == 3){
                $this->session->createSession($player->getName(), 'iparticle_text', $this->session->getSessionData($player->getName(), 'iparticle_text').':'.$message);
                $player->sendMessage(IParticle::Prfix.'Текст получен теперь напишите заголовок');
                $this->session->createSession($player->getName(), 'scope', 4);
                $event->setCancelled();    
            }elseif ($this->session->getSessionData($player->getName(), 'scope') == 5) {
                $this->session->createSession($player->getName(), 'iparticle_block', $this->session->getSessionData($player->getName(), 'iparticle_block').':'.$message);
                 $this->dataSave($this->session->getSessionData($player->getName(), 'iparticle_block'), 'xyz', NULL);
                $player->sendMessage(IParticle::Prfix.'Успешно. Партикл GenericParticle добавлен в список');
                $event->setCancelled();
                $this->session->createSession($player->getName(), 'scope', null);         
            }else if($this->session->getSessionData($player->getName(), 'scope') == 6){
                 $this->session->createSession($player->getName(), 'iparticle_break', $this->session->getSessionData($player->getName(), 'iparticle_break').':'.$message);
                 $this->dataSave($this->session->getSessionData($player->getName(), 'iparticle_break'), 'xyz', NULL);
                $player->sendMessage(IParticle::Prfix.'Успешно. Партикл ItemBreakParticle добавлен в список');
                $event->setCancelled();
                $this->session->createSession($player->getName(), 'scope', null);    
            }
           }
           public function particleInitialization() {
               foreach (glob($this->getDataFolder().'particle/*.json') as $filename) {
            
            $data = explode(':', str_replace('.json', '',$filename));
                $level = $this->getServer()->getDefaultLevel();  
                   $x = $data[1] + 0.5;
                   $y = $data[2] + 1.5;
                   $z = $data[3];
                   $id = $data[4];
                   $type = $data[5];
                   switch ($type) {
                       case 1:
                            $particle = new AngryVillagerParticle(new Vector3($x,$y,$z));
                           break;
                       case 2:
                           $particle = new BubbleParticle(new Vector3($x,$y,$z));
                           break;
                       case 3:
                            $particle = new CriticalParticle(new Vector3($x,$y,$z));
                           break;
                       case 4:
                           $particle = new DustParticle(new Vector3($x,$y,$z),52, 152, 219);
                           break;
                        case 5:
                           $particle = new EnchantmentTableParticle(new Vector3($x,$y,$z));
                           break;
                        case 6:
                           $particle = new FloatingTextParticle(new Vector3($x + 1,$y,$z), $data[6], $data[7]);
                           break;
                        case 7:
                           $particle = new EntityFlameParticle(new Vector3($x,$y -1,$z));
                           break;
                        case 8:
                           $particle = new ExplodeParticle(new Vector3($x,$y -1,$z));
                           break;
                         case 9:
                           $particle = new GenericParticle(new Vector3($x,$y,$z), $data[6]);
                           break;
                        case 10:
                            $particle = new HappyVillagerParticle(new Vector3($x,$y,$z));
                           break;
                       case 11:
                           $particle = new ItemBreakParticle(new Vector3($x,$y,$z), Item::get($data[6], 0, 1));
                           break;
                        case 12:
                            $particle = new WaterParticle(new Vector3($x,$y,$z));
                           break;
                   } 
                  for($i = 0; $i < 100; $i++){
		$level->addParticle($particle);
                }
                   
                    
               }
           }
//          
           public function dataSave($id, $tip, $data){
  $Sfile = (new Config($this->getDataFolder() . "particle/".strtolower($id).".json", Config::JSON))->getAll();
  $Sfile[$tip] = $data;
  $Ffile = new Config($this->getDataFolder() . "particle/".strtolower($id).".json", Config::JSON);
  $Ffile->setAll($Sfile);
  $Ffile->save();
}
	 public function dataGet($id, $tip){
   $Sfile = (new Config($this->getDataFolder() . "particle/".strtolower($id).".json", Config::JSON))->getAll();
   return $Sfile[$tip];
         }
   }
   class ParticleTimer extends PluginTask{
	
	public function __construct(IParticle $main){
            $this->main = $main;
		parent::__construct($main);
	}
	
	public function onRun($tick){
            $this->main->particleInitialization();
	}
	
}

