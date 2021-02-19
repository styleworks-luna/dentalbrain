<?php


namespace App\Payments\TossPayments;


class TossPaymentsResponse implements \ArrayAccess
{
    private $data;
    private $fullResponse;

    /**
     * TossPaymentsResponse constructor.
     * @param string $tossResponse 토스 결과 전달 전체를 string 으로 변환 한 값.
     */
    public function __construct(string $tossResponse)
    {
        $this->data = json_decode($tossResponse, true);
        $this->fullResponse = $tossResponse;
    }

    /**
     * 토스 결과 전체를 string으로 변환한 값.
     * @return string
     */
    public function getFullResponse() : string
    {
        return $this->fullResponse;
    }

    /**
     * 토스 결과를 배열로 반환.
     * @return array
     */
    public function getArray() : array
    {
        return $this->data;
    }

    /*
     * ===================== FOR ARRAY ACCESS =======================
     */
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

    /*
    * ===================== TO STRING =====================
    */

    function __toString()
    {
        return $this->fullResponse;
    }
}
