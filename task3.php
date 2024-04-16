<?php
require 'vendor/autoload.php';

use League\CLImate\CLImate;

class MoveTable
{
    private $moves;
    private $size;

    public function __construct($moves)
    {
        $this->moves = $moves;
        $this->size = count($moves);
    }

    public function getSize()
    {
        return (int) $this->size;
    }

    public function getMoveName($index)
    {
        return $this->moves[$index];
    }

    public function getResult($move1, $move2)
    {
        $halfSize = ($this->size - 1) / 2;
        $diff = ($move1 - $move2 + $this->size) % $this->size;

        if ($diff == 0) {
            return "Draw";
        } elseif ($diff <= $halfSize) {
            return "Win";
        } else {
            return "Lose";
        }
    }
}

class KeyGenerator
{
    public static function generateKey($length)
    {
        return bin2hex(random_bytes($length / 2));
    }
}

class HMAC
{
    public static function generateHMAC($message, $key)
    {
        return hash_hmac('sha256', $message, $key);
    }
}

class Game
{
    private $moves;
    private $moveTable;
    private $key;

    public function __construct($moves)
    {
        $this->moves = $moves;
        $this->moveTable = new MoveTable($moves);
        $this->key = KeyGenerator::generateKey(256);
    }

    public function start()
    {
        // Проверяем, есть ли повторяющиеся параметры
        foreach ($this->moves as $index => $move) {
            if ($index !== array_search($move, $this->moves)) {
                exit("Invalid move. Parameter '$move' is repeated. Please try again." . PHP_EOL);
            }
        }

        echo "HMAC: " . HMAC::generateHMAC($this->moves[array_rand($this->moves)], $this->key) . PHP_EOL;
        echo "Available moves:" . PHP_EOL;
        foreach ($this->moves as $index => $move) {
            echo ($index + 1) . " - " . $move . PHP_EOL;
        }
        echo "0 - exit" . PHP_EOL;
        echo "? - help" . PHP_EOL;
        echo "Enter your move: ";
        $userMove = trim(fgets(STDIN));

        echo "User input: $userMove" . PHP_EOL;

        if ($userMove === "0") {
            exit("Goodbye!" . PHP_EOL);
        } elseif ($userMove === "?") {
            echo "Help requested" . PHP_EOL;
            $this->showHelp();
        } elseif (!is_numeric($userMove) || $userMove < 1 || $userMove > $this->moveTable->getSize()) {
            echo "Invalid move. Please try again." . PHP_EOL;
            $this->start();
        } elseif (substr($userMove, -1) === "?") {
            echo "Help requested" . PHP_EOL;
            $this->showHelp();
        } else {
            $this->play($userMove);
        }
    }

    private function play($userMove)
    {
        $computerMove = array_rand($this->moves) + 1;
        $result = $this->moveTable->getResult($userMove, $computerMove);
        $userMoveName = $this->moves[$userMove - 1];
        $computerMoveName = $this->moves[$computerMove - 1];

        echo "Your move: " . $userMoveName . PHP_EOL;
        echo "Computer move: " . $computerMoveName . PHP_EOL;

        if ($result === "Draw") {
            echo "It's a draw!" . PHP_EOL;
        } elseif ($result === "Win") {
            echo "You win!" . PHP_EOL;
        } else {
            echo "Computer wins!" . PHP_EOL;
        }

        echo "HMAC key: " . $this->key . PHP_EOL;
    }
    private function showHelp()
    {
        $climate = new CLImate();
        $size = $this->moveTable->getSize();
        if (!is_null($size)) {
            $headers = ["Moves"];
            foreach ($this->moves as $move) {
                $headers[] = $move;
            }
        $tableData[] = $headers;
            for ($i = 0; $i < $size; $i++) {
                $rowData = [$this->moves[$i]];
                for ($j = 0; $j < $size; $j++) {
                    $result = $this->moveTable->getResult($i + 1, $j + 1);
                    $rowData[] = $result;
                }
                $tableData[] = $rowData;
            }
            $climate->table($tableData);
        }
        $this->start();
    }
}

array_shift($argv);

if (count($argv) < 3 || count($argv) > 7 || count($argv) % 2 === 0) {
    exit("Usage: php task3.php [move1] [move2] ... (at least 3 and at most 7 odd moves)" . PHP_EOL);
}

$moves = $argv;
$game = new Game($moves);
$game->start();
