<?php
class castleImport
{
	private $armoryUrl = 'http://armory.wow-castle.de/';
	
	//############## ARENA/PvP #######################
	public function getArenaTeams($teamSize = 2, $limit = 20)
	{
		$out = array();
		$xml = $this->getXML($this->armoryUrl.'arena-ladder.xml?ts='.$teamSize.'&b=WoW-Castle&sf=rating&sd=d');
		if($xml === false)
			return false;
		$maxPage = (int) $xml->arenaLadderPagedResult['maxPage'];
		for($i=0; $i<$maxPage; $i++)
		{
			if($i != 0) //0 is already loaded
				$xml =  $this->getXML($this->armoryUrl.'arena-ladder.xml?p='.($i+1).'&ts='.$teamSize.'&b=WoW-Castle&sf=rating&sd=d');
			
			//work with the data
			foreach($xml->arenaLadderPagedResult->arenaTeams->arenaTeam as $row)
			{
				if(count($out) > ($limit-1))
					break;
				$out[] = array(
					'name' => (string) $row['name'],
					'rating' => (int) $row['rating'],
					'gamesPlayed' => (int) $row['gamesPlayed'],
					'gamesWon' => (int) $row['gamesWon'],
					'seasonGamesWon' => (int) $row['seasonGamesWon'],
					'seasonGamesPlayed' => (int) $row['seasonGamesPlayed'],
					'factionId' => (int) $row['factionId']
				);
			}
		}
		return $out;
	}
	
	public function getArenaTeam($name)
	{
		$out = array();
		$name = str_replace(" ", "+", $name); 
		$xml = $this->getXML($this->armoryUrl.'team-info.xml?b=WoW-Castle&r=WoW-Castle+PvE&select='.$name);
		if($xml === false)
			return false;
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
		curl_setopt($ch, CURLOPT_TIMEOUT_MS, 1500);     
		$content = curl_exec ($ch);
		curl_close ($ch);
		try{
			$xml = new SimpleXMLElement($content);
		} 
		catch (Exception $e) {
			return false;
		} 
		return $xml;
	}
}
