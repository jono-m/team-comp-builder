<?php
class DB {
    function connect() {
        $this->servername = "localhost";
        $this->username = "root";
        $this->password = "root";
        $this->port = 8889;
        $this->dbname = "team_comp_db";

        // Create connection
        $this->conn = new mysqli($this->servername, $this->username, 
                $this->password, $this->dbname, $this->port);

        // Check connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    function query($sql) {
        global $dbedit;
        if($dbedit || (substr($sql, 0, 6) == "SELECT")) {
            return $this->conn->query($sql);
        }
    }

    function disconnect() {
        $this->conn->close();
    }


    // player table operations.
    
    function add_player($player_name) {
        $player_name = $this->conn->real_escape_string($player_name);
        $sql = "INSERT INTO players (player_id, player_name) VALUES (NULL, '" . $player_name . "')";
        $this->query($sql);
        return $this->conn->insert_id;
    }

    function remove_player($player_id) {
        $player_id = $this->conn->real_escape_string($player_id);
        if ($this->get_player_name($player_id) == null) {
            return false;
        }
        $sql = "DELETE FROM players WHERE player_id = " . $player_id;
        $this->query($sql);
        return true;
    }

    function get_player_name($player_id) {
        $player_id = $this->conn->real_escape_string($player_id);
        $sql = "SELECT * FROM players WHERE player_id = " . $player_id . " ORDER BY player_name";
        $result = $this->query($sql);
        if ($result) {
            $row = $result->fetch_assoc();
            return $row["player_name"];
        } else {
            return null;
        }
    }

    function get_player_ids() {
        $sql = "SELECT player_id FROM players";
        $result = $this->query($sql);

        $player_ids = array();
        if($result) {
            while ($row = $result->fetch_assoc()) {
                $player_ids[] = $row["player_id"];
            }
        }
        return $player_ids;
    }

    function change_player_name($player_id, $new_name) {
        $player_id = $this->conn->real_escape_string($player_id);
        $new_name = $this->conn->real_escape_string($new_name);
        if($this->get_player_name($player_id) == null) {
            return false;
        }
        $sql = "UPDATE players SET player_name = '" . $new_name . "' WHERE player_id = " . $player_id;
        $this->query($sql);
        return true;
    }

    // champion table operations.
    
    function add_champ($champ_name) {
        $champ_name = $this->conn->real_escape_string($champ_name);
        $sql = "INSERT INTO champions (champ_id, champ_name) VALUES (NULL, '" . $champ_name . "')";
        $this->query($sql);

        $champ_id = $this->conn->insert_id;
        $comp_ids = $this->get_comp_type_ids();

        foreach($comp_ids as $comp_id) {
            $this->add_champions_comp_type($champ_id, $comp_id);
        }
        return $champ_id;
    }

    function remove_champ($champ_id) {
        $champ_id = $this->conn->real_escape_string($champ_id);
        if ($get_champ_name($champ_id) == null) {
            return false;
        }
        $sql = "DELETE FROM champions WHERE champ_id = " . $champ_id;
        $this->query($sql);        
        return true;
    }

    function get_champ_name($champ_id) {
        $champ_id = $this->conn->real_escape_string($champ_id);
        $sql = "SELECT * FROM champions WHERE champ_id = " . $champ_id;
        $result = $this->query($sql);
        if ($result) {
            $row = $result->fetch_assoc();
            return $row["champ_name"];
        } else {
            return null;
        }
    }

    function get_champ_ids() {
        $sql = "SELECT champ_id FROM champions ORDER BY champ_name";
        $result = $this->query($sql);

        $champ_ids = array();
        if($result) {
            while ($row = $result->fetch_assoc()) {
                $champ_ids[] = $row["champ_id"];
            }
        }
        return $champ_ids;
    }

    function change_champ_name($champ_id, $new_name) {
        $champ_id = $this->conn->real_escape_string($champ_id);
        $new_name = $this->conn->real_escape_string($new_name);
        if(get_champ_name($champ_id) == null) {
            return false;
        }
        $sql = "UPDATE champions SET champ_name = " . $new_name . " WHERE champ_id = " . $champ_id;
        $this->query($sql);
        return true;
    }
    
    // comp_types table operations.
    
