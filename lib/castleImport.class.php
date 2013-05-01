<?php
class castleImport
{
	private $armoryUrl = 'http://armory.wow-castle.de/';
	
	//############## ARENA/PvP #######################
	public function getArenaTeams($teamSize = 2, $limit = 20)
	{
		$out = array();
		
		$xml = $this->getXML($this->armoryUrl.'arena-ladder.xml?ts='.$teamSize.'&b=WoW-Castle&sf=rating&sd=d');
		
		$maxPage = (int) $xml->arenaLadderPagedResult['maxPage'];
		for($i=0; $i<$maxPage; $i++)
		{
			if($i != 0) //skip nr 0
				$content =  $this->getXML($this->armoryUrl.'arena-ladder.xml?p='.($i+1).'&ts='.$teamSize.'&b=WoW-Castle&sf=rating&sd=d');
			
			//work with the data
			for($j=0; $j<20; $j++)
			{
				if(($i*20+$j)>$limit-1)
					break;
				if(!isset($xml->arenaLadderPagedResult->arenaTeams->arenaTeam[$j]['name']))
					continue;
				$out[($i*20+$j)]['name'] = (string) $xml->arenaLadderPagedResult->arenaTeams->arenaTeam[$j]['name'];
				$out[($i*20+$j)]['rating'] = (int) $xml->arenaLadderPagedResult->arenaTeams->arenaTeam[$j]['rating'];
				$out[($i*20+$j)]['gamesPlayed'] = (int) $xml->arenaLadderPagedResult->arenaTeams->arenaTeam[$j]['gamesPlayed'];
				$out[($i*20+$j)]['gamesWon'] = (int) $xml->arenaLadderPagedResult->arenaTeams->arenaTeam[$j]['gamesWon'];
				$out[($i*20+$j)]['factionId'] = (int) $xml->arenaLadderPagedResult->arenaTeams->arenaTeam[$j]['factionId'];
			}
		}
		return $out;
	}
	
	public function getArenaTeam($name)
	{
		$out = array();
		$name = str_replace(" ", "+", $name); 
		$xml = $this->getXML($this->armoryUrl.'team-info.xml?b=WoW-Castle&r=WoW-Castle+PvE&select='.$name);
		foreach($xml->teamInfo->arenaTeam->members->character as $row)
		{
			$out[] = array(
				'name' => (string) $row['name'],
				'classId' => (int) $row['classId'],
				'games' => (int) $row['seasonGamesPlayed'],
				'wins' => (int) $row['seasonGamesWon']
			);
		}
		return $out;
	}
	
	private function getXML($url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; de; rv:1.8.1.12) Gecko/20080201 Firefox/2.0.0.12");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept-Language: de-de, de;"));
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10 );
		$content = curl_exec ($ch);
		curl_close ($ch);
		try{
			$xml = new SimpleXMLElement($content);
		} 
		catch (Exception $e) {
			die("Castle down ?");		
		} 
		return $xml;
	}
}