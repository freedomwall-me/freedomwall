<?php

/**
 * Repl.it DB Logic
 * @author Channing Babb <channingbabb@gmail.com>
 */

class ReplDB
{
    public $REPLIT_DB_URL;
    
    public function REPLIT_DB_URL()
    {
        return getenv('REPLIT_DB_URL');
    }
    
    public function setKey($keyname, $data, $isArray = true)
    {
        if (!(isset($keyname) || isset($data) || !empty($data)))
            return "You must set a keyname and have data. Syntax: setKey(\$keyname, \$data, [true | false])";

		// serialize the data so that it's in one key
        // if you do an array, it will make a key for each value
        $data = array(
            $keyname => serialize($data)
        );
            
        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data)
            )
        );
		
        $context = stream_context_create($options);
		
        return file_get_contents($this->REPLIT_DB_URL(), false, $context);
    }
    
    public function getKey($keyname)
    {
        if (isset($keyname) && !empty($keyname))
		{
			$http = @file_get_contents($this->REPLIT_DB_URL() . '/' . $keyname);
			if (!$http)
				return array();
            return unserialize($http);
		}
    }
    
    public function delKey($keyname)
    {
        if (isset($keyname) && !empty($keyname))
        {
            return file_get_contents($this->REPLIT_DB_URL() . '/' . $keyname, false, stream_context_create(array(
                'http' => array(
                    'method' => 'DELETE'
                )
            )));
        }
    }
    
    public function keyExists($keyName)
    {
        return !empty($this->getKey($keyName));
    }
    
    public function listKeys($inArray)
    {
        $keysRaw = file_get_contents($this->REPLIT_DB_URL() . '?prefix');
        $keyList = explode("\n", $keysRaw);
        $keys    = array();
		
        if ($inArray)
        {
            $keyArray = array();
            foreach ($keyList as $key)
                array_push($keyArray, $key);
			
            return $keyArray;
        }
        else
        {
            foreach ($keyList as $key)
                echo $key;
        }
    }
    
    public function listKeysData($inArray)
    {
        $keysRaw = file_get_contents($this->REPLIT_DB_URL() . '?prefix');
        $keyList = explode("\n", $keysRaw);
        $keys    = array();
		
        if ($inArray)
        {
            $keyArray = array();
            foreach ($keyList as $key)
                array_push($keyArray, getKey($key));
			
            return $keyArray;
        }
        else
        {
            foreach ($keyList as $key)
                print_r(getKey($key));
        }
    }
    
    public function deleteAllKeys()
    {
        $keysRaw = file_get_contents($this->REPLIT_DB_URL() . '?prefix');
        $keyList = explode("\n", $keysRaw);
        foreach ($keyList as $key)
        {
            $this->delKey($key);
        }
    }
    
}

?>