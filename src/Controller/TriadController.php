<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TriadController extends AbstractController
{
    /**
     * @Route("/triad/{x}/{shfl}/{mode}", name="triad")
     */
    public function index($x, $shfl, $mode)
    {
    	$a_key = $this->createScale($x, $shfl, $mode);
    	$key_members = $a_key[0];
    	$thirds_and_fifths = $a_key[1];

        return $this->render('triad/index.html.twig', [
            'controller_name' => 'TriadController',
            'key_members' => $key_members,
            'thirds_and_fifths' => $thirds_and_fifths,
        ]);
    }

    private function createScale($x, $shfl, $mode){
    	if($shfl == 'sharp') {
    		$letters_array = [0=>'A', 1=>'A#', 2=>'B', 3=>'C', 4=>'C#', 5=>'D', 6=>'D#', 7=>'E', 8=>'F', 9=>'F#', 10=>'G', 11=>'G#'];
    	} else {
    		$letters_array = [0=>'A', 1=>'Bb', 2=>'B', 3=>'C', 4=>'Db', 5=>'D', 6=>'Eb', 7=>'E', 8=>'F', 9=>'Gb', 10=>'G', 11=>'Ab'];
    	}
		
		
		$key = $letters_array[$x];
		$chromatic_members = [];

		for ($i=$x; $i < 12; $i++) { 
			$chromatic_members[] = $letters_array[$i];
		}
		if($x > 0){
			for ($i=0; $i < $x; $i++) { 
				$chromatic_members[] = $letters_array[$i];
			}
		}

		$key_members = [];

		if($mode == 'major'){
			$key_members['tonic'] = [$chromatic_members[0], 'major', 0];
			$key_members['supertonic'] = [$chromatic_members[2], 'minor', 2];
			$key_members['mediant'] = [$chromatic_members[4], 'minor', 4];
			$key_members['subdominant'] = [$chromatic_members[5], 'major', 5];
			$key_members['dominant'] = [$chromatic_members[7], 'major', 7];
			$key_members['submediant'] = [$chromatic_members[9], 'minor', 9];
			$key_members['leading_note'] = [$chromatic_members[11], 'dim', 11];
		} else {
			$key_members['tonic'] = [$chromatic_members[0], 'minor', 0];
			$key_members['supertonic'] = [$chromatic_members[2], 'dim', 2];
			$key_members['mediant'] = [$chromatic_members[3], 'aug', 3];
			$key_members['subdominant'] = [$chromatic_members[5], 'minor', 5];
			$key_members['dominant'] = [$chromatic_members[7], 'major', 7];
			$key_members['submediant'] = [$chromatic_members[8], 'major', 10];
			$key_members['leading_note'] = [$chromatic_members[11], 'dim', 11];

		}

		$thirds_and_fifths = [];
		foreach ($key_members as $key => $value) {
			list($to_third, $to_fifth) = $this->getIntervals($key, $value[1]);
			$tonic = $value[2];
			$third = $tonic+$to_third;
			$fifth = $tonic+$to_fifth;
			if($third > 11) {
				$third -= 12;
			}
			if($fifth > 11) {
				$fifth -=12;
			}
			$thirds_and_fifths[] = [$chromatic_members[$tonic], $chromatic_members[$third], $chromatic_members[$fifth]];
		}
		

		return [$key_members, $thirds_and_fifths];

    }

    private function getIntervals($x, $mode){
    	if($mode == "major") {
    		$to_third = 4;
    		$to_fifth = 7;
    	} else if ($mode == "minor") {
    		$to_third = 3;
    		$to_fifth = 7;
    	} else if ($mode == "aug") {
    		$to_third = 4;
    		$to_fifth = 8;
    	} else if ($mode == "dim"){
    		$to_third = 3;
    		$to_fifth = 6;
    	}

    	return [$to_third, $to_fifth];
    }
}
