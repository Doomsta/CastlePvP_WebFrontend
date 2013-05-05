#!/usr/bin/python3.1
import xml.etree.ElementTree as ET
import urllib.request
import time
import pymysql
import hashlib
from termcolor import colored

# define stuff

maps = { 489 : "Kriegshymnenschlucht",
         529 : "Arathibecken",
         566 : "Auge des Sturms",
         30  : "Alteractal",
         607 : "Stand der Uralten",
         628 : "Insel der Eroberung" }

races = { 'alliance' : [1, 3, 4, 7, 11],
          'horde'    : [2, 5, 6, 8, 10] }

faction_color = { 0 : 'green', 1: 'red' }

player_count_cache = 0 # we assume there are no matching players on startup

sleep_until = 0

def update():
    global player_count_cache, sleep_until

    # receive and parse xml feed
    try:
        xml_uri = "http://www.wow-castle.de/bboard/skripte/xml_chars.php"
        resp = urllib.request.urlopen(xml_uri)
        xml = resp.read()
    except socket.gaierror:
        print("Caught exception: socket.gaierror, retrying in 10s...")
        sleep_until = time.time() + 10;
        return

    # parse tree and 
    servers = ET.fromstring(xml)
    cache = int(servers.attrib.get('timestamp').replace("sec", "")) # yeah, because appending "sec" to an integer in xml makes total sense...
    sleep_until = time.time() + cache + 1
    
    # evaluate data and count stuff.
    players = {}
    player80_count = { 0 : 0, 1 : 0 }
    player_count   = { 0 : 0, 1 : 0 }
    class_count = { 0 : { 1 : 0, 2 : 0, 3 : 0, 4 : 0, 5 : 0, 6 : 0, 7 : 0, 8 : 0, 9 : 0, 10 : 0, 11 : 0 }, # alliance in bg
                    1 : { 1 : 0, 2 : 0, 3 : 0, 4 : 0, 5 : 0, 6 : 0, 7 : 0, 8 : 0, 9 : 0, 10 : 0, 11 : 0 }, # horde in bg
                    2 : { 1 : 0, 2 : 0, 3 : 0, 4 : 0, 5 : 0, 6 : 0, 7 : 0, 8 : 0, 9 : 0, 10 : 0, 11 : 0 }} # overall

    for server in servers:
        for realm in server:
            for chars in realm:
                # loop over all chars
                level = int(chars.attrib.get('level'))
                map_id = int(chars.attrib.get('map'))
                name = chars.attrib.get('name')
                guild = chars.attrib.get('guild')

                # race / faction
                race = int(chars.attrib.get('race'))
                faction = 0 if race in races['alliance'] else 1
                player_count[faction] += 1 
                if (level == 80):
                    player80_count[faction] += 1
                # skip everything else for chars below maxlvl
                else:
                    continue

                # character class
                classid = int(chars.attrib.get('class'))
                class_count[2][classid] += 1

                # applies to player on pvp maps only
                if (map_id in maps):
                    if (map_id not in players):
                        players[map_id] = { 0 : [], 1 : []}
                    players[map_id][faction].append({"name" : name, "guild" : guild, "race" : race, "class" : classid})
                    # count classes in battleground
                    class_count[faction][classid] += 1

    # pretty player output
    print("%d|players %d/%d(=%d), 80: %d/%d(=%d)" % (time.time(), player_count[0], player_count[1], player_count[0]+player_count[1], player80_count[0], player80_count[1], player80_count[0] + player80_count[1]))
    print_player_listings(players)

    # write to database
    timestamp = time.time() # set unique timestamp for this update
    conn = pymysql.connect(host='127.0.0.1', unix_socket='/var/run/mysqld/mysqld.sock', user='CHANGEME', passwd='CHANGEME', db='CHANGEME') # mysql connection
    cursor = conn.cursor()
    # global
    query = "INSERT INTO global (timestamp, players_a, players_h, players80_a, players80_h) VALUES (%d, %d, %d, %d, %d);" % (timestamp, player_count[0], player_count[1], player80_count[0], player80_count[1])
    try:
        cursor.execute(query)
    except pymysql.err.IntegrityError as err: # duplicate timestamp
        print("IntegrityError: {0}".format(err))
    conn.commit()
    #print(query)
    # by_battleground
    for battleground in players:
        query = "INSERT INTO by_battleground (timestamp, bg, players_a, players_h) VALUES (%d, %d, %d, %d);" % (timestamp, battleground, len(players[battleground][0]), len(players[battleground][1]))
        #print(query)
        try:
            cursor.execute(query)
        except pymysql.err.IntegrityError as err: # duplicate timestamp
            print("IntegrityError: {0}".format(err))
        conn.commit()
        # by_character
        for faction in players[battleground]:
            for player in players[battleground][faction]:
                query = "INSERT INTO by_character (timestamp, name, guild, faction, race, class, bg) VALUES (%d, '%s', '%s', %d, %d, %d, %d);" % (timestamp, player["name"], player["guild"], faction, player["race"], player["class"], battleground)
                try:
                    cursor.execute(query)
                except pymysql.err.IntegrityError as err: # duplicate timestamp
                    print("IntegrityError: {0}".format(err))
                conn.commit()
    # by_class
    query = "INSERT INTO by_class (timestamp, cnt_warrior_bg_a, cnt_warrior_bg_h, cnt_warrior_total, cnt_shaman_bg_a, cnt_shaman_bg_h, cnt_shaman_total, cnt_hunter_bg_a, cnt_hunter_bg_h, cnt_hunter_total, cnt_warlock_bg_a, cnt_warlock_bg_h, cnt_warlock_total, cnt_priest_bg_a, cnt_priest_bg_h, cnt_priest_total, cnt_mage_bg_a, cnt_mage_bg_h, cnt_mage_total, cnt_paladin_bg_a, cnt_paladin_bg_h, cnt_paladin_total, cnt_rogue_bg_a, cnt_rogue_bg_h, cnt_rogue_total, cnt_druid_bg_a, cnt_druid_bg_h, cnt_druid_total, cnt_deathknight_bg_a, cnt_deathknight_bg_h, cnt_deathknight_total) VALUES (%d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d);" % (timestamp, class_count[0][1], class_count[1][1], class_count[2][1], class_count[0][7], class_count[1][7], class_count[2][7], class_count[0][3], class_count[1][3], class_count[2][3], class_count[0][9], class_count[1][9], class_count[2][9], class_count[0][5], class_count[1][5], class_count[2][5], class_count[0][8], class_count[1][8], class_count[2][8], class_count[0][2], class_count[1][2], class_count[2][2], class_count[0][4], class_count[1][4], class_count[2][4], class_count[0][11], class_count[1][11], class_count[2][11], class_count[0][6], class_count[1][6], class_count[2][6])
    try:
        cursor.execute(query)
    except pymysql.err.IntegrityError as err: # duplicate timestamp
        print("IntegrityError: {0}".format(err))
    #print(query)
    conn.commit()

    # cleanup        
    cursor.close()
    conn.close()

    player_count_cache = player_count

    return cache

def print_player_listings(players):
    for map in players:
        print("%d|%s:" % (map, maps[map]))
        for iter in range(0,2):
            for player in players[map][iter]: # alliance
                print("%s, " % colored(player["name"], faction_color[iter]), end="")
            print("\n", end="") # explicit newline

while 1:
    update()
    print("sleeping until %d (%ds)..." % (sleep_until, sleep_until - time.time()))
    while (time.time() <= sleep_until): # time.sleep(sleep_until - time.time()) was not precise enough
        time.sleep(1)

