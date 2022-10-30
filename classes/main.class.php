<?

/**
 * Repl.it DB
 * @author Channing Babb <channingbabb@gmail.com>
 */


require_once 'replitdb.class.php';

class Main
{

    public function randomString($length = 32)
    {
        $characters       = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString     = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    private function stringCleanser($string)
    {
        $newString = strip_tags($string);
        $newString = htmlspecialchars($newString);
        return $newString;
    }


    public function insertKey($keyName, $dataarray)
    {
        $ReplDB = new ReplDB;
        if (isset($dataarray)) {
            if (!empty($dataarray)) {
                if (is_array($dataarray)) {
                    if ($ReplDB->keyExists($keyName) == false) {
                        $newDataArray = array();
                        foreach ($dataarray as $item) {
                            array_push($newDataArray, $this->stringCleanser($item));
                        }
                        $ReplDB->setKey($keyName, $newDataArray);
                    } else {
                        return "KEY_EXISTS";
                    }
                } else {
                    return "NOT_ARRAY";
                }
            } else {
                return "EMPTY";
            }
        } else {
            return "IS_NOT_SET";
        }
    }

    // Gets all keys (names)
    public function getKeys($inArray = false)
    {
        $ReplDB = new ReplDB;
        return $ReplDB->listKeys($inArray);
    }

    // Gets data from key specified
    public function getDataKeys($inArray = false)
    {
        $ReplDB = new ReplDB;
        return $ReplDB->listKeysData($inArray);
    }

    // Gets data from key specified
    public function getDataKey($keyName)
    {
        $ReplDB = new ReplDB;
        if (!$ReplDB->keyExists($keyName))
            return array();
        return $ReplDB->getKey($keyName);
    }

    // Deletes key specified
    public function delKey($keyName)
    {
        $ReplDB = new ReplDB;
        $ReplDB->delKey($keyName);
    }

    // Deletes all keys
    public function delKeys()
    {
        $ReplDB = new ReplDB;
        $ReplDB->deleteAllKeys();
    }
}
