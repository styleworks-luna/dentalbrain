<?php


namespace App\Http\Requests\Payments;


class TossPaymentsResponse implements \ArrayAccess
{
    private $data;
    private $fullResponse;

    public function __construct(string $tossResponse)
    {
        $this->data = json_decode($tossResponse, true);
        $this->fullResponse = $tossResponse;
    }

    public function getFullResponse()
    {
        return $this->fullResponse;
    }

    public function getArray()
    {
        return $this->data;
    }

    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }

    public function offsetGet($offset)
    {
        return isset($this->data[$offset]) ? $this->data[$offset] : null;
    }

    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->data[] = $value;
        } else {
            $this->data[$offset] = $value;
        }
    }

    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }
}
