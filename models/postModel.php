<?php

class PostModel
{

    function getPosts($type, $parent = null, $limit = 100, $id = null)
    {
        $db = new db();
        $query = "SELECT id,text,user_id FROM posts where deleted != 1 ";
        if ($type == "main") {
            $query .= "and type='main'";
        } else if ($type == "sub") {
            $query .= "and type='sub' and parent='$parent' order by id asc limit $limit";
        } else if ($type == "id") {
            $query .= "and type='main' and id = $id";
        }

        if ($result = $db->query($query)) {
            while ($row = $result->fetch_assoc()) {
                $results_array[] = $row;
            }
            return $results_array;
        }
    }

    function getSubPostAmount($id = null)
    {
        $db = new db();
        $query = "SELECT id FROM posts where type='sub' and parent='$id' and deleted != 1";
        if ($result = $db->query($query)) {
            $rowCount = $result->num_rows;
            return $rowCount;
        }
    }

}