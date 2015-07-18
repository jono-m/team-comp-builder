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
        $sql = "INSERT INTO players (player_id, player_name) VALUES (NULL, '" . $player_name . "')";
        $this->query($sql);
        return $this->conn->insert_id;
    }

    function remove_player($player_id) {
        if ($this->get_player_name($player_id) == null) {
            return false;
        }
        $sql = "DELETE FROM players WHERE player_id = " . $player_id;
        $this->query($sql);
        return true;
    }

    function get_player_name($player_id) {
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
        if($this->get_player_name($player_id) == null) {
            return false;
        }
        $sql = "UPDATE players SET player_name = '" . $new_name . "' WHERE player_id = " . $player_id;
        $this->query($sql);
        return true;
    }

    // champion table operations.
    
    function add_champ($champ_name) {
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
        if ($get_champ_name($champ_id) == null) {
            return false;
        }
        $sql = "DELETE FROM champions WHERE champ_id = " . $champ_id;
        $this->query($sql);        
        return true;
    }

    function get_champ_name($champ_id) {
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
        if(get_champ_name($champ_id) == null) {
            return false;
        }
        $sql = "UPDATE champions SET champ_name = " . $new_name . " WHERE champ_id = " . $champ_id;
        $this->query($sql);
        return true;
    }
    
    // comp_types table operations.
    
    function add_comp_type($comp_type) {
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
        if ($get_comp_type_name($comp_type_id) == null) {
            return false;
        }
        $sql = "DELETE FROM comp_types WHERE comp_id = " . $comp_id;
        $this->query($sql);
        
        return true;
    }

    function get_comp_type($comp_id) {
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
        if(get_comp_type_name($comp_id) == null) {
            return false;
        }
        $sql = "UPDATE comp_types SET comp_type = " . $new_type . " WHERE comp_id = " . $comp_id;
        $this->query($sql);
        return true;
    }

    // player_champion table operations.

    function add_player_champion($player_id, $role, $champ_id) {
        $sql = "INSERT INTO players_champions (player_id, champ_id, role) VALUES ('" . $player_id . "', '" . $champ_id . "', '" . $role . "')";
        $this->query($sql);
    }

    function remove_player_champion($player_id, $role, $champ_id) {
        $sql = "DELETE FROM players_champions WHERE player_id = " . $player_id . " AND champ_id = " . $champ_id . " AND role = '" . $role . "'";
        $this->query($sql);
    }

    function get_player_champ_ids($player_id) {
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
        $sql = "INSERT INTO champions_comp_types (champ_id, comp_id, strength) VALUES ('" . $champ_id . "', '" . $comp_id . "', 'D')";
        $this->query($sql);
    }

    function remove_champions_comp_type($champ_id, $comp_id) {
        $sql = "DELETE FROM champions_comp_types WHERE champ_id = " . $champ_id . " AND comp_id = " . $comp_id;
        $this->query($sql);
    }

    function update_champions_comp_type_strength($champ_id, $comp_id, $new_strength) {
        $sql = "UPDATE champions_comp_types SET strength = '" . $new_strength . "' WHERE champ_id = " . $champ_id . " AND comp_id = " . $comp_id;
        $this->query($sql);
    }

    function get_champions_comp_types($champ_id) {
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
}