<?php

namespace AnimalQuiz\Model;

class Animals {

    public function getAnimals() {

        return array(
            array('id' => 1, 'animal' => 'ant'),
            array('id' => 2, 'animal' => 'antelope'),
            array('id' => 3, 'animal' => 'baboon'),
            array('id' => 4, 'animal' => 'badger'),
            array('id' => 5, 'animal' => 'bat'),
            array('id' => 6, 'animal' => 'beaver'),
            array('id' => 7, 'animal' => 'bee'),
            array('id' => 8, 'animal' => 'beetle'),
            array('id' => 9, 'animal' => 'fossa'),
            array('id' => 10, 'animal' => 'bison'),
            array('id' => 11, 'animal' => 'bongo'),
            array('id' => 12, 'animal' => 'buffalo'),
            array('id' => 13, 'animal' => 'camel'),
            array('id' => 14, 'animal' => 'cat'),
            array('id' => 15, 'animal' => 'centipede'),
            array('id' => 16, 'animal' => 'cheetah'),
            array('id' => 17, 'animal' => 'chicken'),
            array('id' => 18, 'animal' => 'coati'),
            array('id' => 19, 'animal' => 'crab'),
            array('id' => 20, 'animal' => 'crocodile'),
            array('id' => 21, 'animal' => 'deer'),
            array('id' => 22, 'animal' => 'dog'),
            array('id' => 23, 'animal' => 'donkey'),
            array('id' => 24, 'animal' => 'duck'),
            array('id' => 25, 'animal' => 'eagle'),
            array('id' => 26, 'animal' => 'echidna'),
            array('id' => 27, 'animal' => 'elephant'),
            array('id' => 28, 'animal' => 'emu'),
            array('id' => 29, 'animal' => 'falcon'),
            array('id' => 30, 'animal' => 'fish'),
            array('id' => 31, 'animal' => 'fly'),
            array('id' => 32, 'animal' => 'fox'),
            array('id' => 33, 'animal' => 'frog'),
            array('id' => 34, 'animal' => 'gar'),
            array('id' => 35, 'animal' => 'gecko'),
            array('id' => 36, 'animal' => 'giraffe'),
            array('id' => 37, 'animal' => 'gopher'),
            array('id' => 38, 'animal' => 'gorilla'),
            array('id' => 39, 'animal' => 'hamster'),
            array('id' => 40, 'animal' => 'hare'),
            array('id' => 41, 'animal' => 'heron'),
            array('id' => 42, 'animal' => 'horse'),
            array('id' => 43, 'animal' => 'hummingbird'),
            array('id' => 44, 'animal' => 'ibis'),
            array('id' => 45, 'animal' => 'iguana'),
            array('id' => 46, 'animal' => 'jackal'),
            array('id' => 47, 'animal' => 'jellyfish'),
            array('id' => 48, 'animal' => 'kangaroo'),
            array('id' => 49, 'animal' => 'killer whale'),
            array('id' => 50, 'animal' => 'kiwi'),
            array('id' => 51, 'animal' => 'koala'),
            array('id' => 52, 'animal' => 'ladybug'),
            array('id' => 53, 'animal' => 'lemur'),
            array('id' => 54, 'animal' => 'lion'),
            array('id' => 55, 'animal' => 'llama'),
            array('id' => 56, 'animal' => 'mongoose'),
            array('id' => 57, 'animal' => 'monkey'),
            array('id' => 58, 'animal' => 'moorhen'),
            array('id' => 59, 'animal' => 'moose'),
            array('id' => 60, 'animal' => 'moth'),
            array('id' => 61, 'animal' => 'octopus'),
            array('id' => 62, 'animal' => 'parrot'),
            array('id' => 63, 'animal' => 'pelican'),
            array('id' => 64, 'animal' => 'penguin'),
            array('id' => 65, 'animal' => 'pig'),
            array('id' => 66, 'animal' => 'puffin'),
            array('id' => 67, 'animal' => 'quail'),
            array('id' => 68, 'animal' => 'quoll'),
            array('id' => 69, 'animal' => 'rabbit'),
            array('id' => 70, 'animal' => 'raccon'),
            array('id' => 71, 'animal' => 'rat'),
            array('id' => 72, 'animal' => 'rhino'),
            array('id' => 73, 'animal' => 'sea horse'),
            array('id' => 74, 'animal' => 'skunk'),
            array('id' => 75, 'animal' => 'snail'),
            array('id' => 76, 'animal' => 'snake'),
            array('id' => 77, 'animal' => 'sparrow'),
            array('id' => 78, 'animal' => 'squid'),
            array('id' => 79, 'animal' => 'starfish'),
            array('id' => 80, 'animal' => 'stingray'),
            array('id' => 81, 'animal' => 'swan'),
            array('id' => 82, 'animal' => 'tiger'),
            array('id' => 83, 'animal' => 'turkey'),
            array('id' => 84, 'animal' => 'turtle'),
            array('id' => 85, 'animal' => 'walrus'),
            array('id' => 86, 'animal' => 'weasel'),
            array('id' => 87, 'animal' => 'wild boar'),
            array('id' => 88, 'animal' => 'wolf'),
            array('id' => 89, 'animal' => 'wolverine'),
            array('id' => 90, 'animal' => 'zebra'),
        );
    }

    public function getSelected($record_id) {

        $range = range(1, 90);
        shuffle($range);
        $result = array_slice($range, 1, 5);
        $i = 0;
        $aId = array($record_id);
        foreach ($result as $val) {

            if ($record_id != $val) {

                $aId[] = $val;
                $i++;

                if ($i == 3) {
                    break;
                }
            }
        }
        shuffle($aId);
        return $aId;
    }

    public function upTo($num) {

        $animals = $this->getAnimals();
        shuffle($animals);
        $handler = array();
        for ($i = 0; $i <= $num - 1; $i++) {
            $animals[$i]['choices'] = $this->getSelected($animals[$i]['id']);
            $handler[] = $animals[$i];
        }
        return $handler;
    }
}