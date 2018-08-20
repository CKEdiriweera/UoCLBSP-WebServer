<?php

class Nearby_search_model extends CI_Model
{
    function test()
    {
    }

    function search_room_type($location_type)
    {
        return $this->db->select('type, id')->like('type', $location_type, 'both')->order_by('type', 'ASC')->limit(5)->get('room_type')->result();
    }

    function search_nearby_places($data)
    {
        $data2[]  = array(
            'lat'=> 0,
            'lng'=> 0,
            'name'=> "",
            'description'=> "",
        );

        $lat1 = $data['lat1'];
        $lng1 = $data['lng1'];
        $type = $data['type'];
//        echo $lat1;

        $query = $this->db->query("SELECT building.latitudes, building.longitudes, room.name, room.description,
    ( 3959 * acos( cos( radians($lat1) ) * cos( radians(building.latitudes) ) * cos( radians($lng1) 
    - radians(building.longitudes) ) + sin( radians($lat1) ) * sin( radians(building.latitudes) ) ) ) AS distance
    FROM building, room, room_type WHERE room_type.type = '".$type."' AND room_type.id = room.room_type_id AND room.building_id = building.id 
    HAVING distance < 10 ORDER BY distance LIMIT 0 , 10;");
        foreach ($query->result() as $row)
        {
            $data2[]  = array(
                'lat' =>   $row->latitudes,
                'lng' =>   $row->longitudes,
                'name' =>   $row->name,
                'description' =>   $row->description,
            );
        }
        return $data2;
//        var_dump($data2);
    }

}