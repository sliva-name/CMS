<?php

/**
 * function class
 */

namespace engine\Fun;

use Engine\Core\DataBase\Connect;
use Exception;

class Fun extends Connect
{

    /**
     * return disk free space in ROOT
     */
    public function free_space(): float
    {
        return round(disk_free_space("/") / 1024 / 1024 / 1024, 2);
    }

    /**
     * @param string $string
     * @return string
     */
    private function UUIDFromString(string $string): string
    {
        $val = md5($string, true);
        $byte = array_values(unpack('C16', $val));

        $tLo = ($byte[0] << 24) | ($byte[1] << 16) | ($byte[2] << 8) | $byte[3];
        $tMi = ($byte[4] << 8) | $byte[5];
        $tHi = ($byte[6] << 8) | $byte[7];
        $csLo = $byte[9];
        $csHi = $byte[8] & 0x3f | (1 << 7);

        if (pack('L', 0x6162797A) == pack('N', 0x6162797A)) {
            $tLo = (($tLo & 0x000000ff) << 24) | (($tLo & 0x0000ff00) << 8) | (($tLo & 0x00ff0000) >> 8) | (($tLo & 0xff000000) >> 24);
            $tMi = (($tMi & 0x00ff) << 8) | (($tMi & 0xff00) >> 8);
            $tHi = (($tHi & 0x00ff) << 8) | (($tHi & 0xff00) >> 8);
        }

        $tHi &= 0x0fff;
        $tHi |= (3 << 12);

        return sprintf(
            '%08x-%04x-%04x-%02x%02x-%02x%02x%02x%02x%02x%02x',
            $tLo,
            $tMi,
            $tHi,
            $csHi,
            $csLo,
            $byte[10],
            $byte[11],
            $byte[12],
            $byte[13],
            $byte[14],
            $byte[15]
        );
    }

    /**
     * UUID name convert
     **/
    public function uuidConvert(string $string): string
    {
        return $this->UUIDFromString("OfflinePlayer:" . $string);
    }

    /**
     * @throws Exception
     */
    public function countPercent(int $timeStart, int $timeEnd): float
    {
        if ($timeStart && $timeEnd) {
            return round((100 * (time() - $timeStart)) / ($timeEnd - $timeStart));
        }

        throw new Exception("Не найдено значений", 1);
    }

    public function GzipConvert($filename)
    {
        $data = file_get_contents($filename);
        $cdata = gzencode($data, 9);
        file_put_contents($filename . ".gz", $cdata);
    }
}
