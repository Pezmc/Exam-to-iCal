<?php

date_default_timezone_set("Europe/London");

/**
 * Trim a string, breaking at spaces if possible!
 */
function smartTruncate($string, $limit = 50, $break=' ', $pad='...')
{
  // return with no change if string is shorter than $limit
  if(strlen($string) <= $limit) return $string;

  $string = substr($string, 0, $limit);
  if(false !== ($breakpoint = strrpos($string, $break))) {
    $string = substr($string, 0, $breakpoint);
  }

  return $string . $pad;
}

// If a $_POST was sent
if(!empty($_POST)) {

  // Basic scripting protection
  if(isset($_SERVER['HTTP_REFERER']) && isset($_SERVER['SERVER_NAME'])
      && strpos($_SERVER['HTTP_REFERER'], $_SERVER['SERVER_NAME']) === false)
    die("You need to post from the original domain.");

  // Basic robot trap
  if(isset($_POST['email']) && $_POST['email'] != "email@email.com"
      && isset($_POST['comment']) && $_POST['comment'] != "")
    die("You look like a robot, please ignore the email and comment fields");
  
  // Dumb validation
  if(empty($_POST['data']))
    die("You posted an empty form.");
  
  // Read user input
  $string = trim($_POST['data']);
  
  // Split the posted data into rows
  $rows = preg_split("/(\r?\n)/", $string);
  
  // Simple error detection
  if(empty($rows)) 
    die("You appear to have posted no information.");

  // Forces file download instead of web page
  header('Content-type: text/calendar; charset=utf-8');
  header('Content-Disposition: inline; filename=calendar.ics');

  // iCal header
  print("BEGIN:VCALENDAR\r\n");
  print("VERSION:2.0\r\n");
  print("PRODID:-//hacksw/handcal//NONSGML v1.0//EN\r\n");
  print("UID:" . md5(uniqid(mt_rand(), true)) . "@PezCuckow.com\r\n");

  // Basic log
  $fh = @fopen("simpleLog.txt", 'a');

  // For every row in the input
  foreach($rows as $row){

    $data = explode("\t", $row);

    // Simple file log for debugging
    @fwrite($fh, '['. date("Y-m-d H:i:s") . '] ' . $row. "\n");

    //Exam Code	Title	Date	Location	Seat	Start	Finish
    if(empty($data)||empty($data[6])||strtolower($data[0])=="exam code") continue;

    $start = strtotime($data[2]." ".$data[5]);
    $end = strtotime($data[2]." ".$data[6]);

    print("BEGIN:VEVENT\r\n");
    print("DTSTART:".date("Ymd", $start)."T".date("His", $start)."\r\n");
    print("DTEND:".date("Ymd", $end)."T".date("His", $end)."\r\n");
    print("SUMMARY:".smartTruncate($data[1], 40)." (".$data[0].")\r\n");
    print("DESCRIPTION:Title: ".$data[1]
                        ."\\nCode: ".$data[0]
                        ."\\nSeat: ".$data[4]
                        ."\\nStart: ".$data[5]
                        ."\\nEnd: ".$data[6]
                        ."\\n\\nRaw\\n". str_replace("\t", " - ", $row)."\r\n");
    print("LOCATION:".$data[3]."\r\n");
    print("END:VEVENT\r\n");

  }
  @fclose($fh);

  print("END:VCALENDAR\r\n");

  exit;

} else {
  include("examiCal/template.php");
}

?>