<!DOCTYPE html>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <title>Exam &gt; iCal Converter</title>
    <link rel="stylesheet" type="text/css" href="examiCal/styles.css" />
    <!--[if IE]>  
      <style type="text/css">
      .clear {
        zoom: 1;
        display: block;
      }
      </style>
    <![endif]-->
</head>

<body>
<!--
  Thanks to http://tutorialzine.com/2010/02/html5-css3-website-template/ for the template!
-->
    <div class="section" id="page">

        <div class="header">

            <h1>Exam to iCal</h1>

            <h3>Exam timetable to .ics for easy import</h3>

            <div class="nav clear">
                <ul>
                    <li><a href="#article1">About</a></li>

                    <li><a href="#article2">Use</a></li>
                    
                    <li><a href="#article3">Source</a></li>
                </ul>
            </div>
        </div>

        <div class="section" id="articles">

            <div class="line"></div>

            <div class="article" id="article1">

                <h2>About</h2>

                <div class="line"></div>

                <div class="articleBody clear">
                    <p>This is a very basic script for converting a paste of your exam timetable (from <a href="https://my.manchester.ac.uk/">my.manchester.ac.uk</a>) into a .ics file to import into your favourite calendar application.</p>
                    <p>It should work with anyone using the latest version of Blackboard to manage their exams, but was developed for Manchester University!</p>

                    <p>If you notice any bugs or problems, please let me know! My contact details are on my <a href="http://www.pezcuckow.com" target="_blank">personal site</a>.</p>
                    <p>You can also sent a <a href="https://github.com/Pezmc/Exam-to-iCal/pulls">pull request</a> or dig through the code on <a href="https://github.com/Pezmc/Exam-to-iCal">GitHub.com</a>.</p>
                    <p><i>Note this was written in 2011 and may be out of date, though I'll do my best to keep it working!</i></p>
                </div>
            </div>

            <div class="line"></div>

            <div class="article" id="article2">
                <h2>Use It</h2>

                <div class="line"></div>

                <div class="articleBody clear">

                    <p>Simply paste your exam timetable from the <a href="https://my.manchester.ac.uk/">portal</a> below</p>
                    <p><b>Note: </b>Do not copy the top line!</p>
                    <form action="examiCal.php" method="post" target="_blank">
                      <p>Data:</p>
                      <textarea name="data" style="width:80%;height:200px;"></textarea><br />
                      
                      <div style="display: none">
                      If you can read this, don't fill in the following text fields.<br>
                      
                        <input type="text" name="email" value="email@email.com"><br>
                        <textarea cols="40" rows="6" name="comment"></textarea>
                      </div>
                      
                      <input type="submit" />
                    </form>
                    <div class="line"></div>
                    <p>E.g. I paste in:</p>
<pre>BMAN10621BT	Fundamentals of Financial Reporting	16-Jan-12	Location 1	0	9:45 AM	12:25 PM
COMP23420T	Software Engineering	18-Jan-12	Location 2	0	9:45 AM	11:30 AM
etc…
</pre>
                </div>
            </div>
            
            <div class="line"></div>

            <div class="article" id="article3">
                <h2>Source</h2>
                <div class="line"></div>

                <div class="articleBody clear">
                  <p>Interested in how this works or want to develop something similar with PHP, you can see the (hacked together) source below:</p>
                  <?php highlight_file("examiCal.php"); ?><br /><br />
                  <p>If you have a patch suggestion, comments or are just looking for more information please get in touch! Contact info at <a href="http://www.pezcuckow.com">PezCuckow.com</a> (top right).</p>
                </div>
              
            </div>
            
            <div class="article" id="article4">
                <h2>Thanks</h2>
                <div class="line"></div>

                <div class="articleBody clear">
                  <p>Thanks for using this script, I hope you found it of use!</p>
                  <p>If you have any comments (constructive or otherwise), bugs or questions please contact me on the details provided at my <a href="http://www.pezcuckow.com">homepage</a> (top right).</p>
                  <p>Actually while you're here why don't you visit my <a href="http://www.pezcuckow.com">website</a>, and learn more about me, do you even know who I am?</p>
                  <p>If you're feeling particularly thankful you could <a href="http://goo.gl/j5NEO" target="_blank">put towards</a> my next cup to tea!</p>
                </div>
              
            </div>

        </div>

        <div class="footer">
            <div class="line"></div>
            <p>
              Copyright Pez Cuckow <?php echo date("Y"); ?> &copy; - <a href="http://www.pezcuckow.com">PezCuckow.com</a>
            </p>
            <a href="#" class="up">Go to Top</a> 
        </div>
        <span id="tos">Terms of Use: You owe Pez a drink or something :-) | You also assume full responsibly for any output from this script!</span>
        
    </div>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
    <script type="text/javascript" src="examiCal/jquery.scrollTo-1.4.2/jquery.scrollTo-min.js"></script>
    <script type="text/javascript" src="examiCal/script.js"></script>
    <?php include("analytics.php"); ?>
</body>
</html>
