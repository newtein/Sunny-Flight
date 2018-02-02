<!DOCTYPE HTML>
<html lang="en">
<head>
    <link rel="stylesheet" href="assets/stylesheet.css"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Sunny Flight</title>
    
    <?php include 'calender.php'; ?>
    
</head>
<body class="index">
    <div class="container">

        <center><h1> <font face="comic sans ms" size="40">Sunny Flight </font></h1></center>
        <center> <font face="verdana" size="5">Enjoy your window seat...!! </font></center>
        <div class="mainform">
            <marquee direction=right> <img src="assets/marqueeplane.gif"> </marquee>
            <center>
                <form action="result.php" method="GET">
                    <table cellpadding=6 id="tablesize">

                        <tr> 
                            <td><b>Flight Number</b> </td> 
                        </tr>
                        <tr> 
                            <td> <input style="height:30px;" size=20 name="flightno" value="LH452"> </td> 
                        </tr>

                        <tr> 
                            <td> <label for="start_date"><b>Departure</b> date</label> </td> 
                        </tr>

                        <tr> 
                            <td> <input type="text" id="start_date" name="start_date" style="height:30px;">  </td>  
                        </tr>

                        <tr>
                            <td><label for="start_time"><b>Departure</b> time</label>  </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" name="start_time" id="start_time" 
                                       value="10:00" size="5" maxlength="5" style="height:30px;"> 
                                <font size="2">hh:mm</font>
                            </td>
                        </tr>

                        <tr> 
                            <td><center> <font face="comic sans ms"> Which side will be sunny? </font> </center> </td> 
                        </tr>

                        <tr> 
                            <td><center> <input type="submit" value="Calculate!" class="classname"></center> </td> 
                        </tr>

                    </table>
                </form>

            </center>
            <div><font size="3px">Find out more about this app <a href="project.php">here</a>.</font> </div> 
        </div>
    </div>
</body>
</html>