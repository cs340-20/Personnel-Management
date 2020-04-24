<?php

function check_session()
{
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}

	if (!array_key_exists("loggedin", $_SESSION)) $_SESSION['loggedin'] = false;
	
	if (session_status() === PHP_SESSION_ACTIVE) {	
		if ($_SESSION["loggedin"] == true) return true;
	} else {
		$_SESSION["loggedin"] = false;
	}

	return false;
}

function create_connection()
{
	$link = mysqli_connect("localhost", "root", "", "Personnel");

	if ($link == false) {
		die("ERROR: Could not connect. " . mysqli_connect_error());
		return NULL;
	} else {
		return $link;
	}
}

function add_user($link, $new_user)
{
	$date = date("Y-m-d");

	if ($result = mysqli_query($link, "SELECT people.user_ID FROM people")) {
		$last = -1;
		while ($row = mysqli_fetch_array($result)) {
			if ($row[0] != ($last + 1)) {
				$num = $last + 1;
				break;
			} else {
				$last = $row[0];
			}
		}
		$num = $last + 1;
	}

	if ($result = mysqli_query($link, "SELECT groups.ID FROM groups WHERE groups.group_name='" . $new_user[4] . "'")) {
		$row = mysqli_fetch_array($result);
		$org_id = $row[0];
	}

	if (!mysqli_query($link, 'INSERT INTO personnel.people (user_ID, First_Name, Last_name, Email, Activation_Date, Pay_Grade, Organization, permissions) 
								VALUES (' . $num . ', "' . $new_user[0] . '", "' . $new_user[1] . '", "' . $new_user[2] . '", "' . $date . '", "' . $new_user[3] . '", "' . $org_id . '", "' . $new_user[5] . '")')) {
		echo "insert failed";
	} else {
		add_att_user($link, $num);
	}
}

function remove_user($link, $remove_ID)
{
	$remove_query = "DELETE FROM people WHERE people.user_ID = " . $remove_ID;

	if (mysqli_query($link, $remove_query)) {
		remove_att_user($link, $remove_ID);
	} else {
		echo "Failed to remove user " . $remove_ID;
	}
}

function get_user_name($link, $user_ID)
{
	$full_name = "";

	$query = "SELECT Last_Name, First_Name FROM People WHERE People.user_ID = " . $user_ID;

	if ($result = mysqli_query($link, $query)) {

		$row = mysqli_fetch_array($result);

		$full_name = $row['Last_Name'] . ", " . $row['First_Name'];
	} else {
		echo $user_ID . " ERROR: Could not execute sql query."
			. mysqli_error($link);
	}

	return $full_name;
}

function get_email($link, $UID) {
	$query = "SELECT email FROM People WHERE People.user_ID = " . $UID;

	if ($result = mysqli_query($link, $query)) {

		$row = mysqli_fetch_array($result);

	} else {
		echo $user_ID . " ERROR: Could not execute sql query."
			. mysqli_error($link);
	}

	return $row['email'];
}

function build_col_name($link, $user_ID)
{
	$full_name = "";

	$query = "SELECT Last_Name, First_Name FROM People WHERE People.user_ID = " . $user_ID;

	if ($result = mysqli_query($link, $query)) {

		$row = mysqli_fetch_array($result);

		$full_name = $row['Last_Name'] . "" . $row['First_Name'];
	} else {
		echo $user_ID . " ERROR: Could not execute sql query."
			. mysqli_error($link);
	}

	return $full_name;
}

function get_event_name($link, $event_ID)
{
	$query = "SELECT name FROM events WHERE events.event_ID = " . $event_ID;

	if ($result = mysqli_query($link, $query)) {

		$row = mysqli_fetch_array($result);
	} else {
		echo "ERROR: Could not execute sql query."
			. mysqli_error($link);
	}

	return $row;
}

function get_groupnames($link)
{
	if ($result = mysqli_query($link, "SELECT group_name FROM groups")) {
		while ($row = mysqli_fetch_array($result)) {
			$names[] = $row[0];
		}
	} else {
		echo "ERROR: Could not get group names.";
	}
	return $names;
}

function is_supervisor($link, $UID, $sup_UID) {
	$row = get_user_info($link, $UID);
	return ($row['supervisor_ID'] == $sup_UID);
}

function get_columns($link)
{
	$result = $link->query("SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` 
                                    WHERE `TABLE_SCHEMA`='personnel' AND `TABLE_NAME`='people' 
									AND COLUMN_NAME NOT LIKE 'Extra%'");

	return $result;
}

function get_user_info($link, $UID)
{
	$res = mysqli_query($link, "SELECT * FROM people JOIN groups ON people.Organization = groups.ID WHERE user_ID = " . $UID);
	$row = mysqli_fetch_array($res);

	$row["supervisor_name"] = get_user_name($link, $row["supervisor_ID"]);

	$get_gps = mysqli_query($link, "SELECT ID, group_name FROM groups");
	while ($gp_row = mysqli_fetch_array($get_gps)) {
		$gp_names[$gp_row["ID"]] = $gp_row["group_name"];
	}

	$extras = "";

	if ($row['Extra_1'] != 0) {
		$extras	= $extras . $gp_names[$row["Extra_1"]];
	}
	if ($row['Extra_2'] != 0) {
		if ($extras != "") $extras = $extras . ", ";
		$extras	= $extras . $gp_names[$row["Extra_2"]];
	}
	if ($row['Extra_3'] != 0) {
		if ($extras != "") $extras = $extras . ", ";
		$extras	= $extras . $gp_names[$row["Extra_3"]];
	}
	if ($row['Extra_4'] != 0) {
		if ($extras != "") $extras = $extras . ", ";
		$extras	= $extras . $gp_names[$row["Extra_4"]];
	}
	if ($row['Extra_5'] != 0) {
		if ($extras != "") $extras = $extras . ", ";
		$extras	= $extras . $gp_names[$row["Extra_5"]];
	}

	if ($extras == "") $row["extras"] = "None";
	else $row["extras"] = $extras;

	return $row;
}

function get_event_list($link)
{
	$res = mysqli_query($link, "SELECT event_ID FROM events ORDER BY events.date");
	$events = [];
	while ($row = mysqli_fetch_array($res)) {
		$events[] = $row['event_ID'];
	}
	return $events;
}

function get_UID_list($link)
{
	$res = mysqli_query($link, "SELECT user_ID FROM people ORDER BY Last_Name");
	$ret = [];
	while ($arr = mysqli_fetch_array($res)) $ret[] = $arr['user_ID'];
	return $ret;
}

function get_event_info($link, $event_ID)
{
	$res = mysqli_query($link, "SELECT * FROM events WHERE event_ID = " . $event_ID);
	$row = mysqli_fetch_array($res);

	return $row;
}

function get_event_att($link, $EID)
{
	$res = mysqli_query($link, "SELECT * FROM attendance WHERE event_ID = " . $EID);
	$row = mysqli_fetch_array($res);

	$ret = [];

	foreach ($row as $key => $value) {
		if (is_null($value)) {
			$ret[$key] = "U";
		} else {
			$ret[$key] = $value;
		}
	}

	return $ret;
}

function set_event_att($link, $ev, $att_set)
{
	foreach ($att_set as $key => $att) {
		mysqli_query($link,  "UPDATE attendance SET `" . build_col_name($link, $key) . "`=\"" . $att . "\" WHERE event_ID=" . $ev);
	}
}

//adds event to events table
function add_event($link, $event_name, $event_date)
{
	if ($result = mysqli_query($link, "SELECT event_ID FROM events")) {
		$last = -1;
		while ($row = mysqli_fetch_array($result)) {
			if ($row[0] != ($last + 1)) {
				$num = $last + 1;
				break;
			} else {
				$last = $row[0];
			}
		}
		$num = $last + 1;
	}

	$e_date = '';
	$e_name = '';

	$sql_add_event = $link->prepare("INSERT INTO events (events.event_ID, events.name, events.date, events.attendance) VALUES (?, ?,?, '0')");
	$sql_add_event->bind_param("iss", $num, $e_name, $e_date);

	$e_date = $event_date;
	$e_name = $event_name;

	$sql_add_event->execute();
	$sql_add_event->close();

	add_att_event($link, $num);
}

//removes event from events table
function remove_event($link, $event_ID)
{
	$remove_query = "DELETE FROM events WHERE events.event_ID = " . $event_ID;

	if (mysqli_query($link, $remove_query)) {
	} else {
		echo "Failed to remove user " . $event_ID;
	}

	remove_att_event($link, $event_ID);
}

function add_att_event($link, $EID)
{
	mysqli_query($link, "INSERT INTO personnel.attendance (event_ID) VALUE (" . $EID . ")");
}

function remove_att_event($link, $EID)
{
	mysqli_query($link, "DELETE FROM attendance WHERE attendance.event_ID = " . $EID);
}

function add_att_user($link, $UID)
{
	if (!mysqli_query($link, "ALTER TABLE personnel.attendance ADD " . $UID . " varchar(1);")) {
		echo "failed";
	}
}

function remove_att_user($link, $UID)
{
	mysqli_query($link, "ALTER TABLE personnel.attendance DROP COLUMN " . $UID);
}

//lots of comparisons and function calls... 
//should only be used if there are major inconsistencies between people, events, and attendance tables
function update_att_events($link)
{
	$ID_list = [];
	$att_list = [];
	$sql_get_events = mysqli_query($link, "SELECT event_ID FROM events");
	while ($ID = mysqli_fetch_array($sql_get_events)) $ID_list[] = $ID["event_ID"];


	$sql_get_att = mysqli_query($link, "SELECT event_ID FROM attendance");
	while ($ID = mysqli_fetch_array($sql_get_att)) $att_list[] = $ID["event_ID"];

	//check that all events have attendance instance
	if (is_array($ID_list)) {
		foreach ($ID_list as $cur_ID) {
			if (is_array($att_list)) {
				if (!in_array($cur_ID, $att_list)) {
					add_att_event($link, $cur_ID);
				}
			} else {
				add_att_event($link, $cur_ID);
			}
		}
	}

	//check that all attendance instances have an event
	if (is_array($att_list)) {
		foreach ($att_list as $att_inst) {
			if (is_array($ID_list)) {
				if (!in_array($att_inst, $ID_list)) {
					remove_att_event($link, $att_inst);
				}
			}
		}
	}

	//check that each person has a column
	$UID_list = [];
	$att_UID_list = [];
	$sql_get_ids = mysqli_query($link, "SELECT people.user_ID FROM people");
	while ($ID = mysqli_fetch_array($sql_get_ids)) $UID_list[] = build_col_name($link, $ID["user_ID"]);

	$result = $link->query("SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` 
                                    WHERE `TABLE_SCHEMA`='personnel' AND `TABLE_NAME`='attendance' 
									AND COLUMN_NAME NOT LIKE 'event_ID'");
	while ($ID = mysqli_fetch_array($result)) $att_UID_list[] = $ID['COLUMN_NAME'];
	if (is_array($UID_list)) {
		foreach ($UID_list as $UID) {
			if (is_array($att_UID_list)) {
				if (!in_array($UID, $att_UID_list)) {
					//add column to attendance
					add_att_user($link, $UID);
				}
			} else {
				add_att_user($link, $UID);
			}
		}
	}

	// check that each column has a person
	if (is_array($att_UID_list)) {
		foreach ($att_UID_list as $UID) {
			if (!in_array($UID, $UID_list)) {
				//add remove column from attendance
				remove_att_user($link, $UID);
			}
		}
	}
}
