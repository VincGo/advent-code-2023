<?php

class Resolve
{
    protected int $_red = 12;
    protected int $_green = 13;
    protected int $_blue = 14;
    protected int $_total = 0;
    protected string $_rowWithoutId = '';
    protected int $_id = 0;
    protected array $_minCubes = [
        'red' => null,
        'blue' => null,
        'green' => null,
    ];

    public function execute(): int
    {
        $file = fopen("input.txt", "r") or die("Unable to open file!");
        while (!feof($file)) {
            $row = fgets($file);
            if (!$row) continue;

            $this->_handleId($row);

            $sets = explode(';', $this->_rowWithoutId);

            // $this->_partOne($sets);

            $this->_partTwo($sets);
        }

        fclose($file);

        return $this->_total;
    }

    private function _handleId(string $row): void
    {
        $pattern = '/Game\s(\d+):/';
        preg_match($pattern, $row, $matches);

        $this->_rowWithoutId = str_replace($matches[0], '', $row);
        $this->_id = $matches[1];
    }

    private function _partTwo(array $sets): void
    {
        foreach ($sets as $set) {
            $cubes = explode(',', $set);

            foreach ($cubes as $cube) {
                $explodeCube = explode(' ', trim($cube));

                $minCube = $this->_minCubes[$explodeCube[1]];
                if (!$minCube || $minCube < $explodeCube[0]) {
                    $this->_minCubes[$explodeCube[1]] = $explodeCube[0];
                }
            }
        }

        $powerSetOfCube = array_reduce($this->_minCubes, function (int $carry, int $item) {
            return $carry * $item;
        }, 1);

        var_dump($powerSetOfCube);

        $this->_total += $powerSetOfCube;
        $this->_resetMinCubes();
    }

    private function _partOne(array $sets): void
    {
        $isPossible = true;
        foreach ($sets as $set) {
            $cubes = explode(',', $set);

            if (!$this->_isGamePossible($cubes)) {
                $isPossible = false;
                break;
            }
        }

        if ($isPossible) {
            $this->_total += $this->_id;
        }
    }

    private function _isGamePossible(array $cubes): bool
    {
        foreach ($cubes as $cube) {
            $explodeCube = explode(' ', trim($cube));

            if ($explodeCube[1] === 'red' && $explodeCube[0] > $this->_red) {
                return false;
            } else if ($explodeCube[1] === 'blue' && $explodeCube[0] > $this->_blue) {
                return false;
            } else if ($explodeCube[1] === 'green' && $explodeCube[0] > $this->_green) {
                return false;
            }
        }
        return true;
    }

    private function _resetMinCubes(): void
    {
        $this->_minCubes = [
            'red' => null,
            'blue' => null,
            'green' => null,
        ];
    }
}

$resolve = new Resolve();
echo $resolve->execute();
