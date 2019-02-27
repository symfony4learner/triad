<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CmdController extends AbstractController
{
    /**
     * @Route("/cmd", name="cmd")
     */
    public function index()
    {
        return $this->render('cmd/index.html.twig', [
            'controller_name' => 'CmdController',
        ]);
    }

    /**
     * @Route("/cmd/exec", name="execute")
     */
    public function exec(Request $request)
    {
        $output = str_replace(" ", "_", $request->request->get('output'));
        $format = $request->request->get('output-format');

	    $file = $request->files->get('input');
	    $status = array('status' => "success","fileUploaded" => false);
	    $new_full_path = "";
	  	$message = "<ol>";

	  	if ($output == "") {
	  		$message .= "<li style='color:red;'>The output name is empty. Please add a name for the output file. </li>";
	  		goto end;
	  	}
	  	if ($format == "") {
	  		$message .= "<li style='color:red;'>The output file type is not selected. Please select one. </li>";
	  		goto end;
	  	}
	    // If a file was uploaded
	    if(!is_null($file)){
	    	$message .= "<li style='color:green'>The file was found :) </li>";
	      	// generate a random name for the file but keep the extension
	      	$filename = uniqid().".".$file->getClientOriginalExtension();
	      	$path = $this->getParameter('brochures_directory');
	      	$file->move($path,$filename); // move the file to a path
	      	$status = array('status' => "success","fileUploaded" => true);
	      	$new_full_path = $path."/".$filename;
	      	$message .= "<li style='color:green'>The file was successfully copied :) </li>";
	    } else {
	    	$message .= "<li style='color:red'>You haven't selected any file to convert! </li>";
	    	goto end;
	    }
	    if (!file_exists('/home/milkayo/Desktop/smile')) {
		    mkdir('/home/milkayo/Desktop/smile', 0777, true);
		}
	    $cmd_string = "pandoc ".$new_full_path." -s -o /home/milkayo/Desktop/smile/".$output.".".$format." --verbose";
	    $result_str = shell_exec($cmd_string);
	    //"pandoc $new_full_path -s -o simplenote.pdf"
	   if(null == $result_str){
	   	$message .= "<li style='color:red'>There was an error with the command, or no output from the command. :( </li>";
	   } else {
	   	$message .= "<li style='color:green'>The command was successfully executed</li>
	   				<li style='color:green'>$output.$format is at Desktop/smile folder! :)</li>
	   		<a class=\"btn btn-primary btn-block\" data-toggle=\"collapse\" href=\"#collapseExample\" role=\"button\" aria-expanded=\"false\" aria-controls=\"collapseExample\">
		    	See Results
		  	</a>
		  	<div class=\"collapse\" id=\"collapseExample\">$result_str</div>
	   	";
	   }
	   end:
	   $message .= "</ol>";
	   return new JsonResponse($message);      	
   // return new JsonResponse($string);
    }
}
