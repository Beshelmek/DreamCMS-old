<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Rcon {
    const SERVERDATA_EXECCOMMAND    = 2;
    const SERVERDATA_AUTH           = 3;
    const SERVERDATA_RESPONSE_VALUE = 0;
    const SERVERDATA_AUTH_RESPONSE  = 2;

    private $Socket, $RequestId, $host, $password, $port;

    public function __destruct()
    {
        $this->Disconnect();
    }

    public function Connect($host = 1, $port = 0, $password = 0)
    {
        $this->RequestId = 0;
        $this->host		= $host;
        $this->password	= $password;
        $this->port		= $port;
        $time = 5;


        if($this->Socket = @fsockopen($this->host, $this->port, $errno, $errstr, $time))
        {
            @stream_set_timeout($this->Socket, $time, 0);
            if(!$this->Auth($this->password))
            {
                $this->Disconnect();
            }
            return true;
        }
        return false;
    }

    public function Disconnect()
    {
        if($this->Socket)
        {
            FClose($this->Socket);
            $this->Socket = null;
        }
    }

    public function Command($String = '')
    {
        if(!empty($String)) {
            if ($this->WriteData(self :: SERVERDATA_EXECCOMMAND, $String)) return true;
        }
        return false;
    }

    private function Auth($Password)
    {
        if( !$this->WriteData(self :: SERVERDATA_AUTH, $Password))
        {
            return false;
        }

        $Data = $this->ReadData();

        return $Data['RequestId'] > -1 && $Data['Response'] == self :: SERVERDATA_AUTH_RESPONSE;
    }

    private function ReadData()
    {
        $Packet = Array();

        $Size = FRead($this->Socket, 4);
        $Size = @UnPack('V1Size', $Size);
        $Size = $Size['Size'];

        $Packet = @FRead($this->Socket, $Size);
        $Packet = @UnPack('V1RequestId/V1Response/a*String/a*String2', $Packet);

        return $Packet;
    }

    private function WriteData($Command, $String = "")
    {
        $Data = Pack('VV', $this->RequestId++, $Command) . $String . "\x00\x00\x00";
        $Data = Pack('V', StrLen($Data)) . $Data;
        $Length = StrLen($Data);
        return $Length === @FWrite($this->Socket, $Data, $Length);
    }
}