    function add_comp_type($comp_type) {
        $comp_type = $this->conn->real_escape_string($comp_type);
        $sql = "INSERT INTO comp_types (comp_id, comp_type) VALUES (NULL, '" . $comp_type . "')";
        echo $sql;
        $this->query($sql);

        $comp_id = $this->conn->insert_id;
        $champ_ids = $this->get_champ_ids();

        foreach($champ_ids as $champ_id) {
            $this->add_champions_comp_type($champ_id, $comp_id);
        }

        return $comp_id;
    }

    function remove_comp_type($comp_id) {
        $comp_id = $this->conn->real_escape_string($comp_id);
        if ($get_comp_type_name($comp_type_id) == null) {
            return false;
        }
        $sql = "DELETE FROM comp_types WHERE comp_id = " . $comp_id;
        $this->query($sql);
        
        return true;
    }

    function get_comp_type($comp_id) {
        $comp_id = $this->conn->real_escape_string($comp_id);
        $sql = "SELECT * FROM comp_types WHERE comp_id = " . $comp_id;
        $result = $this->query($sql);
        if ($result) {
            $row = $result->fetch_assoc();
            return $row["comp_type"];
        } else {
            return null;
        }
    }

    function get_comp_type_ids() {
        $sql = "SELECT comp_id FROM comp_types ORDER BY comp_type";
        $result = $this->query($sql);

        $comp_ids = array();
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $comp_ids[] = $row["comp_id"];
            }
        }
        return $comp_ids;
    }

    function change_comp_type($comp_id, $new_type) {
        $comp_id = $this->conn->real_escape_string($comp_id);
        $new_type = $this->conn->real_escape_string($new_type);
        if(get_comp_type_name($comp_id) == null) {
            return false;
        }
        $sql = "UPDATE comp_types SET comp_type = " . $new_type . " WHERE comp_id = " . $comp_id;
        $this->query($sql);
        return true;
    }

    // player_champion table operations.

    function add_player_champion($player_id, $role, $champ_id) {
        $player_id = $this->conn->real_escape_string($player_id);
        $role = $this->conn->real_escape_string($role);
        $champ_id = $this->conn->real_escape_string($champ_id);
        $sql = "INSERT INTO players_champions (player_id, champ_id, role) VALUES ('" . $player_id . "', '" . $champ_id . "', '" . $role . "')";
        $this->query($sql);
    }

    function remove_player_champion($player_id, $role, $champ_id) {
        $player_id = $this->conn->real_escape_string($player_id);
        $role = $this->conn->real_escape_string($role);
        $champ_id = $this->conn->real_escape_string($champ_id);
        $sql = "DELETE FROM players_champions WHERE player_id = " . $player_id . " AND champ_id = " . $champ_id . " AND role = '" . $role . "'";
        $this->query($sql);
    }

    function get_player_champ_ids($player_id) {
        $player_id = $this->conn->real_escape_string($player_id);
        $sql = "SELECT * FROM players_champions WHERE player_id = " . $player_id;
        $result = $this->query($sql);

        $champion_ids = array(
            "Top Lane" => array(),
            "Jungle" => array(),
            "Mid Lane" => array(),
            "AD Carry" => array(),
            "Support" => array(),
        );

        if($result) {
            while ($row = $result->fetch_assoc()) {
                $champ_id = $row["champ_id"];
                $role = $row["role"];
                $champion_ids[$role][] = $champ_id;
            }
        }

        return $champion_ids;
    }

    function get_champion_player_ids($champ_id) {
        $champ_id = $this->conn->real_escape_string($champ_id);
        $sql = "SELECT * FROM players_champions WHERE champ_id = " . $champ_id;
        $result = $this->query($sql);

        $player_ids = array(
            "Top Lane" => array(),
            "Jungle" => array(),
            "Mid Lane" => array(),
            "AD Carry" => array(),
            "Support" => array(),
        );

        if($result) {
            while ($row = $result->fetch_assoc()) {
                $player_id = $row["player_id"];
                $role = $row["role"];
                $player_ids[$role][] = $player_id;
            }
        }

        return $player_ids;
    }

     // champions_comp_types table operations.

    function add_champions_comp_type($champ_id, $comp_id) {
        $champ_id = $this->conn->real_escape_string($champ_id);
        $comp_id = $this->conn->real_escape_string($comp_id);
        $sql = "INSERT INTO champions_comp_types (champ_id, comp_id, strength) VALUES ('" . $champ_id . "', '" . $comp_id . "', 3)";
        $this->query($sql);
    }

    function remove_champions_comp_type($champ_id, $comp_id) {
        $champ_id = $this->conn->real_escape_string($champ_id);
        $comp_id = $this->conn->real_escape_string($comp_id);
        $sql = "DELETE FROM champions_comp_types WHERE champ_id = " . $champ_id . " AND comp_id = " . $comp_id;
        $this->query($sql);
    }

    function update_champions_comp_type_strength($champ_id, $comp_id, $new_strength) {
        $champ_id = $this->conn->real_escape_string($champ_id);
        $comp_id = $this->conn->real_escape_string($comp_id);
        $new_strength = $this->conn->real_escape_string($new_strength);
        $sql = "UPDATE champions_comp_types SET strength = '" . $new_strength . "' WHERE champ_id = " . $champ_id . " AND comp_id = " . $comp_id;
        $this->query($sql);
    }

    function get_champions_comp_types($champ_id) {
        $champ_id = $this->conn->real_escape_string($champ_id);
        $sql = "SELECT * FROM champions_comp_types WHERE champ_id = " . $champ_id;
        $result = $this->query($sql);

        $champions_comp_types = array();

        if($result) {
            while ($row = $result->fetch_assoc()) {
                $comp_id = $row["comp_id"];
                $strength = $row["strength"];
                $champions_comp_types[$comp_id] = $strength;
            }
        }

        return $champions_comp_types;
    }

    // Session table methods
    function create_session($session_name) {
        $session_name = $this->conn->real_escape_string($session_name);
        $sql = "INSERT INTO cb_session (session_id, session_name) VALUES (NULL, '" . $session_name . "')";
        $this->query($sql);
        $session_id = $this->conn->insert_id;
        $sql = "INSERT INTO cb_session_teampicks (session_id, role, picked_champ_id, picked_player_id, starter_1_id, starter_2_id, starter_3_id, starter_4_id, starter_5_id, comp_type_1_id, comp_type_2_id, comp_type_3_id) VALUES (" . $session_id . ", 'Top Lane', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)";
        $this->query($sql);
        $sql = "INSERT INTO cb_session_teampicks (session_id, role, picked_champ_id, picked_player_id, starter_1_id, starter_2_id, starter_3_id, starter_4_id, starter_5_id, comp_type_1_id, comp_type_2_id, comp_type_3_id) VALUES (" . $session_id . ", 'Jungle', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)";
        $this->query($sql);
        $sql = "INSERT INTO cb_session_teampicks (session_id, role, picked_champ_id, picked_player_id, starter_1_id, starter_2_id, starter_3_id, starter_4_id, starter_5_id, comp_type_1_id, comp_type_2_id, comp_type_3_id) VALUES (" . $session_id . ", 'Mid Lane', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)";
        $this->query($sql);
        $sql = "INSERT INTO cb_session_teampicks (session_id, role, picked_champ_id, picked_player_id, starter_1_id, starter_2_id, starter_3_id, starter_4_id, starter_5_id, comp_type_1_id, comp_type_2_id, comp_type_3_id) VALUES (" . $session_id . ", 'AD Carry', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)";
        $this->query($sql);
        $sql = "INSERT INTO cb_session_teampicks (session_id, role, picked_champ_id, picked_player_id, starter_1_id, starter_2_id, starter_3_id, starter_4_id, starter_5_id, comp_type_1_id, comp_type_2_id, comp_type_3_id) VALUES (" . $session_id . ", 'Support', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)";
        $this->query($sql);

        $sql = "INSERT INTO cb_session_enemypicks (session_id, picked_champ_1_id, picked_champ_2_id, picked_champ_3_id, picked_champ_4_id, picked_champ_5_id) VALUES (" . $session_id . ", NULL, NULL, NULL, NULL, NULL)";
        $this->query($sql);

        $sql = "INSERT INTO cb_session_bans (session_id, teamban, ban_1_id, ban_2_id, ban_3_id) VALUES (" . $session_id . ", '0', NULL, NULL, NULL)";
        $this->query($sql);

        $sql = "INSERT INTO cb_session_bans (session_id, teamban, ban_1_id, ban_2_id, ban_3_id) VALUES (" . $session_id . ", '1', NULL, NULL, NULL)";
        $this->query($sql);
        return $session_id;
    }

    function end_session($session_id) {
        $session_id = $this->conn->real_escape_string($session_id);
        $sql = "DELETE FROM cb_session WHERE session_id = " . $session_id;
        $this->query($sql);
    }

    function get_session_name($session_id) {
        $session_id = $this->conn->real_escape_string($session_id);
        $sql = "SELECT * FROM cb_session WHERE session_id = " . $session_id ;
        $result = $this->query($sql);
        if ($result) {
            $row = $result->fetch_assoc();
            return $row["session_name"];
        } else {
            return null;
        }
    }

    function get_session_ids() {
        $sql = "SELECT session_id FROM cb_session";
        $result = $this->query($sql);

        $session_ids = array();
        if($result) {
            while ($row = $result->fetch_assoc()) {
                $session_ids[] = $row["session_id"];
            }
        }
        return $session_ids;
    }

    function set_session_name($session_id, $session_name) {
        $session_id = $this->conn->real_escape_string($session_id);
        $session_name = $this->conn->real_escape_string($session_name);
        $sql = "UPDATE cb_session SET session_name = '" . $session_name . "' WHERE session_id = " . $session_id;
        $this->query($sql);
    }

    function get_session_comp_type_ids($session_id) {
        $session_id = $this->conn->real_escape_string($session_id);
        $sql = "SELECT role, comp_type_1_id, comp_type_2_id, comp_type_3_id FROM cb_session_teampicks WHERE session_id=" . $session_id;
        $result = $this->query($sql);

        $comp_type_ids = array(
            "Top Lane" => null,
            "Jungle" => null,
            "Mid Lane" => null,
            "AD Carry" => null,
            "Support" => null,
        );

        if($result) {
            while ($row = $result->fetch_assoc()) {
                $comp_type_1_id = $row["comp_type_1_id"];
                $comp_type_2_id = $row["comp_type_2_id"];
                $comp_type_3_id = $row["comp_type_3_id"];
                $role = $row["role"];
                $comp_type_ids[$role] = array($comp_type_1_id, $comp_type_2_id, $comp_type_3_id);
            }
        }

        return $comp_type_ids;
    }

    function set_session_comp_type_id($session_id, $role, $comp_id, $comp_type_number) {
        $session_id = $this->conn->real_escape_string($session_id);
        $role = $this->conn->real_escape_string($role);
        $comp_id = $this->conn->real_escape_string($comp_id);
        $comp_type_number = $this->conn->real_escape_string($comp_type_number);
        $sql = "UPDATE cb_session_teampicks SET comp_type_" . $comp_type_number . "_id = " . $comp_id . " WHERE session_id = " . $session_id . " AND role = '" . $role . "'";
        $this->query($sql);
    }

    function get_session_picked_champion_ids($session_id) {
        $session_id = $this->conn->real_escape_string($session_id);
        $sql = "SELECT role, picked_champ_id FROM cb_session_teampicks WHERE session_id=" . $session_id;
        $result = $this->query($sql);

        $champion_ids = array(
            "Top Lane" => null,
            "Jungle" => null,
            "Mid Lane" => null,
            "AD Carry" => null,
            "Support" => null,
        );

        if($result) {
            while ($row = $result->fetch_assoc()) {
                $picked_champ_id = $row["picked_champ_id"];
                $role = $row["role"];
                $champion_ids[$role] = $picked_champ_id;
            }
        }

        return $champion_ids;
    }

    function set_session_picked_champion_id($session_id, $role, $champ_id) {
        $session_id = $this->conn->real_escape_string($session_id);
        $role = $this->conn->real_escape_string($role);
        $champ_id = $this->conn->real_escape_string($champ_id);
        $sql = "UPDATE cb_session_teampicks SET picked_champ_id = " . $champ_id . " WHERE session_id = " . $session_id . " AND role = '" . $role . "'";
        $this->query($sql);
    }

    function get_session_picked_player_ids($session_id) {
        $session_id = $this->conn->real_escape_string($session_id);
        $sql = "SELECT role, picked_player_id FROM cb_session_teampicks WHERE session_id=" . $session_id;
        $result = $this->query($sql);

        $player_ids = array(
            "Top Lane" => null,
            "Jungle" => null,
            "Mid Lane" => null,
            "AD Carry" => null,
            "Support" => null,
        );

        if($result) {
            while ($row = $result->fetch_assoc()) {
                $picked_player_id = $row["picked_player_id"];
                $role = $row["role"];
                $player_ids[$role] = $picked_player_id;
            }
        }

        return $player_ids;
    }

    function set_session_picked_player_id($session_id, $role, $player_id) {
        $session_id = $this->conn->real_escape_string($session_id);
        $role = $this->conn->real_escape_string($role);
        $player_id = $this->conn->real_escape_string($player_id);
        $sql = "UPDATE cb_session_teampicks SET picked_player_id = " . $player_id . " WHERE session_id = " . $session_id . " AND role = '" . $role . "'";
        $this->query($sql);
    }

    function get_session_starter_ids($session_id) {
        $session_id = $this->conn->real_escape_string($session_id);
        $sql = "SELECT role, starter_1_id, starter_2_id, starter_3_id, starter_4_id, starter_5_id FROM cb_session_teampicks WHERE session_id=" . $session_id;
        $result = $this->query($sql);

        $player_ids = array(
            "Top Lane" => null,
            "Jungle" => null,
            "Mid Lane" => null,
            "AD Carry" => null,
            "Support" => null,
        );

        if($result) {
            while ($row = $result->fetch_assoc()) {
                $starter_1_id = $row["starter_1_id"];
                $starter_2_id = $row["starter_2_id"];
                $starter_3_id = $row["starter_3_id"];
                $starter_4_id = $row["starter_4_id"];
                $starter_5_id = $row["starter_5_id"];
                $role = $row["role"];
                $player_ids[$role] = array($starter_1_id, $starter_2_id, $starter_3_id, $starter_4_id, $starter_5_id);
            }
        }

        return $player_ids;
    }

    function set_session_starter_id($session_id, $role, $starter_id, $starter_number) {
        $session_id = $this->conn->real_escape_string($session_id);
        $role = $this->conn->real_escape_string($role);
        $starter_id = $this->conn->real_escape_string($starter_id);
        $starter_number = $this->conn->real_escape_string($starter_number);
        $sql = "UPDATE cb_session_teampicks SET starter_" . $starter_number . "_id = " . $starter_id . " WHERE session_id = " . $session_id . " AND role = '" . $role . "'";
        $this->query($sql);
    }

    function get_session_enemy_champion_ids($session_id) {
        $session_id = $this->conn->real_escape_string($session_id);
        $sql = "SELECT * FROM cb_session_enemypicks WHERE session_id=" . $session_id;
        $result = $this->query($sql);

        $champ_ids = null;

        if($result) {
            while ($row = $result->fetch_assoc()) {
                $picked_champ_1_id = $row["picked_champ_1_id"];
                $picked_champ_2_id = $row["picked_champ_2_id"];
                $picked_champ_3_id = $row["picked_champ_3_id"];
                $picked_champ_4_id = $row["picked_champ_4_id"];
                $picked_champ_5_id = $row["picked_champ_5_id"];
                $champ_ids = array($picked_champ_1_id, $picked_champ_2_id, $picked_champ_3_id, $picked_champ_4_id, $picked_champ_5_id);
            }
        }

        return $champ_ids;
    }

    function set_session_enemy_champion_id($session_id, $enemy_champion_id, $champion_number) {
        $session_id = $this->conn->real_escape_string($session_id);
        $enemy_champion_id = $this->conn->real_escape_string($enemy_champion_id);
        $champion_number = $this->conn->real_escape_string($champion_number);
        $sql = "UPDATE cb_session_enemypicks SET picked_champ_" . $champion_number . "_id = " . $enemy_champion_id . " WHERE session_id = " . $session_id;
        $this->query($sql);
    } 

    function get_session_ban_ids($session_id) {
        $session_id = $this->conn->real_escape_string($session_id);
        $sql = "SELECT * FROM cb_session_bans WHERE session_id=" . $session_id;
        $result = $this->query($sql);

        $champ_ids = array (null, null);

        if($result) {
            while ($row = $result->fetch_assoc()) {
                $ban_1_id = $row["ban_1_id"];
                $ban_2_id = $row["ban_2_id"];
                $ban_3_id = $row["ban_3_id"];
                $teamban = $row["teamban"];
                $champ_ids[intval($teamban)] = array($ban_1_id, $ban_2_id, $ban_3_id);
            }
        }

        return $champ_ids;
    }

    // ban_id is a champ_id. teamban is true if own ban. false if enemy ban.
    function set_session_ban_id($session_id, $ban_champ_id, $teamban, $ban_number) {
        $session_id = $this->conn->real_escape_string($session_id);
        $ban_champ_id = $this->conn->real_escape_string($ban_champ_id);
        $teamban = $this->conn->real_escape_string($teamban);
        $ban_number = $this->conn->real_escape_string($ban_number);
        $sql = "UPDATE cb_session_bans SET ban_" . $ban_number . "_id = " . $ban_champ_id . " WHERE session_id = " . $session_id . " AND teamban = " . $teamban;
        $this->query($sql);
    }
}