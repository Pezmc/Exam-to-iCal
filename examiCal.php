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
  
  // Make life easier
  $mapping = array(
    'code', 'name', 'date', 'location', 'seat', 'start', 'end'
  );
  $mapping = array_flip($mapping);

  // For every row in the input
  foreach($rows as $row){

    // Should be tab separated
    $data = array_filter(explode("\t", $row));
    
    // Sometimes empty columns sneak in...
    $data = array_filter($data);
    
    // Reindex now some columns may have been deleted
    $data = array_values($data);
    
    // MyManchester has a thing for trailing whitespace
    foreach($data as &$field) {
      $field = trim($field);
    }

    // Simple file log for debugging
    @fwrite($fh, '['. date("Y-m-d H:i:s") . '] ' . $row. "\n");

    //Exam Code	Title	Date	Location	Seat	Start	Finish
    if(empty($data)||empty($data[6])||strtolower($data[$mapping['code']])=="exam code") continue;

    $start = strtotime($data[$mapping['date']]." ".$data[$mapping['start']]);
    $end = strtotime($data[$mapping['date']]." ".$data[$mapping['end']]);

    print("BEGIN:VEVENT\r\n");
    print("DTSTART:".date("Ymd", $start)."T".date("His", $start)."\r\n");
    print("DTEND:".date("Ymd", $end)."T".date("His", $end)."\r\n");
    print("SUMMARY:".smartTruncate($data[$mapping['name']], 40)." (".$data[$mapping['code']].")\r\n");
    print("DESCRIPTION:Title: ".$data[$mapping['name']]
                        ."\\nCode: ".$data[$mapping['code']]
                        ."\\nSeat: ".$data[$mapping['seat']]
                        ."\\nStart: ".$data[$mapping['start']]
                        ."\\nEnd: ".$data[$mapping['end']]
                        ."\\n\\nRaw\\n". str_replace("\t", " - ", $row)."\r\n");
    print("LOCATION:".$data[$mapping['location']]."\r\n");
    print("END:VEVENT\r\n");

  }
  @fclose($fh);

  print("END:VCALENDAR\r\n");

  exit;

} else {
  include("examiCal/template.php");
}

?>